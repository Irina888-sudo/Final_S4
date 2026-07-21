<div class="grid-layout">
    <!-- CENTRE -->
    <div class="col-main" style="grid-column: span 8;">

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Vue d'ensemble</h2>
                <span class="badge-live"><span class="pulse-dot"></span> LIVE</span>
            </div>
            <div class="card-body">
                <div class="metrics-grid">
                    <div class="metric-card cyan">
                        <div class="metric-title">Total gains</div>
                        <div class="metric-value"><?= number_format($totalGains ?? 0, 0, ',', ' ') ?> Ar</div>
                        <div class="metric-detail">Ce mois-ci</div>
                    </div>
                    <div class="metric-card purple">
                        <div class="metric-title">Nombre de clients</div>
                        <div class="metric-value"><?= number_format($nbClients ?? 0, 0, ',', ' ') ?></div>
                        <div class="metric-detail">Total inscrits</div>
                    </div>
                    <div class="metric-card blue">
                        <div class="metric-title">Transactions du jour</div>
                        <div class="metric-value"><?= number_format($transactionsJour ?? 0, 0, ',', ' ') ?></div>
                        <div class="metric-detail">Dépôts & retraits</div>
                    </div>
                </div>

                <div class="tabs-bar">
                    <button onclick="showTab('activite')" id="tab-activite" class="tab-btn active">Activité</button>
                    <button onclick="showTab('transactions')" id="tab-transactions" class="tab-btn">Transactions</button>
                    <button onclick="showTab('comptes')" id="tab-comptes" class="tab-btn">Comptes</button>
                </div>

                <div id="content-activite" class="tab-content">
                    <div class="chart-placeholder">Graphique d'activité (Chart.js à intégrer si besoin)</div>
                </div>

                <div id="content-transactions" class="tab-content hidden">
                    <div class="tx-table">
                        <div class="tx-table-header">
                            <div>ID</div><div>Client</div><div>Type</div><div>Montant</div><div>Statut</div>
                        </div>
                        <?php foreach (($dernieresTransactions ?? []) as $t): ?>
                        <div class="tx-row">
                            <div class="tx-id">#<?= $t['id'] ?></div>
                            <div class="tx-client"><?= $t['client_nom'] ?></div>
                            <div class="tx-type"><?= ucfirst($t['type']) ?></div>
                            <div class="tx-amount"><?= number_format($t['montant'], 0, ',', ' ') ?> Ar</div>
                            <div><span class="status-badge success">réussie</span></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div id="content-comptes" class="tab-content hidden">
                    <div class="tx-table">
                        <div class="comptes-grid">
                            <?php foreach (($comptesResume ?? []) as $c): ?>
                            <div class="compte-item">
                                <div class="compte-nom"><?= $c['nom'] ?></div>
                                <div class="compte-tel"><?= $c['telephone'] ?></div>
                                <div class="compte-solde"><?= number_format($c['solde'], 0, ',', ' ') ?> Ar</div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- SIDEBAR DROITE -->
    <div class="col-right" style="grid-column: span 4;">
        <div class="card" style="margin-bottom:24px;">
            <div class="time-widget">
                <div class="time-label">HEURE ACTUELLE</div>
                <div class="time-value"><?= date('H:i:s') ?></div>
                <div class="time-date"><?= date('d M Y') ?></div>
            </div>
            <div class="mini-stats">
                <div class="mini-stat-box">
                    <div class="mini-stat-label">Gains du jour</div>
                    <div class="mini-stat-value"><?= number_format($gainsDuJour ?? 0, 0, ',', ' ') ?> Ar</div>
                </div>
                <div class="mini-stat-box">
                    <div class="mini-stat-label">Commission due</div>
                    <div class="mini-stat-value"><?= number_format($commissionDue ?? 0, 0, ',', ' ') ?> Ar</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Actions rapides</h3></div>
            <div class="actions-grid">
                <a href="/operateur/prefixes/new" class="action-btn">+ Préfixe</a>
                <a href="/operateur/types-baremes/new" class="action-btn">+ Barème</a>
                <a href="/operateur/situation-gains" class="action-btn">Gains</a>
                <a href="/operateur/situation-comptes" class="action-btn">Comptes</a>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(name) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('content-' + name).classList.remove('hidden');
    document.getElementById('tab-' + name).classList.add('active');
}
</script>