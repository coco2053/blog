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
                <th scope="row"><?=nl2br(htmlspecialchars($oneComment->username()))?></th>
                <td><?=nl2br(htmlspecialchars($oneComment->content()))?></td>
                <td><?=nl2br(htmlspecialchars($oneComment->creation_date()))?></td>
                <td><a class="btn btn-success"
                       href='valider-commentaire-<?=nl2br(htmlspecialchars($oneComment->id_comment()))?>'
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

