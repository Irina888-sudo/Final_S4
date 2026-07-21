<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'MOMO PAY - Mobile Money') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/home/home-layout.css') ?>">
</head>
<body>

    <div class="home-page">
        <div class="home-container">

            <header class="home-brand">
                <span class="home-kicker">Mobile Money</span>
                <h1>MOMO PAY</h1>
                <p>Plateforme de gestion et de transactions mobile money.</p>
            </header>

            <section class="home-card">
                <h2 class="home-card-title">Bienvenue</h2>
                <p class="home-card-subtitle">Choisissez votre espace pour continuer</p>

                <div class="home-actions">
                    <a href="<?= base_url('operateur/login') ?>" class="home-btn home-btn-operator">
                        <span class="home-btn-icon">⚙️</span>
                        <span class="home-btn-text">
                            <strong>Espace Opérateur</strong>
                            <small>Gestion, barèmes, dashboard</small>
                        </span>
                    </a>

                    <a href="<?= base_url('client/login') ?>" class="home-btn home-btn-client">
                        <span class="home-btn-icon">👤</span>
                        <span class="home-btn-text">
                            <strong>Espace Client</strong>
                            <small>Dépôt, retrait, transfert</small>
                        </span>
                    </a>
                </div>
            </section>

            <footer class="home-footer">
                <p>&copy; <?= date('Y') ?> MOMO PAY — Tous droits réservés</p>
            </footer>

        </div>
    </div>

</body>
</html>