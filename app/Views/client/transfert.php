<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Transfert - MOMO PAY') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-form.css') ?>">
</head>
<body>

    <?= view('partials/sidebar_client', [
        'currentPage' => $currentPage ?? uri_string(),
    ]) ?>

    <div class="cl-content">

        <header class="cl-page-header">
            <div class="cl-page-header-text">
                <span class="cl-page-kicker">Transactions</span>
                <h1>Faire un transfert</h1>
                <p>Envoyez de l'argent à un autre client par numéro de téléphone.</p>
            </div>
        </header>

        <div class="form-card form-card-wide">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="form-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="form-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($solde)): ?>
                <p class="current-value">
                    Solde disponible :
                    <strong><?= esc(number_format((float) $solde, 0, ',', ' ')) ?> Ar</strong>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('client/transfert') ?>" method="post" id="transfertForm">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="telephone_destinataire">Téléphone du destinataire</label>
                    <input
                        type="text"
                        name="telephone_destinataire"
                        id="telephone_destinataire"
                        placeholder="Ex: 0331234567"
                        value="<?= esc(old('telephone_destinataire')) ?>"
                        required
                        autofocus
                        autocomplete="tel"
                    >
                    <p id="destinataireStatus" class="cl-status-msg" aria-live="polite"></p>
                </div>

                <div class="form-group">
                    <label for="montant">Montant à transférer (Ar)</label>
                    <input
                        type="number"
                        name="montant"
                        id="montant"
                        step="0.01"
                        min="1"
                        <?php if (isset($solde)): ?>max="<?= esc((float) $solde) ?>"<?php endif; ?>
                        placeholder="Ex: 10000"
                        value="<?= esc(old('montant')) ?>"
                        required
                    >
                </div>

                <div id="optionFraisRetrait" class="cl-form-option cl-hidden">
                    <label class="cl-checkbox-label">
                        <input
                            type="checkbox"
                            name="inclure_frais_retrait"
                            value="1"
                            <?= old('inclure_frais_retrait') ? 'checked' : '' ?>
                        >
                        <span>Inclure les frais de retrait futurs du destinataire</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Transférer</button>
                    <a href="<?= base_url('client/dashboard') ?>" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>

    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>

    <script>
    const optionDiv  = document.getElementById('optionFraisRetrait');
    const statusEl   = document.getElementById('destinataireStatus');
    const telInput   = document.getElementById('telephone_destinataire');

    function setStatus(message, type) {
        statusEl.textContent = message;
        statusEl.className = 'cl-status-msg' + (type ? ' cl-status-' + type : '');
    }

    telInput.addEventListener('blur', function () {
        const telephone = this.value.trim();

        optionDiv.classList.add('cl-hidden');
        setStatus('', '');

        if (!telephone) return;

        fetch('<?= base_url('client/check-destinataire') ?>?telephone=' + encodeURIComponent(telephone))
            .then(res => res.json())
            .then(data => {
                if (!data.exists) {
                    setStatus('Destinataire introuvable.', 'error');
                    return;
                }

                if (data.est_interne) {
                    optionDiv.classList.remove('cl-hidden');
                    setStatus('Destinataire trouvé — opérateur interne.', 'success');
                } else {
                    setStatus("Cet opérateur est externe, option frais de retrait non disponible.", 'info');
                }
            })
            .catch(() => {
                setStatus('Erreur de vérification.', 'error');
            });
    });
    </script>

</body>
</html>