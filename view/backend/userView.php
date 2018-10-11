<?php
$title = 'Bienvenue ' .htmlspecialchars($user->username());
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-12">
    <p>
    <a class="btn btn-primary" href='?action=addPostView'>Ecrire un article</a>
  </p>
      </div>
        <div class="col-md-12">
          <p><?=htmlspecialchars($user->firstname())?> <?=htmlspecialchars($user->lastname())?></p>
            Date d'inscription : <?=$user->signup_date()?></br>
            Derniere connexion : <?=htmlspecialchars($user->signin_date())?></br>

            <a class="btn btn-primary" href='?action=getUsersView&id=<?=htmlspecialchars($user->id_user())?>'>Gestion des comptes</a>

        </div>
    </div>
    <hr>

<?php
print_r ($_SESSION['user']);
$content = ob_get_clean();
include 'template.php';
?>
