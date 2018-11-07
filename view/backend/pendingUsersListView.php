<?php

$title = 'Gestion des comptes :';
$description = 'La liste des utilisateurs à valider:';

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
            <th scope="col">Date d'inscription</th>
            <th scope="col">Date de connexion</th>
            <th scope="col">Valider</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $oneUser) {
        ?>
            <tr>
                <th scope="row"><?=htmlspecialchars($oneUser->username())?></th>
                <td><?=htmlspecialchars($oneUser->email())?></td>
                <td><?=htmlspecialchars($oneUser->firstname())?></td>
                <td><?=htmlspecialchars($oneUser->lastname())?></td>
                <td><?=htmlspecialchars($oneUser->Valid())?></td>
                <td><?=htmlspecialchars($oneUser->signup_date())?></td>
                <td><?=htmlspecialchars($oneUser->signin_date())?></td>
                <td><a class="btn btn-success"
                       href='valider-compte-<?=htmlspecialchars($oneUser->id_user())?>'
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

