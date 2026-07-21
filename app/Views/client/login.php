<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion Client - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-login.css') ?>">
</head>
<body>

    <div class="cl-login-page">
        <div class="cl-login-container">
            <div class="cl-login-brand">
                <span class="cl-login-kicker">MOMO PAY</span>
                <h1>Espace Client</h1>
                <p>Connectez-vous avec votre numéro de téléphone.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="cl-login-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form class="cl-login-form" action="<?= base_url('client/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="cl-login-field">
                    <label for="telephone">Numéro de téléphone</label>
                    <input
                        type="text"
                        name="telephone"
                        id="telephone"
                        placeholder="0331234567"
                        value="<?= esc(old('telephone')) ?>"
                        required
                        autofocus
                        autocomplete="tel"
                    >
                </div>

                <button type="submit" class="cl-login-submit">Se connecter</button>
            </form>

            <a href="<?= base_url('/') ?>" class="cl-login-back">&larr; Retour à l'accueil</a>
        </div>
    </div>

</body>
</html>