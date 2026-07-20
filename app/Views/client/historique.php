<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-historique.css') ?>">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Historique des transactions</h1>

    <?php if (empty($historique)): ?>
        <p>Aucune transaction pour le moment.</p>
    <?php else: ?>
        <table class="cl-historique-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Frais</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $t): ?>
                    <tr>
                        <td><?= esc($t['date_creation']) ?></td>
                        <td><?= esc(ucfirst($t['type_libelle'])) ?></td>
                        <td><?= number_format($t['montant'], 2) ?> Ar</td>
                        <td><?= number_format($t['frais'], 2) ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>