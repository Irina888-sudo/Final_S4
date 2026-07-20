<!DOCTYPE html>
<html lang="fr" data-theme="dark">
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

    <div class="form-card">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="form-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <p class="current-value">
            Taux actuel : <strong><?= $commission['pourcentage'] ?? 0 ?> %</strong>
        </p>

        <form method="post" action="/operateur/commission/update"">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Nouveau pourcentage</label>
                <input type="number" step="0.01" name="pourcentage" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>