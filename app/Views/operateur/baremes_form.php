<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/operateur/op-sidebar.css') ?>">
     <link rel="stylesheet" href="<?= base_url('css/operateur/op-dashboard.css') ?>">
    <title>Document</title>
    
</head>
 
<body>
    <?= view('partials/sidebar_operateur') ?>
     <div class="op-content">
   
    <!-- app/Views/operateur/baremes_form.php -->
<h1><?= isset($bareme) ? 'Modifier' : 'Ajouter' ?> un barème</h1>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<form method="post" action="/operateur/types-baremes<?= isset($bareme) ? '/' . $bareme['id'] : '' ?>">
    <?= csrf_field() ?>
    <?php if (isset($bareme)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <label>Type d'opération :</label>
    <select name="type_operation_id">
        <?php foreach ($types as $t): ?>
            <option value="<?= $t['id'] ?>"
                <?= (isset($bareme) && $bareme['type_operation_id'] == $t['id']) ? 'selected' : '' ?>>
                <?= ucfirst($t['libelle']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Montant min :</label>
    <input type="number" step="0.01" name="montant_min" value="<?= $bareme['montant_min'] ?? '' ?>">

    <label>Montant max :</label>
    <input type="number" step="0.01" name="montant_max" value="<?= $bareme['montant_max'] ?? '' ?>">

    <label>Frais :</label>
    <input type="number" step="0.01" name="frais" value="<?= $bareme['frais'] ?? '' ?>">

    <button type="submit">Enregistrer</button>
</form>
<a href="/operateur/types-baremes">Retour</a>
</div>
</body>
</html>