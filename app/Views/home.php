<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/home/home-layout.css') ?>">
</head>
<body>

<div class="home-container">
    <div class="title-card">
        <h1>Mobile Money</h1>
        <p>Choisissez votre espace</p>
    </div>

    <div class="card-content">
        <div class="title">Bienvenue</div>

        
        <a href="<?= base_url('operateur/login') ?>" class="card-btn">
            Espace Opérateur
        </a>
        
        <a href="<?= base_url('client/login') ?>" class="card-btn">
            Espace Client
        </a>
    </div>
</div>

</body>
</html>