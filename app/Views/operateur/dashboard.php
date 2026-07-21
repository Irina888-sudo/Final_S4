<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard Opérateur - MOMO PAY') ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <?php
        $hasAlertes = ! empty($alertes['baremes_manquants'])
            || ! empty($alertes['soldes_eleves'])
            || ! empty($alertes['prefixes_incoherents'])
            || $alertes['inactivite'] !== null;
    ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Tableau de bord</span>
                <h1>Dashboard Opérateur</h1>
                <p>Vue d'ensemble de votre activité, gains et alertes en temps réel.</p>
            </div>
        </header>

        <main class="op-main">

            <?php if ($hasAlertes): ?>
                <section class="op-alertes">
                    <?php if (! empty($alertes['baremes_manquants'])): ?>
                        <div class="op-alerte op-alerte-warning op-alerte-detaillee" onclick="toggleAlerte(this)">
                            <div class="op-alerte-header">
                                <span class="op-alerte-icon">⚠️</span>
                                <div class="op-alerte-text">
                                    <strong><?= count($alertes['baremes_manquants']) ?> transaction(s)</strong>
                                    récente(s) sans frais appliqué (barème manquant).
                                </div>
                                <a href="<?= base_url('operateur/types-baremes') ?>" class="op-alerte-link" onclick="event.stopPropagation();">
                                    Vérifier les barèmes
                                </a>
                                <span class="op-alerte-badge"><?= count($alertes['baremes_manquants']) ?></span>
                                <span class="op-alerte-chevron">▾</span>
                            </div>

                            <div class="op-alerte-body">
                                <div class="op-table-wrap">
                                    <table class="op-table op-alerte-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Client</th>
                                                <th>Type</th>
                                                <th class="op-table-num">Montant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($alertes['baremes_manquants'] as $t): ?>
                                                <tr>
                                                    <td data-label="Date"><?= esc($t['date_creation']) ?></td>
                                                    <td data-label="Client">
                                                        <?= esc($t['nom']) ?>
                                                        <span class="op-phone-sm">(<?= esc($t['telephone']) ?>)</span>
                                                    </td>
                                                    <td data-label="Type"><?= esc(ucfirst($t['type_libelle'])) ?></td>
                                                    <td class="op-table-num" data-label="Montant">
                                                        <strong class="op-money"><?= esc(number_format((float) $t['montant'], 0, ',', ' ')) ?> Ar</strong>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($alertes['soldes_eleves'])): ?>
                        <div class="op-alerte op-alerte-warning">
                            <span class="op-alerte-icon">⚠️</span>
                            <div class="op-alerte-text">
                                <strong><?= count($alertes['soldes_eleves']) ?> compte(s)</strong>
                                avec un solde supérieur à 1 000 000 Ar.
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($alertes['prefixes_incoherents'])): ?>
                        <div class="op-alerte op-alerte-warning">
                            <span class="op-alerte-icon">⚠️</span>
                            <div class="op-alerte-text">
                                <strong><?= count($alertes['prefixes_incoherents']) ?> préfixe(s) inactif(s)</strong>
                                ont encore des clients rattachés.
                            </div>
                            <a href="<?= base_url('operateur/prefixes') ?>" class="op-alerte-link">Vérifier les préfixes</a>
                        </div>
                    <?php endif; ?>

                    <?php if ($alertes['inactivite'] !== null): ?>
                        <div class="op-alerte op-alerte-info">
                            <span class="op-alerte-icon">ℹ️</span>
                            <div class="op-alerte-text">
                                Aucune transaction depuis
                                <strong><?= esc($alertes['inactivite']) ?> jour(s)</strong>.
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <!-- KPIs -->
            <section class="op-kpi-grid">
                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Aujourd'hui</span>
                    <strong class="op-stat-value"><?= esc(number_format((int) $kpis['volume']['aujourdhui'], 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Transactions du jour</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Cette semaine</span>
                    <strong class="op-stat-value"><?= esc(number_format((int) $kpis['volume']['cette_semaine'], 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Transactions sur 7 jours</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Total</span>
                    <strong class="op-stat-value"><?= esc(number_format((int) $kpis['volume']['total'], 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Transactions cumulées</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Volume</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $kpis['montant_total'], 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Montant total transactionné</span>
                </article>

                <!-- Nouveaux KPI Highlights -->
                <div class="op-kpi-card op-kpi-highlight">
                    <p class="op-kpi-label">Frais collectés (dépôt/retrait/transfert)</p>
                    <p class="op-kpi-value"><?= number_format($kpis['gains_bruts'], 0) ?> Ar</p>
                </div>

                <div class="op-kpi-card op-kpi-highlight">
                    <p class="op-kpi-label">Commission transferts externes (<?= $kpis['pourcentage'] ?>%)</p>
                    <p class="op-kpi-value"><?= number_format($kpis['commission_externe'], 0) ?> Ar</p>
                </div>

                <div class="op-kpi-card op-kpi-highlight">
                    <p class="op-kpi-label">Revenu total opérateur</p>
                    <p class="op-kpi-value"><?= number_format($kpis['gains_totaux'], 0) ?> Ar</p>
                </div>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Clients actifs</span>
                    <strong class="op-stat-value"><?= esc(number_format((int) $kpis['clients_actifs'], 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Clients actifs ce mois</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Circulation</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $kpis['solde_total'], 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Solde total en circulation</span>
                </article>
            </section>

            <!-- Graphiques -->
            <section class="op-charts-grid">

                <article class="op-panel op-chart-panel">
                    <div class="op-panel-head op-panel-head-compact">
                        <div>
                            <h2>Évolution des gains</h2>
                            <p>7 derniers jours</p>
                        </div>
                        <span class="op-badge">GAINS</span>
                    </div>
                    <?php if (empty($graphiques['evolution_gains'])): ?>
                        <div class="op-chart-empty">Aucune donnée disponible.</div>
                    <?php else: ?>
                        <div class="op-chart-canvas-wrap">
                            <canvas id="evolutionGainsChart"></canvas>
                        </div>
                    <?php endif; ?>
                </article>

                <article class="op-panel op-chart-panel">
                    <div class="op-panel-head op-panel-head-compact">
                        <div>
                            <h2>Répartition des opérations</h2>
                            <p>Par type d'opération</p>
                        </div>
                        <span class="op-badge">TYPES</span>
                    </div>
                    <?php if (empty($graphiques['repartition'])): ?>
                        <div class="op-chart-empty">Aucune donnée disponible.</div>
                    <?php else: ?>
                        <div class="op-chart-canvas-wrap op-chart-canvas-wrap-pie">
                            <canvas id="repartitionChart"></canvas>
                        </div>
                    <?php endif; ?>
                </article>

                <article class="op-panel op-chart-panel">
                    <div class="op-panel-head op-panel-head-compact">
                        <div>
                            <h2>Top 5 préfixes</h2>
                            <p>Par nombre de transactions</p>
                        </div>
                        <span class="op-badge">PRÉFIXES</span>
                    </div>
                    <?php if (empty($graphiques['top_prefixes'])): ?>
                        <div class="op-chart-empty">Aucune donnée disponible.</div>
                    <?php else: ?>
                        <div class="op-chart-canvas-wrap">
                            <canvas id="topPrefixesChart"></canvas>
                        </div>
                    <?php endif; ?>
                </article>

                <article class="op-panel op-chart-panel">
                    <div class="op-panel-head op-panel-head-compact">
                        <div>
                            <h2>Top 5 clients</h2>
                            <p>Par volume transactionné</p>
                        </div>
                        <span class="op-badge">CLIENTS</span>
                    </div>
                    <?php if (empty($graphiques['top_clients'])): ?>
                        <div class="op-chart-empty">Aucune donnée disponible.</div>
                    <?php else: ?>
                        <div class="op-chart-canvas-wrap">
                            <canvas id="topClientsChart"></canvas>
                        </div>
                    <?php endif; ?>
                </article>

            </section>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>

    <script>
    /* Couleurs MOMO PAY pour Chart.js */
    const OP_CHART = {
        accent: '#00d1ff',
        accentSoft: 'rgba(0, 209, 255, 0.15)',
        success: '#14d9c4',
        purple: '#7c5cff',
        orange: '#ffb84d',
        pink: '#ff6b7a',
        grid: 'rgba(255, 255, 255, 0.06)',
        text: '#8b95a8',
        palette: ['#00d1ff', '#14d9c4', '#7c5cff', '#ffb84d', '#ff6b7a'],
    };

    const chartDefaults = {
        color: OP_CHART.text,
        borderColor: OP_CHART.grid,
    };

    Chart.defaults.color = OP_CHART.text;
    Chart.defaults.borderColor = OP_CHART.grid;
    Chart.defaults.font.family = 'inherit';

    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: OP_CHART.text,
                    boxWidth: 12,
                    padding: 16,
                },
            },
        },
        scales: {
            x: {
                grid: { color: OP_CHART.grid },
                ticks: { color: OP_CHART.text },
            },
            y: {
                grid: { color: OP_CHART.grid },
                ticks: { color: OP_CHART.text },
            },
        },
    };

    <?php if (! empty($graphiques['evolution_gains'])): ?>
    new Chart(document.getElementById('evolutionGainsChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode(array_map(fn($e) => $e['jour'], $graphiques['evolution_gains'])) ?>,
            datasets: [{
                label: 'Gains (Ar)',
                data: <?= json_encode(array_map(fn($e) => (float) $e['total_frais'], $graphiques['evolution_gains'])) ?>,
                borderColor: OP_CHART.accent,
                backgroundColor: OP_CHART.accentSoft,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: OP_CHART.accent,
                pointBorderColor: '#070b14',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            ...baseOptions,
            plugins: { legend: { display: false } },
        }
    });
    <?php endif; ?>

    <?php if (! empty($graphiques['repartition'])): ?>
    new Chart(document.getElementById('repartitionChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_map(fn($r) => ucfirst($r['libelle']), $graphiques['repartition'])) ?>,
            datasets: [{
                data: <?= json_encode(array_map(fn($r) => (int) $r['nombre'], $graphiques['repartition'])) ?>,
                backgroundColor: OP_CHART.palette,
                borderColor: '#070b14',
                borderWidth: 2,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: OP_CHART.text, padding: 14 },
                },
            },
        }
    });
    <?php endif; ?>

    <?php if (! empty($graphiques['top_prefixes'])): ?>
    new Chart(document.getElementById('topPrefixesChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(fn($p) => $p['code'], $graphiques['top_prefixes'])) ?>,
            datasets: [{
                label: 'Transactions',
                data: <?= json_encode(array_map(fn($p) => (int) $p['nombre'], $graphiques['top_prefixes'])) ?>,
                backgroundColor: 'rgba(0, 209, 255, 0.75)',
                hoverBackgroundColor: OP_CHART.accent,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            ...baseOptions,
            plugins: { legend: { display: false } },
        }
    });
    <?php endif; ?>

    <?php if (! empty($graphiques['top_clients'])): ?>
    new Chart(document.getElementById('topClientsChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(fn($c) => $c['nom'], $graphiques['top_clients'])) ?>,
            datasets: [{
                label: 'Volume (Ar)',
                data: <?= json_encode(array_map(fn($c) => (float) $c['volume'], $graphiques['top_clients'])) ?>,
                backgroundColor: 'rgba(20, 217, 196, 0.75)',
                hoverBackgroundColor: OP_CHART.success,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            ...baseOptions,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
        }
    });
    <?php endif; ?>

    function toggleAlerte(element) {
        if (event && event.target.tagName === 'A') return;
        element.classList.toggle('ouverte');
    }
    </script>

</body>
</html>