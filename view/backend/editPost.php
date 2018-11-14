<?php

$title = 'Modifier un article';
$description = 'Modifier un article déja publié';

ob_start();

?>
<div class="formstyle">
    <div class="row">
        <div class="col-md-2"> </div>
        <div class="col-md-8 center">
            <h1 class="my-3"> <?= nl2br(htmlspecialchars($title)) ?> </h1>
            <form action="modifie-article-<?= nl2br(htmlspecialchars($post->idPost())) ?>" method="post">
                <div class="form-group">
                    <label>Titre</label>
                    <input type="text" class="form-control" name="title" maxlength="100"
                           value="<?= nl2br(htmlspecialchars($post->title())) ?>" />
                    <label>Chapo</label>
                    <input type="text" class="form-control" name="chapo" maxlength="100"
                           value="<?= nl2br(htmlspecialchars($post->chapo())) ?>" />
                    <label>Contenu</label>
                    <textarea name="content" class="form-control" rows="4" cols="40">
                            <?= nl2br(htmlspecialchars($post->content())) ?> </textarea>
                   <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
        <div class="col-md-2"> </div>
    </div>
</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../template.php";

?>
