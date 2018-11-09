<?php

$title = 'Bienvenue ' .nl2br(htmlspecialchars($user->username()));
$description = 'Page de profile';

ob_start();

?>

<div class="formstyle">
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6 center">
            <div class="profile-img">
                <img src="public/img/profile-grey.png">
                <span class="profile-name">
                      <?=nl2br(htmlspecialchars($user->firstname()))?> <?=nl2br(htmlspecialchars($user->lastname()))?>
                </span>
            </div>
            </br>

            Date d'inscription : <span class="date"><?=nl2br(htmlspecialchars($user->signup_date()))?></span></br>
            Derniere connexion : <span class="date"><?=nl2br(htmlspecialchars($user->signin_date()))?></span></br>
            Statut : <?=nl2br(htmlspecialchars($user->role_name()))?></br>

            <?php

            if(!empty($_SESSION['user'])) {

                if(strpos($_SESSION['user'] -> perm_action(), 'getUsers') !== false) {
            ?>
              <p>
                  <a class="btn btn-primary" href='comptes-<?=nl2br(htmlspecialchars($user->id_user()))?>'>Gestion des comptes</a>
              </p>
            <?php
                }
            }
            ?>

            <?php

            if(!empty($_SESSION['user'])) {

                if(strpos($_SESSION['user'] -> perm_action(), 'getPendingUsersView') !== false) {

                    ?>
                    <p>
                        <a class="btn btn-primary" href='comptes-a-valider'>Comptes en attente de validation</a>
                    </p>
                <?php
                }
            }

            if(!empty($_SESSION['user'])) {

                if(strpos($_SESSION['user'] -> perm_action(), 'getPendingComments') !== false) {
                    ?>
                    <p>
                        <a class="btn btn-primary" href='commentaires-a-valider'>Commentaires en attente de validation</a>
                    </p>
                <?php
                }
            }
            ?>

        </div>
        <div class="col-md-3"> </div>
    </div>
</div>
<?php

$content = ob_get_clean();
include __DIR__ . "/../template.php";
?>
