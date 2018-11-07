<?php

$title = 'Accueil';
$description = 'Page d\'accueil';

ob_start();

?>

<img alt="" src="public/img/home.png" style="width:100%">

<div class="home">
    <p>
        Je suis un développeur backend en formation chez <em>Openclassrooms</em>
        sur le parcours <em>Developpeur d'application PHP / Symphony.</em> </p>
        Ce site a éte réalisé au cours de cette formation et il est entierement codé en PHP.
    </p>
</div>

<?php

$content = ob_get_clean();
include __DIR__ . "/../template.php";
?>
