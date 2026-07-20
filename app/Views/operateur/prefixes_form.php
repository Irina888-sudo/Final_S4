<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
</head>
<body>
<?= view('partials/sidebar_operateur') ?>
<div class="op-content">
    <h1><?= isset($prefixe) ? 'Modifier' : 'Ajouter' ?> un préfixe</h1>

    <div class="form-card">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="form-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="/operateur/prefixes<?= isset($prefixe) ? '/' . $prefixe['id'] : '' ?>">
            <?= csrf_field() ?>

            <?php if (isset($prefixe)): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <div class="form-group">
                <label>Code (3 chiffres)</label>
                <input type="text" name="code" maxlength="3"
                       value="<?= isset($prefixe) ? $prefixe['code'] : '' ?>">
            </div>

            <div class="form-group">
                <label>Actif</label>
                <select name="actif">
                    <option value="1" <?= (isset($prefixe) && $prefixe['actif'] == 1) ? 'selected' : '' ?>>Oui</option>
                    <option value="0" <?= (isset($prefixe) && $prefixe['actif'] == 0) ? 'selected' : '' ?>>Non</option>
                </select>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="est_interne">
                    <option value="1" <?= (isset($prefixe) && $prefixe['est_interne'] == 1) ? 'selected' : '' ?>>Mon opérateur</option>
                    <option value="0" <?= (isset($prefixe) && $prefixe['est_interne'] == 0) ? 'selected' : '' ?>>Autre opérateur</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enregistrer</button>
                <a href="/operateur/prefixes" class="btn-cancel">Retour à la liste</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>