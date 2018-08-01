<?php
$title = 'Mon blog';
ob_start();
?>

<h1>Mon super blog !</h1>
<p>Derniers billets du blog :</p>

    <form action="index.php?action=addPost" method="post">


        <h2>Ecrire un article</h2>

        <p>

            Titre :<input type="text" name="title" maxlength="50" /> </br>

            Chapo :<input type="text" name="chapo" maxlength="100" /> </br>

            Contenu :<textarea name="content" rows="4" cols="40"></textarea></br>

            <input type="submit" value="Envoyer" name="addPost" /></br>


        </p>

    </form>

<?php $content = ob_get_clean();

require('template.php');
?>
