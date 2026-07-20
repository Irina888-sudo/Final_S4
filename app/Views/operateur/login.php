<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money – Login Opérateur</title>
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-login.css') ?>">
    
</head>
<body>

<div class="op-login-container">
    <h2>Espace Opérateur</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="op-login-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('operateur/login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <a href="<?= base_url('/') ?>" class="op-login-back">&larr; Retour à l'accueil</a>
</div>

</body>
</html>