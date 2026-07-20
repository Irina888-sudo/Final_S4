<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1><?= isset($prefixe) ? 'Modifier' : 'Ajouter' ?> un préfixe</h1>

<form method="post" action="/operateur/prefixes<?= isset($prefixe) ? '/' . $prefixe['id'] : '' ?>">
    <?= csrf_field() ?>

    <?php if (isset($prefixe)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <label>Code (3 chiffres) :</label>
    <input type="text" name="code" maxlength="3"
           value="<?= isset($prefixe) ? $prefixe['code'] : '' ?>">

    <label>Actif :</label>
    <select name="actif">
        <option value="1" <?= (isset($prefixe) && $prefixe['actif'] == 1) ? 'selected' : '' ?>>Oui</option>
        <option value="0" <?= (isset($prefixe) && $prefixe['actif'] == 0) ? 'selected' : '' ?>>Non</option>
    </select>

    <button type="submit">Enregistrer</button>
</form>

<a href="/operateur/prefixes">Retour à la liste</a>
</body>
</html>