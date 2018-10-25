<?php

$title = htmlspecialchars($post->title());
$description = 'Lire un article';

ob_start();

?>

<div class="row">

    <div class="col-md-12">

        <a href="#">
            <img class="img-fluid rounded mb-3 mb-md-0"
                 src="public/upload/<?=htmlspecialchars($post->image())?>" alt="">
        </a>

    </div>

    <div class="col-md-12">

        <p> "<?=htmlspecialchars($post->chapo())?> </p>

        <h4>Contenu : </h4>

        <p> <?=$post->content()?> </p>

        Date de creation : <?=htmlspecialchars($post->creation_date())?></br>
        Date de modification : <?=htmlspecialchars($post->update_date())?></br>
        Auteur : <?=htmlspecialchars($post->username())?></br>

    </div>

    <?php

    if(isset($_SESSION['user'])) {

        if(strpos($_SESSION['user'] -> perm_action(), 'editPost') !== false) {
        ?>
            <p>
                <a class="btn btn-primary"
                   href='modifier-article-<?=htmlspecialchars($post->id_post())?>'>Modifier l'article</a>
            </p>

            <p>
                <a class="btn btn-danger"
                   href='supprimer-article-<?=htmlspecialchars($post->id_post())?>'
                   onclick="return confirm('Etes-vous sûr ?');">Supprimer l'article</a>
            </p>

        <?php

        }

        if(strpos($_SESSION['user'] -> perm_action(), 'addComment') !== false) {
        ?>
            <div>
                <form id = 'form_com' method = "post"
                                      action = "ajouter-commentaire-<?=htmlspecialchars($post->id_post())?>">
                    <table>

                        <tbody>

                            <tr>
                                <td><label>Commentaire</label></td>
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

                <div class="row">

                    <div class="col-md-7">

                    </div>

                    <div class="col-md-5">

                        <h3> <?=htmlspecialchars($oneComment->username())?> </h3>
                        <h4> Commentaire : </h4>
                        <p> <?=htmlspecialchars($oneComment->content())?> </p>

                    </div>

                </div>

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
  </div></br></br></br></br>
</div>

<?php

$content = ob_get_clean();
include __DIR__ . "/../template.php";
?>
