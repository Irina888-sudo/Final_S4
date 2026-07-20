<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/home/home-layout.css') ?>">
</head>
<body>

<div class="home-container">
    <h1>Mobile Money</h1>
    <p class="home-subtitle">Choisissez votre espace</p>

    <div class="home-choices">
        <a href="<?= base_url('operateur/login') ?>" class="home-btn home-btn-operateur">
            Espace Opérateur
        </a>
        <a href="<?= base_url('client/login') ?>" class="home-btn home-btn-client">
            Espace Client
        </a>
    </div>
</div>

</body>
</html>