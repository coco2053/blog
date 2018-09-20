<?php
$title = htmlspecialchars($post->title());
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-12">
    <a href="#">
      <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
    </a>
      </div>
        <div class="col-md-12">
          <p>"<?=htmlspecialchars($post->chapo())?>"</p>
            <h4>Contenu :</h4>
            <p><?=$post->content()?></p>
            Date de creation : <?=htmlspecialchars($post->creation_date())?></br>
            Date de modification : <?=htmlspecialchars($post->update_date())?></br>
            Auteur : <?=htmlspecialchars($post->username())?></br>
        </div>
        <a href="index.php">Retour à la liste des billets</a>
    </div>
    <hr>

<?php
$content = ob_get_clean();
require('template.php');
?>
