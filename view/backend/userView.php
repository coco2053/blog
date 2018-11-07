<?php

$title = 'Bienvenue ' .htmlspecialchars($user->username());
$description = 'Page de profile';

ob_start();

?>

<div class="formulaires">
    <div class="profile-img">
        <img src="public/img/profile-grey.png">
        <span class="profile-name">
              <?=htmlspecialchars($user->firstname())?> <?=htmlspecialchars($user->lastname())?>
        </span>
    </div>
    </br>

    Date d'inscription : <span class="date"><?=htmlspecialchars($user->signup_date())?></span></br>
    Derniere connexion : <span class="date"><?=htmlspecialchars($user->signin_date())?></span></br>
    Statut : <?=htmlspecialchars($user->role_name())?></br>

    <?php

    if(!empty($_SESSION['user'])) {

        if(strpos($_SESSION['user'] -> perm_action(), 'getUsers') !== false) {
    ?>
      <p>
          <a class="btn btn-primary" href='comptes-<?=htmlspecialchars($user->id_user())?>'>Gestion des comptes</a>
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
<?php

$content = ob_get_clean();
include __DIR__ . "/../template.php";
?>
