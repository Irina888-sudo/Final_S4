<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? "Types d'opération & Barèmes - MOBILE MONEY") ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Configuration</span>
                <h1>Types d'opération & Barèmes</h1>
                <p>Gérez les types d'opération et leurs tranches de frais.</p>
            </div>

            <a href="<?= base_url('operateur/types-baremes/new') ?>" class="op-btn op-btn-primary">
                <span class="op-btn-icon">+</span>
                Ajouter un barème
            </a>
        </header>

        <main class="op-main">
            <?php if (empty($types)): ?>
                <section class="op-panel op-empty-state">
                    <div class="op-empty-icon">📋</div>
                    <h2>Aucun type d'opération</h2>
                    <p>Commencez par ajouter un barème pour configurer vos frais.</p>
                    <a href="<?= base_url('operateur/types-baremes/new') ?>" class="op-btn op-btn-primary">
                        Créer un barème
                    </a>
                </section>
            <?php else: ?>

                <?php foreach ($types as $type): ?>
                    <section class="op-panel op-type-card">
                        <div class="op-panel-head">
                            <div>
                                <h2><?= esc(ucfirst($type['libelle'])) ?></h2>
                                <p><?= count($type['baremes']) ?> barème(s) configuré(s)</p>
                            </div>

                            <span class="op-badge">
                                <?= esc(strtoupper($type['libelle'])) ?>
                            </span>
                        </div>

                        <?php if (empty($type['baremes'])): ?>
                            <div class="op-table-empty">
                                Aucun barème pour ce type.
                            </div>
                        <?php else: ?>
                            <div class="op-table-wrap">
                                <table class="op-table">
                                    <thead>
                                        <tr>
                                            <th>Min</th>
                                            <th>Max</th>
                                            <th>Frais</th>
                                            <th class="op-table-actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($type['baremes'] as $b): ?>
                                            <tr>
                                                <td data-label="Min">
                                                    <span class="op-money"><?= esc(number_format((float) $b['montant_min'], 0, ',', ' ')) ?> Ariary</span>
                                                </td>
                                                <td data-label="Max">
                                                    <span class="op-money"><?= esc(number_format((float) $b['montant_max'], 0, ',', ' ')) ?> Ariary</span>
                                                </td>
                                                <td data-label="Frais">
                                                    <span class="op-fee"><?= esc(number_format((float) $b['frais'], 0, ',', ' ')) ?> Ariary</span>
                                                </td>
                                                <td class="op-table-actions" data-label="Actions">
                                                    <div class="op-action-group">
                                                        <a
                                                            href="<?= base_url('operateur/types-baremes/' . $b['id'] . '/edit') ?>"
                                                            class="op-btn op-btn-ghost op-btn-sm"
                                                        >
                                                            Modifier
                                                        </a>

                                                        <form
                                                            method="post"
                                                            action="<?= base_url('operateur/types-baremes/' . $b['id']) ?>"
                                                            class="op-inline-form"
                                                            onsubmit="return confirm('Supprimer ce barème ?');"
                                                        >
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="op-btn op-btn-danger op-btn-sm">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>

            <?php endif; ?>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>