<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Transfert</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Faire un transfert</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/transfert') ?>" method="post" id="transfertForm">
        <?= csrf_field() ?>

        <label for="telephone_destinataire">Téléphone du destinataire</label>
        <input type="text" name="telephone_destinataire" id="telephone_destinataire" required>
        <p id="destinataireStatus" class="cl-status-msg"></p>

        <label for="montant">Montant à transférer</label>
        <input type="number" name="montant" id="montant" step="0.01" min="1" required>

        <div id="optionFraisRetrait" style="display: none;">
            <label>
                <input type="checkbox" name="inclure_frais_retrait" value="1">
                Inclure les frais de retrait futurs du destinataire
            </label>
        </div>

        <button type="submit">Transférer</button>
    </form>
</div>

<script>
document.getElementById('telephone_destinataire').addEventListener('blur', function () {
    const telephone = this.value.trim();
    const optionDiv = document.getElementById('optionFraisRetrait');
    const statusEl = document.getElementById('destinataireStatus');

    optionDiv.style.display = 'none';
    statusEl.textContent = '';

    if (! telephone) return;

    fetch('<?= base_url('client/check-destinataire') ?>?telephone=' + encodeURIComponent(telephone))
        .then(res => res.json())
        .then(data => {
            if (! data.exists) {
                statusEl.textContent = 'Destinataire introuvable.';
                statusEl.style.color = '#e74c3c';
                return;
            }

            if (data.est_interne) {
                optionDiv.style.display = 'block';
                statusEl.textContent = '';
            } else {
                statusEl.textContent = "Cet opérateur est externe, option frais de retrait non disponible.";
                statusEl.style.color = '#7f8c8d';
            }
        })
        .catch(() => {
            statusEl.textContent = 'Erreur de vérification.';
            statusEl.style.color = '#e74c3c';
        });
});
</script>

</body>
</html>