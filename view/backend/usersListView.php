<?php

$title = 'Gestion des comptes :';
$description = 'La liste des utilisateurs:';

ob_start();

?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Pseudo</th>
            <th scope="col">Email</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Validé ?</th>
            <th scope="col">Date inscription</th>
            <th scope="col">Date connexion</th>
            <th scope="col">Supprimer</th>
        </tr>
        </thead>
        <tbody>

        <?php
        foreach ($users as $oneUser) {
            ?>
            <tr>
                <th scope="row"><?=nl2br(htmlspecialchars($oneUser->username()))?></th>
                <td><?=nl2br(htmlspecialchars($oneUser->email()))?></td>
                <td><?=nl2br(htmlspecialchars($oneUser->firstname()))?></td>
                <td><?=nl2br(htmlspecialchars($oneUser->lastname()))?></td>
                <td><?=nl2br(htmlspecialchars($oneUser->Valid()))?></td>
                <td><?=nl2br(htmlspecialchars($oneUser->signupDate()))?></td>
                <td><?=nl2br(htmlspecialchars($oneUser->signinDate()))?></td>
                <td><a class="btn btn-danger"
                       href='supprimer-compte-<?=nl2br(htmlspecialchars($oneUser->idUser()))?>'
                       onclick="return confirm('Etes-vous sûr ?');">Supprimer</a></td>
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

