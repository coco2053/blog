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

<div class="row">

    <div class="col-md-7">

        <a href="#">

            <img class="img-fluid rounded mb-3 mb-md-0"
                 src="public/upload/<?=htmlspecialchars($onePost->image())?>" alt="">
        </a>

    </div>

    <div class="col-md-5">

        <h3> <?=htmlspecialchars($onePost->title())?> </h3>

        <h4> Chapo : </h4>

        <p> <?=htmlspecialchars($onePost->chapo())?> </p>

        <h4> Contenu : </h4>

        <p> <?=htmlspecialchars($content)?> </p>

        Date de creation : <?=htmlspecialchars($onePost->creation_date())?></br>
        Date de modification : <?=htmlspecialchars($onePost->update_date())?></br>
        Auteur : <?=htmlspecialchars($onePost->username())?></br>

        <a class="btn btn-primary" href='article-<?=htmlspecialchars($onePost->id_post())?>'>Voir l'article</a>

    </div>
</div>

<?php
}

$content = ob_get_clean();

include __DIR__ . "/../template.php";
?>
