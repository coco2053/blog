<?php

$title = 'Bienvenue ' .htmlspecialchars($user->username());
$description = 'Page de profile';

ob_start();

?>

<div class="row">

    <div class="col-md-12">

        <p>
            <?=htmlspecialchars($user->firstname())?> <?=htmlspecialchars($user->lastname())?>
        </p>

        Date d'inscription : <?=$user->signup_date()?></br>
        Derniere connexion : <?=htmlspecialchars($user->signin_date())?></br>

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

    </div>

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
