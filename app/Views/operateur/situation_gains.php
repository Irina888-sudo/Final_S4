<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Situation des gains - MOMO PAY') ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <?php
        $totalFrais = array_sum(array_column($gains ?? [], 'total_frais'));
        $totalOps   = array_sum(array_column($gains ?? [], 'nb'));
        $totalDu    = array_sum(array_column($montants_dus ?? [], 'total_du'));
    ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Finances</span>
                <h1>Situation des gains</h1>
                <p>Synthèse des frais collectés et des montants dus aux autres opérateurs.</p>
            </div>
        </header>

        <main class="op-main">

            <!-- Cartes résumé -->
            <section class="op-stats-grid op-stats-grid-3">
                <article class="op-panel op-stat-card op-stat-card-highlight">
                    <span class="op-stat-label">Total gains</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $totalFrais, 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Frais cumulés sur toutes les opérations</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Opérations</span>
                    <strong class="op-stat-value"><?= esc(number_format((int) $totalOps, 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Nombre total d'opérations enregistrées</span>
                </article>

                <article class="op-panel op-stat-card op-stat-card-warning">
                    <span class="op-stat-label">Montants dus</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $totalDu, 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Total à régler aux autres opérateurs</span>
                </article>
            </section>

            <!-- Gains par type -->
            <section class="op-panel">
                <div class="op-panel-head">
                    <div>
                        <h2>Gains par type d'opération</h2>
                        <p><?= count($gains ?? []) ?> type(s) d'opération</p>
                    </div>
                    <span class="op-badge">GAINS</span>
                </div>

                <?php if (empty($gains)): ?>
                    <div class="op-table-empty">
                        Aucune opération enregistrée pour le moment.
                    </div>
                <?php else: ?>
                    <div class="op-table-wrap">
                        <table class="op-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Nb opérations</th>
                                    <th class="op-table-num">Total frais</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gains as $g): ?>
                                    <tr>
                                        <td data-label="Type">
                                            <span class="op-type-label"><?= esc(ucfirst($g['libelle'])) ?></span>
                                        </td>
                                        <td data-label="Nb opérations">
                                            <span class="op-count"><?= esc(number_format((int) $g['nb'], 0, ',', ' ')) ?></span>
                                        </td>
                                        <td class="op-table-num" data-label="Total frais">
                                            <span class="op-fee op-fee-accent">
                                                <?= esc(number_format((float) $g['total_frais'], 0, ',', ' ')) ?> Ar
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="op-table-total">
                                    <td colspan="2"><strong>Total général</strong></td>
                                    <td class="op-table-num">
                                        <strong class="op-fee op-fee-accent">
                                            <?= esc(number_format((float) $totalFrais, 0, ',', ' ')) ?> Ar
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Montants dus -->
            <section class="op-panel">
                <div class="op-panel-head">
                    <div>
                        <h2>Montants dus aux autres opérateurs</h2>
                        <p><?= count($montants_dus ?? []) ?> opérateur(s) concerné(s)</p>
                    </div>
                    <span class="op-badge op-badge-warning">DETTES</span>
                </div>

                <?php if (empty($montants_dus)): ?>
                    <div class="op-table-empty">
                        Aucun montant dû pour le moment.
                    </div>
                <?php else: ?>
                    <div class="op-table-wrap">
                        <table class="op-table">
                            <thead>
                                <tr>
                                    <th>Préfixe</th>
                                    <th class="op-table-num">Total dû</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($montants_dus as $m): ?>
                                    <tr>
                                        <td data-label="Préfixe">
                                            <span class="op-prefix-badge"><?= esc($m['code']) ?></span>
                                        </td>
                                        <td class="op-table-num" data-label="Total dû">
                                            <span class="op-money op-money-warning">
                                                <?= esc(number_format((float) $m['total_du'], 0, ',', ' ')) ?> Ar
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="op-table-total">
                                    <td><strong>Total dû</strong></td>
                                    <td class="op-table-num">
                                        <strong class="op-money op-money-warning">
                                            <?= esc(number_format((float) $totalDu, 0, ',', ' ')) ?> Ar
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>