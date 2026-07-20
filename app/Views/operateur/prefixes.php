<!-- app/Views/operateur/prefixes.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bienvenue, <?= $operateur_username ?></p>

<?php foreach ($prefixes as $p): ?>
    <p><?= $p['code'] ?> - <?= $p['actif'] ? 'Actif' : 'Inactif' ?></p>
<?php endforeach; ?>


<h1>Gestion des préfixes</h1>
<a href="/operateur/prefixes/new">+ Ajouter</a>

<table border="1">
    <tr><th>Code</th><th>Actif</th><th>Actions</th></tr>
    <?php foreach ($prefixes as $p): ?>
    <tr>
        <td><?= $p['code'] ?></td>
        <td><?= $p['actif'] ? 'Oui' : 'Non' ?></td>
        <td>
            <a href="/operateur/prefixes/<?= $p['id'] ?>/edit">Modifier</a>

            <form method="post" action="/operateur/prefixes/<?= $p['id'] ?>" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>



