<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard Client - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>

    <?= view('partials/sidebar_client', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="cl-content">

        <header class="cl-page-header">
            <div class="cl-page-header-text">
                <span class="cl-page-kicker">Espace client</span>
                <h1>Bienvenue, <?= esc($client_nom) ?></h1>
                <p>Consultez votre solde et l'activité de votre compte.</p>
            </div>
        </header>

        <div class="cl-solde-card">
            <p class="cl-solde-label">Solde actuel</p>
            <p class="cl-solde-montant"><?= esc(number_format((float) $solde, 0, ',', ' ')) ?> Ar</p>
        </div>

        <section class="cl-charts-grid">

            <div class="cl-chart-container">
                <h3>Répartition de vos opérations</h3>
                <?php if (empty($repartition)): ?>
                    <p>Aucune opération pour le moment.</p>
                <?php else: ?>
                    <canvas id="repartitionChart" height="220"></canvas>
                <?php endif; ?>
            </div>

            <div class="cl-chart-container">
                <h3>Évolution de votre solde</h3>
                <?php if (empty($evolution)): ?>
                    <p>Aucune donnée pour le moment.</p>
                <?php else: ?>
                    <canvas id="evolutionChart" height="220"></canvas>
                <?php endif; ?>
            </div>

        </section>
    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>

    <script>
    const CL_CHART = {
        accent: '#00d1ff',
        accentSoft: 'rgba(0, 209, 255, 0.15)',
        success: '#14d9c4',
        purple: '#7c5cff',
        orange: '#ffb84d',
        grid: 'rgba(255, 255, 255, 0.06)',
        text: '#94a3b8',
        palette: ['#00d1ff', '#14d9c4', '#7c5cff', '#ffb84d', '#ff6b7a'],
    };

    Chart.defaults.color = CL_CHART.text;
    Chart.defaults.borderColor = CL_CHART.grid;
    Chart.defaults.font.family = 'Inter, sans-serif';

    <?php if (! empty($repartition)): ?>
    new Chart(document.getElementById('repartitionChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_map(fn($r) => ucfirst($r['libelle']), $repartition)) ?>,
            datasets: [{
                data: <?= json_encode(array_map(fn($r) => (int) $r['total'], $repartition)) ?>,
                backgroundColor: CL_CHART.palette,
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
                    labels: { color: CL_CHART.text, padding: 14 },
                },
            },
        }
    });
    <?php endif; ?>

    <?php if (! empty($evolution)): ?>
    new Chart(document.getElementById('evolutionChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode(array_map(fn($e) => $e['date'], $evolution)) ?>,
            datasets: [{
                label: 'Solde (Ar)',
                data: <?= json_encode(array_map(fn($e) => (float) $e['solde'], $evolution)) ?>,
                borderColor: CL_CHART.accent,
                backgroundColor: CL_CHART.accentSoft,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: CL_CHART.accent,
                pointBorderColor: '#070b14',
                pointBorderWidth: 2,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { color: CL_CHART.grid },
                    ticks: { color: CL_CHART.text },
                },
                y: {
                    grid: { color: CL_CHART.grid },
                    ticks: { color: CL_CHART.text },
                },
            },
        }
    });
    <?php endif; ?>
    </script>

</body>
</html>