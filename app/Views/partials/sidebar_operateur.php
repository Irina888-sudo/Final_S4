<div class="op-sidebar">
    <div class="op-sidebar-header">
        <h2>Mobile Money</h2>
        <span class="op-sidebar-tag">Espace Opérateur</span>
    </div>

    <nav class="op-sidebar-nav">
        <a href="<?= base_url('operateur/dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('operateur/prefixes') ?>">Préfixes</a>
        <a href="<?= base_url('operateur/types-baremes') ?>">Types &amp; Barèmes</a>
         <a href="<?= base_url('operateur/commission') ?>">Commission externe</a>  
        <a href="<?= base_url('operateur/situation-gains') ?>">Situation Gains</a>
        <a href="<?= base_url('operateur/situation-comptes') ?>">Situation Comptes</a>
    </nav>

    <div class="op-sidebar-user">
        <p class="op-sidebar-username"><?= esc(session()->get('operateur_username')) ?></p>
        <a href="<?= base_url('operateur/logout') ?>" class="op-sidebar-logout">Déconnexion</a>
    </div>
</div>