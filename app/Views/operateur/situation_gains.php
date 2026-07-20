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
<h1>Situation des gains</h1>
<table border="1">
    <tr><th>Type</th><th>Nb opérations</th><th>Total frais</th></tr>
    <?php foreach ($gains as $g): ?>
    <tr>
        <td><?= ucfirst($g['libelle']) ?></td>
        <td><?= $g['nb'] ?></td>
        <td><?= $g['total_frais'] ?> Ar</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html>