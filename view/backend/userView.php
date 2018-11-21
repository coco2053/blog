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

            Date d'inscription : <span class="date"><?=nl2br(htmlspecialchars($user->signupDate()))?></span></br>
            Derniere connexion : <span class="date"><?=nl2br(htmlspecialchars($user->signinDate()))?></span></br>
            Statut : <?=nl2br(htmlspecialchars($user->roleName()))?></br>

            <?php

            if (!empty($_SESSION['user'])) {
                if (strpos($_SESSION['user'] -> permAction(), 'writePostView') == false) {
                    ?>
                    </br>
                    </br>
                    <p>
                        <strong>Bienvenue ! </strong></br>
                        Vous pouvez désormais commenter les articles.<br>
                        Rendez-vous sur la page d'un article.
                    </p>
                    <?php
                }
            }

            if (!empty($_SESSION['user'])) {
                if (strpos($_SESSION['user'] -> permAction(), 'getUsers') !== false) {
                    ?>
                    <p>
                        <a class="btn btn-primary" href='comptes-<?=nl2br(htmlspecialchars($user->idUser()))?>'>Gestion des comptes</a>
                    </p>
                    <?php
                }
            }
            ?>

            <?php

            if (!empty($_SESSION['user'])) {
                if (strpos($_SESSION['user'] -> permAction(), 'getPendingUsersView') !== false) {
                    ?>
                    <p>
                        <a class="btn btn-primary" href='comptes-a-valider'>Comptes en attente de validation</a>
                    </p>
                    <?php
                }
            }

            if (!empty($_SESSION['user'])) {
                if (strpos($_SESSION['user'] -> permAction(), 'getPendingComments') !== false) {
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
