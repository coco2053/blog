<?php

$title = 'Gestion des commentaires :';
$description = 'La liste des commentaires à valider:';
ob_start();

?>

<div class="row">

    <div class="col-md-12">

        <table>

            <thead> <!-- En-tête du tableau -->
                 <tr>
                     <th>Pseudo</th>
                     <th>Commentaire</th>
                     <th>Date</th>
                     <th>Valider</th>
                 </tr>
            </thead>

            <tbody> <!-- Corps du tableau -->

            <?php

            foreach ($comments as $oneComment) {

                ?>
                <tr>
                    <td><?=htmlspecialchars($oneComment->username())?></td>
                    <td><?=htmlspecialchars($oneComment->content())?></td>
                    <td><?=htmlspecialchars($oneComment->creation_date())?></td>
                    <td><a class="btn btn-danger"
                           href='valider-commentaire-<?=htmlspecialchars($oneComment->id_comment())?>'
                           onclick="return confirm('Etes-vous sûr ?');">Valider</a></td>
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

