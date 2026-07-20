<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transfert</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Faire un transfert</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/transfert') ?>" method="post">
        <?= csrf_field() ?>

        <label for="telephone_destinataire">Téléphone du destinataire</label>
        <input type="text" name="telephone_destinataire" id="telephone_destinataire" required>

        <label for="montant">Montant à transférer</label>
        <input type="number" name="montant" id="montant" step="0.01" min="1" required>

        <button type="submit">Transférer</button>
    </form>
</div>

</body>
</html>