<?php

$title = htmlspecialchars($post->title());
$description = 'Lire un article';

ob_start();

?>


<img class="img-fluid rounded mb-3 mb-md-0"
     src="public/upload/<?=htmlspecialchars($post->image())?>" alt="">

<p> <i> <?=htmlspecialchars($post->chapo())?> </i> </p>

<p class="post-content"> <?=$post->content()?> </p>

<span class="date">publié le <?=htmlspecialchars($post->creation_date())?>
<?php
$creation_date = $post->creation_date();
$update_date = $post->update_date();
if($creation_date !== $update_date) {
    ?>
    • mise à jour le <?=htmlspecialchars($post->update_date())?>
    <?php
}
?>
par <?=htmlspecialchars($post->username())?></span></br>

<?php

if(isset($_SESSION['user'])) {

    if(strpos($_SESSION['user'] -> perm_action(), 'editPost') !== false) {
    ?>

        <a class="btn btn-primary"
           href='modifier-article-<?=htmlspecialchars($post->id_post())?>'>Modifier l'article</a>

        <a class="btn btn-danger"
           href='supprimer-article-<?=htmlspecialchars($post->id_post())?>'
           onclick="return confirm('Etes-vous sûr ?');">Supprimer l'article</a></br>

    <?php

}

if(strpos($_SESSION['user'] -> perm_action(), 'addComment') !== false) {
?>
    <div class="article">
        <form id = 'form_com' method = "post"
                              action = "ajouter-commentaire-<?=htmlspecialchars($post->id_post())?>">
            <table>

                <tbody>

                    <tr>
                        <td><label>Ajouter un commentaire : </label></td>
                        <td><input type="text" name="content" required /> </td>
                    </tr>

                    <tr>
                        <td><label></label></td>
                        <td><input type="submit" value="Valider" /> </td>
                    </tr>
                </tbody>

            </table>

        </form>

    </div>


        <?php
        }
    }

if(isset($comments)) {

    foreach ($comments as $oneComment) {
        ?>

                <h3> <?=htmlspecialchars($oneComment->username())?> a dit :</h3>

                <p> <?=htmlspecialchars($oneComment->content())?> </p>


    <?php

    if(isset($_SESSION['user'])) {

        if(strpos($_SESSION['user'] -> perm_action(), 'deleteComment') !== false) {
            ?>

            <p>
                <a class="btn btn-danger"
                   href='supprimer-commentaire-<?=htmlspecialchars($oneComment->id_comment())?>'
                   onclick="return confirm('Etes-vous sûr ?');">Supprimer le commentaire</a>
            </p>
            <?php
        }
    }
}
}
?>

<a href="articles">Retour à la liste des billets</a>

<?php

$content = ob_get_clean();
include __DIR__ . "/../template.php";
?>
