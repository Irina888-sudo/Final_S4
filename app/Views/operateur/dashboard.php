<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Opérateur</title>
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>

<?= view('partials/sidebar_operateur') ?>

<div class="op-content">
    <?php
$hasAlertes = ! empty($alertes['baremes_manquants'])
    || ! empty($alertes['soldes_eleves'])
    || ! empty($alertes['prefixes_incoherents'])
    || $alertes['inactivite'] !== null;
?>

<?php if ($hasAlertes): ?>
<div class="op-alertes">
<?php if (! empty($alertes['baremes_manquants'])): ?>
<div class="op-alerte op-alerte-warning op-alerte-detaillee" onclick="toggleAlerte(this)">
    <div class="op-alerte-header">
        ⚠️ <strong><?= count($alertes['baremes_manquants']) ?> transaction(s)</strong> récente(s) sans frais appliqué (barème manquant).
        <a href="<?= base_url('operateur/types-baremes') ?>" onclick="event.stopPropagation();">Vérifier les barèmes</a>
        <span class="op-alerte-badge"><?= count($alertes['baremes_manquants']) ?></span>
    </div>

    <table class="op-alerte-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Type</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alertes['baremes_manquants'] as $t): ?>
                <tr>
                    <td><?= esc($t['date_creation']) ?></td>
                    <td><?= esc($t['nom']) ?> (<?= esc($t['telephone']) ?>)</td>
                    <td><?= esc(ucfirst($t['type_libelle'])) ?></td>
                    <td><strong><?= number_format($t['montant'], 0) ?> Ar</strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

    <?php if (! empty($alertes['soldes_eleves'])): ?>
        <div class="op-alerte op-alerte-warning">
            ⚠️ <strong><?= count($alertes['soldes_eleves']) ?> compte(s)</strong> avec un solde supérieur à 1 000 000 Ar.
        </div>
    <?php endif; ?>

    <?php if (! empty($alertes['prefixes_incoherents'])): ?>
        <div class="op-alerte op-alerte-warning">
            ⚠️ <strong><?= count($alertes['prefixes_incoherents']) ?> préfixe(s) inactif(s)</strong> ont encore des clients rattachés.
            <a href="<?= base_url('operateur/prefixes') ?>">Vérifier les préfixes</a>
        </div>
    <?php endif; ?>

    <?php if ($alertes['inactivite'] !== null): ?>
        <div class="op-alerte op-alerte-info">
            ℹ️ Aucune transaction depuis <strong><?= $alertes['inactivite'] ?> jour(s)</strong>.
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
    <h1>Dashboard Opérateur</h1>

    <div class="op-kpi-grid">
        <div class="op-kpi-card">
            <p class="op-kpi-label">Transactions aujourd'hui</p>
            <p class="op-kpi-value"><?= $kpis['volume']['aujourdhui'] ?></p>
        </div>
        <div class="op-kpi-card">
            <p class="op-kpi-label">Transactions cette semaine</p>
            <p class="op-kpi-value"><?= $kpis['volume']['cette_semaine'] ?></p>
        </div>
        <div class="op-kpi-card">
            <p class="op-kpi-label">Total transactions</p>
            <p class="op-kpi-value"><?= $kpis['volume']['total'] ?></p>
        </div>
        <div class="op-kpi-card">
            <p class="op-kpi-label">Montant total transactionné</p>
            <p class="op-kpi-value"><?= number_format($kpis['montant_total'], 0) ?> Ar</p>
        </div>
        <div class="op-kpi-card op-kpi-highlight">
            <p class="op-kpi-label">Gains bruts</p>
            <p class="op-kpi-value"><?= number_format($kpis['gains_bruts'], 0) ?> Ar</p>
        </div>
        <div class="op-kpi-card op-kpi-highlight">
            <p class="op-kpi-label">Gains nets (<?= $kpis['pourcentage'] ?>%)</p>
            <p class="op-kpi-value"><?= number_format($kpis['gains_nets'], 0) ?> Ar</p>
        </div>
        <div class="op-kpi-card">
            <p class="op-kpi-label">Clients actifs ce mois</p>
            <p class="op-kpi-value"><?= $kpis['clients_actifs'] ?></p>
        </div>
        <div class="op-kpi-card">
            <p class="op-kpi-label">Solde total en circulation</p>
            <p class="op-kpi-value"><?= number_format($kpis['solde_total'], 0) ?> Ar</p>
        </div>
    </div>

    <div class="op-charts-grid">
        <div class="op-chart-container">
            <h3>Évolution des gains (7 derniers jours)</h3>
            <?php if (empty($graphiques['evolution_gains'])): ?>
                <p>Aucune donnée.</p>
            <?php else: ?>
                <canvas id="evolutionGainsChart"></canvas>
            <?php endif; ?>
        </div>

        <div class="op-chart-container">
            <h3>Répartition des opérations</h3>
            <?php if (empty($graphiques['repartition'])): ?>
                <p>Aucune donnée.</p>
            <?php else: ?>
                <canvas id="repartitionChart"></canvas>
            <?php endif; ?>
        </div>

        <div class="op-chart-container">
            <h3>Top 5 préfixes</h3>
            <?php if (empty($graphiques['top_prefixes'])): ?>
                <p>Aucune donnée.</p>
            <?php else: ?>
                <canvas id="topPrefixesChart"></canvas>
            <?php endif; ?>
        </div>

        <div class="op-chart-container">
            <h3>Top 5 clients</h3>
            <?php if (empty($graphiques['top_clients'])): ?>
                <p>Aucune donnée.</p>
            <?php else: ?>
                <canvas id="topClientsChart"></canvas>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
<?php if (! empty($graphiques['evolution_gains'])): ?>
new Chart(document.getElementById('evolutionGainsChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_map(fn($e) => $e['jour'], $graphiques['evolution_gains'])) ?>,
        datasets: [{
            label: 'Gains (Ar)',
            data: <?= json_encode(array_map(fn($e) => (float) $e['total_frais'], $graphiques['evolution_gains'])) ?>,
            borderColor: '#2c3e50',
            backgroundColor: 'rgba(44, 62, 80, 0.1)',
            fill: true,
            tension: 0.2,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
<?php endif; ?>

<?php if (! empty($graphiques['repartition'])): ?>
new Chart(document.getElementById('repartitionChart'), {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_map(fn($r) => ucfirst($r['libelle']), $graphiques['repartition'])) ?>,
        datasets: [{
            data: <?= json_encode(array_map(fn($r) => (int) $r['nombre'], $graphiques['repartition'])) ?>,
            backgroundColor: ['#27ae60', '#e67e22', '#2980b9'],
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
<?php endif; ?>

<?php if (! empty($graphiques['top_prefixes'])): ?>
new Chart(document.getElementById('topPrefixesChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($p) => $p['code'], $graphiques['top_prefixes'])) ?>,
        datasets: [{
            label: 'Nombre de transactions',
            data: <?= json_encode(array_map(fn($p) => (int) $p['nombre'], $graphiques['top_prefixes'])) ?>,
            backgroundColor: '#2c3e50',
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
<?php endif; ?>

<?php if (! empty($graphiques['top_clients'])): ?>
new Chart(document.getElementById('topClientsChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($c) => $c['nom'], $graphiques['top_clients'])) ?>,
        datasets: [{
            label: 'Volume transactionné (Ar)',
            data: <?= json_encode(array_map(fn($c) => (float) $c['volume'], $graphiques['top_clients'])) ?>,
            backgroundColor: '#27ae60',
        }]
    },
    options: { responsive: true, indexAxis: 'y', plugins: { legend: { display: false } } }
});
<?php endif; ?>

function toggleAlerte(element) {
    // Empêche le toggle si on clique sur un lien
    if (event && event.target.tagName === 'A') return;
    
    element.classList.toggle('ouverte');
}

// Optionnel : fermer les autres alertes quand on en ouvre une
function toggleAlerteExclusive(element) {
    if (event && event.target.tagName === 'A') return;
    
    const toutes = document.querySelectorAll('.op-alerte-detaillee');
    toutes.forEach(el => {
        if (el !== element) el.classList.remove('ouverte');
    });
    element.classList.toggle('ouverte');
}
</script>

</body>
</html>