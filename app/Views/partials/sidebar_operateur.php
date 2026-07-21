<?php
$currentPage = $currentPage ?? uri_string();

$navItems = [
    'dashboard' => [
        'label' => 'Dashboard',
        'url'   => base_url('operateur/dashboard'),
        'icon'  => 'layout-dashboard',
    ],
    'prefixes' => [
        'label' => 'Préfixes',
        'url'   => base_url('operateur/prefixes'),
        'icon'  => 'hash',
    ],
    'types-baremes' => [
        'label' => 'Types & Barèmes',
        'url'   => base_url('operateur/types-baremes'),
        'icon'  => 'layers',
    ],
    'commission' => [
        'label' => 'Commission',
        'url'   => base_url('operateur/commission'),
        'icon'  => 'percent',
    ],
    'situation-gains' => [
        'label' => 'Situation gains',
        'url'   => base_url('operateur/situation-gains'),
        'icon'  => 'trending-up',
    ],
    'situation-comptes' => [
        'label' => 'Situation comptes',
        'url'   => base_url('operateur/situation-comptes'),
        'icon'  => 'wallet',
    ],
];

$indicators = $indicators ?? [
    ['label' => 'Objectif mensuel', 'value' => 72, 'color' => 'cyan'],
    ['label' => 'Taux de réussite', 'value' => 89, 'color' => 'teal'],
    ['label' => 'Liquidité comptes', 'value' => 64, 'color' => 'purple'],
];
?>

<aside class="op-sidebar" aria-label="Navigation principale">
    <div class="op-sidebar-top">
        <div class="op-logo">
            <span class="op-logo-icon" aria-hidden="true"></span>
            <span class="op-logo-text">MOMO PAY</span>
        </div>

        <button
            id="themeToggle"
            class="op-icon-btn"
            type="button"
            aria-label="Changer le thème"
            title="Changer le thème"
        >
            🌙
        </button>
    </div>

    <nav class="op-nav">
        <?php foreach ($navItems as $key => $item):
            $active = (strpos($currentPage, $key) !== false) ? 'active' : '';
        ?>
            <a
                href="<?= esc($item['url']) ?>"
                class="op-nav-link <?= $active ?>"
                data-icon="<?= esc($item['icon']) ?>"
            >
                <span class="op-nav-icon" aria-hidden="true"></span>
                <span class="op-nav-label"><?= esc($item['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    

    <div class="op-sidebar-footer">
        <a href="<?= base_url('operateur/logout') ?>" class="op-logout-link">
            <span class="op-logout-icon" aria-hidden="true"></span>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>