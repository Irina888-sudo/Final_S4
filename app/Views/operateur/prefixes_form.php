<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? ((isset($prefixe) ? 'Modifier' : 'Ajouter') . ' un préfixe - MOMO PAY')) ?></title>

    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-form.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_operateur', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="op-app">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Configuration</span>
                <h1><?= isset($prefixe) ? 'Modifier un préfixe' : 'Ajouter un préfixe' ?></h1>
                <p>
                    <?= isset($prefixe)
                        ? 'Mettez à jour le code et le statut de ce préfixe.'
                        : 'Créez un nouveau préfixe opérateur à 3 chiffres.' ?>
                </p>
            </div>

            <a href="<?= base_url('operateur/prefixes') ?>" class="op-btn op-btn-ghost">
                ← Retour à la liste
            </a>
        </header>

        <main class="op-main">
            <section class="op-panel op-form-card">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="op-alert op-alert-error" role="alert">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="op-alert op-alert-success" role="alert">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session('errors')): ?>
                    <div class="op-alert op-alert-error" role="alert">
                        <ul class="op-error-list">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form
                    method="post"
                    action="<?= base_url('operateur/prefixes' . (isset($prefixe) ? '/' . $prefixe['id'] : '')) ?>"
                    class="op-form"
                    novalidate
                >
                    <?= csrf_field() ?>

                    <?php if (isset($prefixe)): ?>
                        <input type="hidden" name="_method" value="PUT">
                    <?php endif; ?>

                    <div class="op-form-grid">
                        <div class="op-form-group op-form-group-full">
                            <label for="code">Code (3 chiffres)</label>
                            <div class="op-input-wrap">
                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    maxlength="3"
                                    minlength="3"
                                    pattern="[0-9]{3}"
                                    inputmode="numeric"
                                    placeholder="Ex: 032"
                                    value="<?= esc(old('code', $prefixe['code'] ?? '')) ?>"
                                    required
                                >
                            </div>
                            <small class="op-form-help">Le code doit contenir exactement 3 chiffres.</small>
                        </div>

                        <div class="op-form-group">
                            <label for="actif">Actif</label>
                            <div class="op-input-wrap">
                                <select id="actif" name="actif" required>
                                    <option value="1" <?= old('actif', $prefixe['actif'] ?? '1') == '1' ? 'selected' : '' ?>>
                                        Oui
                                    </option>
                                    <option value="0" <?= old('actif', $prefixe['actif'] ?? '1') == '0' ? 'selected' : '' ?>>
                                        Non
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="op-form-group">
                            <label for="est_interne">Type</label>
                            <div class="op-input-wrap">
                                <select id="est_interne" name="est_interne" required>
                                    <option value="1" <?= old('est_interne', $prefixe['est_interne'] ?? '1') == '1' ? 'selected' : '' ?>>
                                        Mon opérateur
                                    </option>
                                    <option value="0" <?= old('est_interne', $prefixe['est_interne'] ?? '1') == '0' ? 'selected' : '' ?>>
                                        Autre opérateur
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="op-form-actions">
                        <button type="submit" class="op-btn op-btn-primary">
                            <?= isset($prefixe) ? 'Mettre à jour' : 'Enregistrer' ?>
                        </button>

                        <a href="<?= base_url('operateur/prefixes') ?>" class="op-btn op-btn-ghost">
                            Annuler
                        </a>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="<?= base_url('js/operateur/theme.js') ?>"></script>
</body>
</html>