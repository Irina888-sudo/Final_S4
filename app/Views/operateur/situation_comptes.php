<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
        <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <title>Document</title>
</head>
<body>

    <?= view('partials/sidebar_operateur') ?>
     <div class="op-content">
<!-- app/Views/operateur/situation_comptes.php -->
<h1>Situation des comptes clients</h1>
<table border="1">
    <tr><th>Téléphone</th><th>Nom</th><th>Solde</th></tr>
    <?php foreach ($comptes as $c): ?>
    <tr>
        <td><?= $c['telephone'] ?></td>
        <td><?= $c['nom'] ?></td>
        <td><?= $c['solde'] ?> Ar</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html>