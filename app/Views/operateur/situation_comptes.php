<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Situation des comptes clients - MOMO PAY') ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <?php
        $nbComptes   = count($comptes ?? []);
        $soldeTotal  = array_sum(array_column($comptes ?? [], 'solde'));
        $soldeMoyen  = $nbComptes > 0 ? $soldeTotal / $nbComptes : 0;
    ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Clients</span>
                <h1>Situation des comptes clients</h1>
                <p>Consultez les soldes de tous les comptes clients enregistrés.</p>
            </div>
        </header>

        <main class="op-main">

            <!-- Cartes résumé -->
            <section class="op-stats-grid op-stats-grid-3">
                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Comptes actifs</span>
                    <strong class="op-stat-value"><?= esc(number_format($nbComptes, 0, ',', ' ')) ?></strong>
                    <span class="op-stat-meta">Nombre total de clients</span>
                </article>

                <article class="op-panel op-stat-card op-stat-card-highlight">
                    <span class="op-stat-label">Solde cumulé</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $soldeTotal, 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Somme de tous les soldes clients</span>
                </article>

                <article class="op-panel op-stat-card">
                    <span class="op-stat-label">Solde moyen</span>
                    <strong class="op-stat-value"><?= esc(number_format((float) $soldeMoyen, 0, ',', ' ')) ?> Ar</strong>
                    <span class="op-stat-meta">Moyenne par compte client</span>
                </article>
            </section>

            <!-- Liste des comptes -->
            <section class="op-panel">
                <div class="op-panel-head">
                    <div>
                        <h2>Liste des comptes</h2>
                        <p><?= esc($nbComptes) ?> compte(s) enregistré(s)</p>
                    </div>
                    <span class="op-badge">COMPTES</span>
                </div>

                <?php if (empty($comptes)): ?>
                    <div class="op-table-empty">
                        Aucun compte client enregistré pour le moment.
                    </div>
                <?php else: ?>
                    <div class="op-table-wrap">
                        <table class="op-table op-table-comptes">
                            <thead>
                                <tr>
                                    <th>Téléphone</th>
                                    <th>Nom</th>
                                    <th class="op-table-num">Solde</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comptes as $c): ?>
                                    <?php
                                        $solde = (float) ($c['solde'] ?? 0);
                                        $soldeClass = $solde < 0
                                            ? 'op-balance-negative'
                                            : ($solde === 0.0 ? 'op-balance-zero' : 'op-balance-positive');
                                    ?>
                                    <tr>
                                        <td data-label="Téléphone">
                                            <span class="op-phone"><?= esc($c['telephone']) ?></span>
                                        </td>
                                        <td data-label="Nom">
                                            <span class="op-client-name"><?= esc($c['nom']) ?></span>
                                        </td>
                                        <td class="op-table-num" data-label="Solde">
                                            <span class="op-balance <?= esc($soldeClass) ?>">
                                                <?= esc(number_format($solde, 0, ',', ' ')) ?> Ar
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="op-table-total">
                                    <td colspan="2"><strong>Total général</strong></td>
                                    <td class="op-table-num">
                                        <strong class="op-balance op-balance-positive">
                                            <?= esc(number_format((float) $soldeTotal, 0, ',', ' ')) ?> Ar
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