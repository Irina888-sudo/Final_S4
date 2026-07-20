<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Client</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Bienvenue, <?= esc($client_nom) ?></h1>

    <div class="cl-solde-card">
        <p class="cl-solde-label">Solde actuel</p>
        <p class="cl-solde-montant"><?= number_format($solde, 2) ?> Ar</p>
    </div>

    <div class="cl-chart-container">
        <h3>Répartition de vos opérations</h3>
        <?php if (empty($repartition)): ?>
            <p>Aucune opération pour le moment.</p>
        <?php else: ?>
            <canvas id="repartitionChart"></canvas>
        <?php endif; ?>
    </div>

    <div class="cl-chart-container">
        <h3>Évolution de votre solde</h3>
        <?php if (empty($evolution)): ?>
            <p>Aucune donnée pour le moment.</p>
        <?php else: ?>
            <canvas id="evolutionChart"></canvas>
        <?php endif; ?>
    </div>
</div>

<?php if (! empty($repartition)): ?>
<script>
    const ctx = document.getElementById('repartitionChart');

    const labels = <?= json_encode(array_map(fn($r) => ucfirst($r['libelle']), $repartition)) ?>;
    const data = <?= json_encode(array_map(fn($r) => (int) $r['total'], $repartition)) ?>;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#27ae60', '#e67e22', '#2980b9'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
<?php endif; ?>

<?php if (! empty($evolution)): ?>
<script>
    const ctxEvo = document.getElementById('evolutionChart');

    const evoLabels = <?= json_encode(array_map(fn($e) => $e['date'], $evolution)) ?>;
    const evoData = <?= json_encode(array_map(fn($e) => (float) $e['solde'], $evolution)) ?>;

    new Chart(ctxEvo, {
        type: 'line',
        data: {
            labels: evoLabels,
            datasets: [{
                label: 'Solde (Ar)',
                data: evoData,
                borderColor: '#27ae60',
                backgroundColor: 'rgba(39, 174, 96, 0.1)',
                fill: true,
                tension: 0.2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
<?php endif; ?>

</body>
</html>