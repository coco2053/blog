<?php

$title = 'Les derniers articles :';
$description = 'Liste des derniers articles publiés :';

ob_start();

?>
<h1 class="my-3"> <?= $title ?> </h1>
<?php
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
             src="public/upload/<?=nl2br(htmlspecialchars($onePost->image()))?>" alt="Image illustrant l'article">

        <a class="btn btn-primary" href='article-<?=nl2br(htmlspecialchars($onePost->id_post()))?>'>Voir l'article</a>

    </div>

    <div class="col-md-6">

        <h3> <?=nl2br(htmlspecialchars($onePost->title()))?> </h3>

        <p> <i> <?=nl2br(htmlspecialchars($onePost->chapo()))?> </i> </p>

        <p class="post-content"> <?=$content?> </p>

        publié le <span class="date"><?=nl2br(htmlspecialchars($onePost->creation_date()))?></span>
        <?php
        $creation_date = $onePost->creation_date();
        $update_date = $onePost->update_date();
        if($creation_date !== $update_date) {
            ?>
            </br>mise à jour le <span class="date"><?=nl2br(htmlspecialchars($onePost->update_date()))?></span>
            <?php
        }
        ?>
        par <span class="username"><?=nl2br(htmlspecialchars($onePost->username()))?></span>

    </div>
</div>

<?php
}

$content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
