<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money – Login Client</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-tokens.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-login.css') ?>"><link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="cl-login-container">
    <h2>Espace Client</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-login-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="telephone">Numéro de téléphone</label>
        <input type="text" name="telephone" id="telephone" placeholder="0331234567" required>

        <button type="submit">Se connecter</button>
    </form>

    <a href="<?= base_url('/') ?>" class="cl-login-back">&larr; Retour à l'accueil</a>
</div>

</body>
</html>