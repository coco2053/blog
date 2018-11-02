<?php

$title = 'Les derniers articles :';
$description = 'Liste des derniers articles publiés :';

ob_start();

foreach ($posts as $onePost) {

    if (strlen($onePost->content()) <= 300) {

        $content = $onePost->content();

    } else {

        $start = substr($onePost->content(), 0, 300);
        $start = substr($start, 0, strrpos($start, ' ')) . '...';

        $content = $start;
    }
?>

<div class="row article">

    <div class="col-md-6">

        <img class="img-fluid rounded mb-3 mb-md-0 img-vignette"
             src="public/upload/<?=htmlspecialchars($onePost->image())?>" alt="Image illustrant l'article">

        <a class="btn btn-primary" href='article-<?=htmlspecialchars($onePost->id_post())?>'>Voir l'article</a>

    </div>

    <div class="col-md-6">

        <h3> <?=htmlspecialchars($onePost->title())?> </h3>

        <p> <i> <?=htmlspecialchars($onePost->chapo())?> </i> </p>

        <p class="post-content"> <?=$content?> </p>

        <span class="date">publié le <?=htmlspecialchars($onePost->creation_date())?>
        <?php
        $creation_date = $onePost->creation_date();
        $update_date = $onePost->update_date();
        if($creation_date !== $update_date) {
            ?>
            </br>mise à jour le <?=htmlspecialchars($onePost->update_date())?>
            <?php
        }
        ?>
        par <?=htmlspecialchars($onePost->username())?></span>

    </div>
</div>

<?php
}

$content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
