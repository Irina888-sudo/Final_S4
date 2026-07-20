<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dépôt</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-tokens.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>"><link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Faire un dépôt</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/depot') ?>" method="post">
        <?= csrf_field() ?>
        <label for="montant">Montant à déposer</label>
        <input type="number" name="montant" id="montant" step="0.01" min="1" required>
        <button type="submit">Déposer</button>
    </form>
</div>

</body>
</html>