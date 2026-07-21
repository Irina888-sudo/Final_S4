<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Gestion des préfixes - MOMO PAY') ?></title>

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
                <h1>Gestion des préfixes</h1>
                <p>
                    Bienvenue, <strong><?= esc($operateur_username ?? 'Opérateur') ?></strong>.
                    Gérez les codes préfixes de votre opérateur.
                </p>
            </div>

            <a href="<?= base_url('operateur/prefixes/new') ?>" class="op-btn op-btn-primary">
                <span class="op-btn-icon">+</span>
                Ajouter un préfixe
            </a>
        </header>

        <main class="op-main">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="op-alert op-alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="op-alert op-alert-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (empty($prefixes)): ?>
                <section class="op-panel op-empty-state">
                    <div class="op-empty-icon">#</div>
                    <h2>Aucun préfixe configuré</h2>
                    <p>Ajoutez votre premier préfixe pour commencer.</p>
                    <a href="<?= base_url('operateur/prefixes/new') ?>" class="op-btn op-btn-primary">
                        Créer un préfixe
                    </a>
                </section>
            <?php else: ?>

                <section class="op-panel">
                    <div class="op-panel-head">
                        <div>
                            <h2>Liste des préfixes</h2>
                            <p><?= count($prefixes) ?> préfixe(s) enregistré(s)</p>
                        </div>
                    </div>

                    <div class="op-table-wrap">
                        <table class="op-table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Statut</th>
                                    <th>Type</th>
                                    <th class="op-table-actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($prefixes as $p): ?>
                                    <tr>
                                        <td data-label="Code">
                                            <span class="op-code-badge"><?= esc($p['code']) ?></span>
                                        </td>

                                        <td data-label="Statut">
                                            <?php if (!empty($p['actif'])): ?>
                                                <span class="op-status op-status-success">Actif</span>
                                            <?php else: ?>
                                                <span class="op-status op-status-muted">Inactif</span>
                                            <?php endif; ?>
                                        </td>

                                        <td data-label="Type">
                                            <?php if (!empty($p['est_interne'])): ?>
                                                <span class="op-badge">Mon opérateur</span>
                                            <?php else: ?>
                                                <span class="op-badge op-badge-muted">Externe</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="op-table-actions" data-label="Actions">
                                            <div class="op-action-group">
                                                <a
                                                    href="<?= base_url('operateur/prefixes/' . $p['id'] . '/edit') ?>"
                                                    class="op-btn op-btn-ghost op-btn-sm"
                                                >
                                                    Modifier
                                                </a>

                                                <form
                                                    method="post"
                                                    action="<?= base_url('operateur/prefixes/' . $p['id']) ?>"
                                                    class="op-inline-form"
                                                    onsubmit="return confirm('Supprimer ce préfixe ?');"
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
                </section>

            <?php endif; ?>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>