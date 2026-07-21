!

<link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
<html lang="fr" data-theme="dark">
<aside class="op-sidebar">
    <button id="themeToggle" class="icon-btn">🌙</button>
    <div class="op-logo">MOMO PAY</div>

    <nav class="op-nav">
        <?php
        $currentPage = $currentPage ?? uri_string();
        $navItems = [
            'dashboard' => ['label' => 'Dashboard', 'url' => '/operateur/dashboard'],
            'prefixes' => ['label' => 'Préfixes', 'url' => '/operateur/prefixes'],
            'types-baremes' => ['label' => 'Types & Barèmes', 'url' => '/operateur/types-baremes'],
            'commission' => ['label' => 'Commission', 'url' => '/operateur/commission'],
            'situation-gains' => ['label' => 'Situation gains', 'url' => '/operateur/situation-gains'],
            'situation-comptes' => ['label' => 'Situation comptes', 'url' => '/operateur/situation-comptes'],
        ];
        foreach ($navItems as $key => $item):
            $active = (strpos($currentPage, $key) !== false) ? 'active' : '';
        ?>
            <a href="<?= $item['url'] ?>" class="<?= $active ?>"><?= $item['label'] ?></a>
        <?php endforeach; ?>
    </nav>

    <div class="op-sidebar-footer">
        <a href="/operateur/logout">Déconnexion</a>
    </div>
        </aside>
<script>
    const html = document.documentElement;
    const toggleBtn = document.getElementById('themeToggle');
    const saved = localStorage.getItem('theme') || 'dark';
    html.setAttribute('data-theme', saved);
    toggleBtn.textContent = saved === 'dark' ? '☀️' : '🌙';
    toggleBtn.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        toggleBtn.textContent = next === 'dark' ? '☀️' : '🌙';
    });
</script>