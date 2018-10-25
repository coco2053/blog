<?php
$title = 'Les derniers billets :';
$description = 'Les derniers billets:';
ob_start();

?>
<p>
<a class="btn btn-primary" href='?action=addPostView'>Ecrire un article</a>
</p>
<?php

foreach ($posts as $onePost) {
?>

<div class="row">
  <div class="col-md-7">

    <a href="#">
      <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
    </a>
      </div>
        <div class="col-md-5">
          <h3><?=htmlspecialchars($onePost->title())?></h3>
            <h4>Chapo :</h4>
              <p><?=htmlspecialchars($onePost->chapo())?></p>
            <h4>Contenu :</h4>
            <p><?=$onePost->content()?></p>
            Date de creation : <?=htmlspecialchars($onePost->creation_date())?></br>
            Date de modification : <?=htmlspecialchars($onePost->update_date())?></br>
            Auteur : <?=htmlspecialchars($onePost->username())?></br>
            <a class="btn btn-primary" href='?action=readPost&id=<?=htmlspecialchars($onePost->id_post())?>'>Voir l'article</a>
        </div>
    </div>
    <hr>
<?php
}

$content = ob_get_clean();

include 'template.php';
