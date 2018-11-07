<?php

$title = 'Gestion des commentaires :';
$description = 'La liste des commentaires à valider:';
ob_start();

?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Pseudo</th>
            <th scope="col">Commentaire</th>
            <th scope="col">Date</th>
            <th scope="col">Valider</th>
        </tr>
        </thead>
        <tbody>

        <?php

        foreach ($comments as $oneComment) {

            ?>
            <tr>
                <th scope="row"><?=htmlspecialchars($oneComment->username())?></th>
                <td><?=htmlspecialchars($oneComment->content())?></td>
                <td><?=htmlspecialchars($oneComment->creation_date())?></td>
                <td><a class="btn btn-success"
                       href='valider-commentaire-<?=htmlspecialchars($oneComment->id_comment())?>'
                       onclick="return confirm('Etes-vous sûr ?');">Valider</a></td>
            </tr>

            <?php
            }
            ?>

        </tbody>

    </table>
</div>
<?php

$content = ob_get_clean();

include __DIR__ . "/../template.php";

?>

