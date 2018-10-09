<?php
$title = 'Modifier un article';
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-7">

    <form action="index.php?action=editPost&amp;id=<?= $post->id_post() ?>" method="post">

        <p>
            Titre :<input type="text" name="title" maxlength="50" value="<?= htmlspecialchars($post->title()) ?>" /> </br>

            Chapo :<input type="text" name="chapo" maxlength="100" value="<?= htmlspecialchars($post->chapo()) ?>" /> </br>

            Contenu :<textarea name="content" rows="4" cols="40"> <?= htmlspecialchars($post->content()) ?> </textarea></br>

            <input type="submit" value="Envoyer" name="editPost" /></br>

        </p>

    </form>

  </div>
</div>
<hr>

<?php $content = ob_get_clean();

include 'template.php';
?>
