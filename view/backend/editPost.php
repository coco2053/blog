<?php

$title = 'Modifier un article';
$description = 'Modifier un article déja publié';

ob_start();

?>

<form action="modifie-article-<?= $post->id_post() ?>" method="post">
    <div class="form-group">
        <label>Titre</label>
        <input type="text" class="form-control" name="title" maxlength="100"
               value="<?= htmlspecialchars($post->title()) ?>" />
        <label>Chapo</label>
        <input type="text" class="form-control" name="chapo" maxlength="100"
               value="<?= htmlspecialchars($post->chapo()) ?>" />
        <label>Contenu</label>
        <textarea name="content" class="form-control" rows="4" cols="40">
                  <?= htmlspecialchars($post->content()) ?> </textarea>
       <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</form>

<?php

$content = ob_get_clean();

include __DIR__ . "/../template.php";

?>
