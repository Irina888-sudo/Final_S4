<div class="cl-sidebar">
    <div class="cl-sidebar-header">
        <h2>Mobile Money</h2>
        <span class="cl-sidebar-tag">Espace Client</span>
    </div>

    <nav class="cl-sidebar-nav">
        <a href="<?= base_url('client/dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('client/depot') ?>">Dépôt</a>
        <a href="<?= base_url('client/retrait') ?>">Retrait</a>
        <a href="<?= base_url('client/transfert') ?>">Transfert</a>
        <a href="<?= base_url('client/historique') ?>">Historique</a>
    </nav>

    <div class="cl-sidebar-user">
        <p class="cl-sidebar-username"><?= esc(session()->get('client_nom')) ?></p>
        <p class="cl-sidebar-tel"><?= esc(session()->get('client_telephone')) ?></p>
        <a href="<?= base_url('client/logout') ?>" class="cl-sidebar-logout">Déconnexion</a>
    </div>
</div>