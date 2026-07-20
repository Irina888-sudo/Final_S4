<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Envoi multiple</title>
    <link rel="stylesheet" href="<?= base_url('css/client/cl-sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/client/cl-dashboard.css') ?>">
</head>
<body>

<?= view('partials/sidebar_client') ?>

<div class="cl-content">
    <h1>Envoi multiple</h1>
    <p style="color:#7f8c8d;">Le montant total sera divisé équitablement entre les destinataires (même opérateur uniquement).</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="cl-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('client/transfert-multiple') ?>" method="post">
        <?= csrf_field() ?>

        <label for="montant_total">Montant total</label>
        <input type="number" name="montant_total" step="0.01" min="1" required>

        <div id="telephonesList">
            <label>Téléphone destinataire</label>
            <input type="text" name="telephones[]" required>
            <label>Téléphone destinataire</label>
            <input type="text" name="telephones[]" required>
        </div>

        <button type="button" id="addTelephone">+ Ajouter un destinataire</button>
        <br><br>
        <button type="submit">Envoyer</button>
    </form>
</div>

<script>
document.getElementById('addTelephone').addEventListener('click', function () {
    const container = document.getElementById('telephonesList');
    const label = document.createElement('label');
    label.textContent = 'Téléphone destinataire';
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'telephones[]';
    input.required = true;
    container.appendChild(label);
    container.appendChild(input);
});
</script>

</body>
</html>