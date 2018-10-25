<?php

$title = 'Gestion des comptes :';
$description = 'La liste des utilisateurs:';

ob_start();

?>

<div class="row">

    <div class="col-md-12">

        <table>

            <thead> <!-- En-tête du tableau -->
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Validé ?</th>
                    <th>Date d'inscription</th>
                    <th>Date de connexion</th>
                    <th>Suppression</th>
                </tr>

            </thead>

            <tbody> <!-- Corps du tableau -->

            <?php
            foreach ($users as $oneUser) {
            ?>
                <tr>
                    <td><?=htmlspecialchars($oneUser->username())?></td>
                    <td><?=htmlspecialchars($oneUser->email())?></td>
                    <td><?=htmlspecialchars($oneUser->firstname())?></td>
                    <td><?=htmlspecialchars($oneUser->lastname())?></td>
                    <td><?=htmlspecialchars($oneUser->Valid())?></td>
                    <td><?=htmlspecialchars($oneUser->signup_date())?></td>
                    <td><?=htmlspecialchars($oneUser->signin_date())?></td>
                    <td><a class="btn btn-danger"
                           href='supprimer-compte-<?=htmlspecialchars($oneUser->id_user())?>'
                           onclick="return confirm('Etes-vous sûr ?');">Supprimer</a></td>
                </tr>

                <?php
                }
                ?>

            </tbody>

        </table>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../template.php";

?>

