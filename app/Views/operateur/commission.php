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
    <!-- app/Views/operateur/commission.php -->
<h1>Configuration commission externe</h1>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<p>Taux actuel : <strong><?= $commission['pourcentage'] ?? 0 ?> %</strong></p>

<form method="post" action="/operateur/commission/update">
    <?= csrf_field() ?>
    <label>Nouveau pourcentage :</label>
    <input type="number" step="0.01" name="pourcentage" required>
    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>