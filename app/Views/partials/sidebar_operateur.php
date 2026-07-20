<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'MOMO PAY - Espace Opérateur' ?></title>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
    <!-- HEADER -->
    <header class="header">
        <div class="logo">MOMO PAY</div>
        <div class="header-actions">
            <div class="search-box">
                <input type="text" placeholder="Rechercher un client...">
            </div>
            <button class="icon-btn">
                🔔
                <span class="notif-dot"></span>
            </button>
            <div class="avatar">
                <?= substr(session()->get('operateur_username') ?? 'OP', 0, 2) ?>
            </div>
        </div>
    </header>

    <div class="grid-layout">
        <!-- SIDEBAR GAUCHE -->
        <div class="col-sidebar">
            <div class="card" style="padding:16px; height:100%;">
                <nav class="sidebar-nav">
                    <?php
                    $currentPage = $currentPage ?? '';
                    $navItems = [
                        'dashboard' => ['label' => 'Dashboard', 'url' => '/operateur/dashboard'],
                        'prefixes' => ['label' => 'Préfixes', 'url' => '/operateur/prefixes'],
                        'types-baremes' => ['label' => 'Types & Barèmes', 'url' => '/operateur/types-baremes'],
                        'commission' => ['label' => 'Commission', 'url' => '/operateur/commission'],
                        'situation-gains' => ['label' => 'Situation gains', 'url' => '/operateur/situation-gains'],
                        'situation-comptes' => ['label' => 'Situation comptes', 'url' => '/operateur/situation-comptes'],
                    ];
                    foreach ($navItems as $key => $item):
                        $active = ($currentPage === $key) ? 'active' : '';
                    ?>
                        <a href="<?= $item['url'] ?>" class="<?= $active ?>"><?= $item['label'] ?></a>
                    <?php endforeach; ?>
                </nav>
                <div class="sidebar-footer">
                    <a href="/operateur/logout">Déconnexion</a>
                </div>
            </div>
        </div>

        <!-- CONTENU PRINCIPAL -->
        <div class="col-main" style="grid-column: span 10;">
            <?= $content ?? '' ?>
        </div>
    </div>
</div>

</body>
</html>