<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion Opérateur - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-login.css') ?>">
</head>
<body>

    <div class="op-login-page">
        <div class="op-login-container">
            <div class="op-login-brand">
                <span class="op-login-kicker">MOMO PAY</span>
                <h1>Espace Opérateur</h1>
                <p>Connectez-vous pour gérer votre activité mobile money.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="op-login-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form class="op-login-form" action="<?= base_url('operateur/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="op-login-field">
                    <label for="username">Nom d'utilisateur</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        placeholder="Votre identifiant"
                        value="<?= esc(old('username')) ?>"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="op-login-field">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="op-login-submit">Se connecter</button>
            </form>

            <a href="<?= base_url('/') ?>" class="op-login-back">&larr; Retour à l'accueil</a>
        </div>
    </div>

</body>
</html>