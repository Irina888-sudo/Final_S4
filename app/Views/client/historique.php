<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Historique - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-historique.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_client', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <?php
        $totalOps     = count($historique ?? []);
        $totalMontant = array_sum(array_column($historique ?? [], 'montant'));
        $totalFrais   = array_sum(array_column($historique ?? [], 'frais'));
    ?>

    <div class="cl-content">

        <header class="cl-page-header">
            <div class="cl-page-header-text">
                <span class="cl-page-kicker">Compte</span>
                <h1>Historique des transactions</h1>
                <p>Consultez l'ensemble de vos opérations passées.</p>
            </div>
        </header>

        <?php if (empty($historique)): ?>

            <section class="cl-panel cl-empty-state">
                <div class="cl-empty-icon">📋</div>
                <h2>Aucune transaction</h2>
                <p>Vous n'avez pas encore effectué d'opération sur votre compte.</p>
                <a href="<?= base_url('client/depot') ?>" class="cl-btn cl-btn-primary">
                    Faire un dépôt
                </a>
            </section>

        <?php else: ?>

            <section class="cl-kpi-grid cl-historique-stats">
                <div class="cl-kpi-card">
                    <p class="cl-kpi-label">Opérations</p>
                    <p class="cl-kpi-value"><?= esc(number_format($totalOps, 0, ',', ' ')) ?></p>
                </div>
                <div class="cl-kpi-card cl-kpi-highlight">
                    <p class="cl-kpi-label">Volume total</p>
                    <p class="cl-kpi-value"><?= esc(number_format((float) $totalMontant, 0, ',', ' ')) ?> Ar</p>
                </div>
                <div class="cl-kpi-card">
                    <p class="cl-kpi-label">Frais cumulés</p>
                    <p class="cl-kpi-value"><?= esc(number_format((float) $totalFrais, 0, ',', ' ')) ?> Ar</p>
                </div>
            </section>

            <section class="cl-panel">
                <div class="cl-panel-head">
                    <div>
                        <h2>Liste des transactions</h2>
                        <p><?= esc($totalOps) ?> opération(s) enregistrée(s)</p>
                    </div>
                    <span class="cl-badge">HISTORIQUE</span>
                </div>

                <div class="cl-table-wrap">
                    <table class="cl-table cl-historique-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th class="cl-table-num">Montant</th>
                                <th class="cl-table-num">Frais</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historique as $t): ?>
                                <?php
                                    $typeSlug = strtolower($t['type_libelle'] ?? '');
                                    $typeClass = 'cl-type-default';
                                    if (str_contains($typeSlug, 'depot')) {
                                        $typeClass = 'cl-type-depot';
                                    } elseif (str_contains($typeSlug, 'retrait')) {
                                        $typeClass = 'cl-type-retrait';
                                    } elseif (str_contains($typeSlug, 'transfert')) {
                                        $typeClass = 'cl-type-transfert';
                                    }
                                ?>
                                <tr>
                                    <td data-label="Date">
                                        <span class="cl-histo-date"><?= esc($t['date_creation']) ?></span>
                                    </td>
                                    <td data-label="Type">
                                        <span class="cl-type-badge <?= esc($typeClass) ?>">
                                            <?= esc(ucfirst($t['type_libelle'])) ?>
                                        </span>
                                    </td>
                                    <td class="cl-table-num" data-label="Montant">
                                        <span class="cl-money">
                                            <?= esc(number_format((float) $t['montant'], 0, ',', ' ')) ?> Ar
                                        </span>
                                    </td>
                                    <td class="cl-table-num" data-label="Frais">
                                        <span class="cl-fee">
                                            <?= esc(number_format((float) $t['frais'], 0, ',', ' ')) ?> Ar
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        <?php endif; ?>

    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>
</body>
</html>