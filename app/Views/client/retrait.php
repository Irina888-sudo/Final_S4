<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retrait</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Faire un retrait</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/retrait') ?>" method="post">
        <?= csrf_field() ?>
        <label for="montant">Montant à retirer</label>
        <input type="number" name="montant" id="montant" step="0.01" min="1" required>
        <button type="submit">Retirer</button>
    </form>
</div>

</body>
</html>