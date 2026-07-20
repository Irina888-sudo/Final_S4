<!-- app/Views/operateur/types_baremes.php -->
<h1>Types d'opération & Barèmes</h1>
<a href="/operateur/types-baremes/new">+ Ajouter un barème</a>

<?php foreach ($types as $type): ?>
    <h3><?= ucfirst($type['libelle']) ?></h3>
    <table border="1">
        <tr><th>Min</th><th>Max</th><th>Frais</th><th>Actions</th></tr>
        <?php foreach ($type['baremes'] as $b): ?>
        <tr>
            <td><?= $b['montant_min'] ?></td>
            <td><?= $b['montant_max'] ?></td>
            <td><?= $b['frais'] ?></td>
            <td>
                <a href="/operateur/types-baremes/<?= $b['id'] ?>/edit">Modifier</a>
                <form method="post" action="/operateur/types-baremes/<?= $b['id'] ?>" style="display:inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>