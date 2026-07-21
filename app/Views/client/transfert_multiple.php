<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Envoi multiple - MOMO PAY') ?></title>

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
                <h1>Envoi multiple</h1>
                <p>Envoyez un montant total réparti équitablement entre plusieurs destinataires.</p>
            </div>
        </header>

        <div class="form-card form-card-wide">
            <div class="cl-info-banner">
                Le montant total sera divisé équitablement entre les destinataires
                <strong>(même opérateur uniquement)</strong>.
            </div>

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

            <form action="<?= base_url('client/transfert-multiple') ?>" method="post" id="multiTransfertForm">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="montant_total">Montant total (Ar)</label>
                    <input
                        type="number"
                        name="montant_total"
                        id="montant_total"
                        step="0.01"
                        min="1"
                        <?php if (isset($solde)): ?>max="<?= esc((float) $solde) ?>"<?php endif; ?>
                        placeholder="Ex: 50000"
                        value="<?= esc(old('montant_total')) ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="cl-recipients-section">
                    <div class="cl-recipients-head">
                        <h3>Destinataires</h3>
                        <span id="recipientCount" class="cl-recipient-count">2 destinataires</span>
                    </div>

                    <div id="telephonesList" class="cl-recipients-list">
                        <?php
                            $oldPhones = old('telephones') ?? ['', ''];
                            if (count($oldPhones) < 2) {
                                $oldPhones = array_pad($oldPhones, 2, '');
                            }
                        ?>
                        <?php foreach ($oldPhones as $i => $phone): ?>
                            <div class="cl-recipient-row">
                                <label for="tel_<?= $i ?>">Téléphone destinataire <?= $i + 1 ?></label>
                                <input
                                    type="text"
                                    name="telephones[]"
                                    id="tel_<?= $i ?>"
                                    placeholder="Ex: 0331234567"
                                    value="<?= esc($phone) ?>"
                                    required
                                    autocomplete="tel"
                                >
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="addTelephone" class="btn-add-recipient">
                        + Ajouter un destinataire
                    </button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Envoyer</button>
                    <a href="<?= base_url('client/dashboard') ?>" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </div>

    </div>

    <script src="<?= base_url('js/client/theme.js') ?>"></script>

    <script>
    const telephonesList = document.getElementById('telephonesList');
    const recipientCount = document.getElementById('recipientCount');
    let recipientIndex = telephonesList.querySelectorAll('.cl-recipient-row').length;

    function updateRecipientCount() {
        const count = telephonesList.querySelectorAll('.cl-recipient-row').length;
        recipientCount.textContent = count + ' destinataire' + (count > 1 ? 's' : '');
    }

    document.getElementById('addTelephone').addEventListener('click', function () {
        recipientIndex++;

        const row = document.createElement('div');
        row.className = 'cl-recipient-row';

        const label = document.createElement('label');
        label.setAttribute('for', 'tel_' + recipientIndex);
        label.textContent = 'Téléphone destinataire ' + recipientIndex;

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'telephones[]';
        input.id = 'tel_' + recipientIndex;
        input.placeholder = 'Ex: 0331234567';
        input.required = true;
        input.autocomplete = 'tel';

        row.appendChild(label);
        row.appendChild(input);
        telephonesList.appendChild(row);
        input.focus();

        updateRecipientCount();
    });

    updateRecipientCount();
    </script>

</body>
</html>