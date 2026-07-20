<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Opérateur</title>
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
</head>
<body>

<?= view('partials/sidebar_operateur') ?>

<div class="op-content">
    <h1>Bienvenue, <?= esc($operateur_username) ?></h1>
</div>

</body>
</html>