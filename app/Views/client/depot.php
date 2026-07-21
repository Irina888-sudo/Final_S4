<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dépôt - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_client', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="cl-content">
        <header class="op-page-header">
            <div class="op-page-header-text">
                <span class="op-page-kicker">Transactions</span>
                <h1>Faire un dépôt</h1>
                <p>Créditez votre compte en quelques secondes.</p>
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
                    Solde actuel :
                    <strong><?= esc(number_format((float) $solde, 0, ',', ' ')) ?> Ar</strong>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('client/depot') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="montant">Montant à déposer (Ar)</label>
                    <input
                        type="number"
                        name="montant"
                        id="montant"
                        step="0.01"
                        min="1"
                        placeholder="Ex: 10000"
                        value="<?= esc(old('montant')) ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Déposer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>
</body>
</html>