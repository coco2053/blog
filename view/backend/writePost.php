<?php
$title = 'Ecrire un article';
$description = 'Blog';
ob_start();
?>

<div class="row">
  <div class="col-md-7">

    <form action="index.php?action=addPost" method="post">

        <p>
            Titre :<input type="text" name="title" maxlength="50" /> </br>

            Chapo :<input type="text" name="chapo" maxlength="100" /> </br>

            Contenu :<textarea name="content" rows="4" cols="40"></textarea></br>

            <input type="submit" value="Envoyer" name="addPost" /></br>

        </p>

    </form>

  </div>
</div>
<hr>

<?php $content = ob_get_clean();

require('frontend\..\template.php');
?>
