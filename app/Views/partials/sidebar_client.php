<div class="cl-sidebar">
    <div class="cl-sidebar-header">
        <h2 class="cl-sidebar-logo">MOMO PAY</h2>
        <span class="cl-sidebar-tag">Espace Client</span>
    </div>

    <nav class="cl-sidebar-nav">
        <?php
            $page = $currentPage ?? uri_string();
            $isActive = fn(string $path) => str_contains($page, $path) ? ' active' : '';
        ?>
        <a href="<?= base_url('client/dashboard') ?>" class="cl-nav-link<?= $isActive('client/dashboard') ?>">
            Dashboard
        </a>
        <a href="<?= base_url('client/depot') ?>" class="cl-nav-link<?= $isActive('client/depot') ?>">
            Dépôt
        </a>
        <a href="<?= base_url('client/retrait') ?>" class="cl-nav-link<?= $isActive('client/retrait') ?>">
            Retrait
        </a>
        <a href="<?= base_url('client/transfert') ?>" class="cl-nav-link<?= $isActive('client/transfert') ?>">
            Transfert
        </a>
        <a href="<?= base_url('client/transfert-multiple') ?>" class="cl-nav-link<?= $isActive('client/transfert-multiple') ?>">
            Envoi multiple
        </a>
        <a href="<?= base_url('client/historique') ?>" class="cl-nav-link<?= $isActive('client/historique') ?>">
            Historique
        </a>
    </nav>

    <div class="cl-sidebar-user">
        <p class="cl-sidebar-username"><?= esc(session()->get('client_nom')) ?></p>
        <p class="cl-sidebar-tel"><?= esc(session()->get('client_telephone')) ?></p>
        <a href="<?= base_url('client/logout') ?>" class="cl-sidebar-logout">Déconnexion</a>
    </div>
</div>