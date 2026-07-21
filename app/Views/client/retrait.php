<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Retrait - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_client', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="cl-content">

        <header class="cl-page-header">
            <div class="cl-page-header-text">
                <span class="cl-page-kicker">Transactions</span>
                <h1>Faire un retrait</h1>
                <p>Retirez des fonds depuis votre compte client.</p>
            </div>
        </header>

        <div class="form-card">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="form-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="form-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($solde)): ?>
                <p class="current-value">
                    Solde disponible :
                    <strong><?= esc(number_format((float) $solde, 0, ',', ' ')) ?> Ar</strong>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('client/retrait') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="montant">Montant à retirer (Ar)</label>
                    <input
                        type="number"
                        name="montant"
                        id="montant"
                        step="0.01"
                        min="1"
                        <?php if (isset($solde)): ?>max="<?= esc((float) $solde) ?>"<?php endif; ?>
                        placeholder="Ex: 5000"
                        value="<?= esc(old('montant')) ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Retirer</button>
                    <a href="<?= base_url('client/dashboard') ?>" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>

    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>
</body>
</html>