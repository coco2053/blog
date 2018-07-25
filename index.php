<?php

// On enregistre notre autoload.

function chargerClasse($classname)

{

  require 'model/'.$classname.'.php';

}

spl_autoload_register('chargerClasse');

$_SESSION['id_user'] = '1';

$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.
$manager = new PostManager($db);




/*

if (!$manager->exists($formData['title']))
{
	$manager->add($post);
}
else {
	echo 'cet article existe déja !</br>';
}

$posts = $manager->getList();
}

$formData = ['title' => 'Le festival ZIK ZAC',
			 'chapo' => 'Festival de musique gratuit au Jas de Bouffan !',
			 'content' => 'kjbgeibgejjg e gbijgb eibgi zebgijbeijg biebgiejb igjbeijbgiejbgib iezjgbkjbtgkjebtgijbe gkjebkjgbekjtbg kjbezkjbkjbgkejbtgkj bzkejt bgkjbtg kjbtgk zjbgkj btkzjbgkjbktjzbgk zjebtgkùsjbeg tezbgkjb zekbgkzebgkh',
			 'id_user' => '1',
			 'id_post' => '2'];

$manager = new PostManager($db);
$post = new Post($formData);

if (!$manager->exists($formData['title']))
{
	$manager->add($post);
}
else {
	echo 'cet article existe déja !</br>';
}

$posts = $manager->getList();

foreach ($posts as $onePost)
{

echo '</br>titre :</br> ', htmlspecialchars($onePost->title()), '</br>chapo :</br> ', htmlspecialchars($onePost->chapo()), '</br>contenu :</br> ', $onePost->content(), '</br>date de creation :</br> ', htmlspecialchars($onePost->creation_date()), '</br>date de modification :</br> ', htmlspecialchars($onePost->update_date()) , '</br>auteur :</br> ', htmlspecialchars($onePost->username());

}

$post = $manager->get('4');
echo '</br>titre :</br> ', htmlspecialchars($post->title()), '</br>chapo :</br> ', htmlspecialchars($post->chapo()), '</br>contenu :</br> ', $post->content(), '</br>date de creation :</br> ', htmlspecialchars($post->creation_date()), '</br>date de modification :</br> ', htmlspecialchars($post->update_date()) , '</br>auteur :</br> ', htmlspecialchars($post->username());

*/
?>

<!DOCTYPE html>

<html>

  <head>

    <title>Blog de Bastien Vacherand</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    

    <meta charset="utf-8" />

  </head>

  <body>

  	<a class="btn btn-primary" href="?write" role="button">Ecrire un article</a>
  	<a class="btn btn-primary" href="?postList" role="button">Lire les articles</a>

  	<?php

  	if (isset($_POST['addPost']))
{

	
	
	$formData = ['title' => $_POST['title'],
				 'chapo' => $_POST['chapo'],
				 'content' => $_POST['content'],
			     'id_user' => $_SESSION['id_user']];

	if (!$manager->exists($formData['title']))
	{
		
		$post = new Post($formData);
		$manager->add($post);
	}
	else {
		echo 'cet article existe déja !</br>';
	}	

}

if (isset($_GET['readPost']))
{
	$post = $manager->get($_GET['readPost']);
	echo '</br>titre :</br> ', htmlspecialchars($post->title()), '</br>chapo :</br> ', htmlspecialchars($post->chapo()), '</br>contenu :</br> ', $post->content(), '</br>date de creation :</br> ', htmlspecialchars($post->creation_date()), '</br>date de modification :</br> ', htmlspecialchars($post->update_date()) , '</br>auteur :</br> ', htmlspecialchars($post->username());
}

if (isset($_GET['postList']))
{
	$posts = $manager->getList();
	foreach ($posts as $onePost)
	{

	echo '</br>titre :</br> <a href=\'?readPost=', htmlspecialchars($onePost->id_post()),'\'>', htmlspecialchars($onePost->title()), '</a></br>chapo :</br> ', htmlspecialchars($onePost->chapo()), '</br>contenu :</br> ', $onePost->content(), '</br>date de creation :</br> ', htmlspecialchars($onePost->creation_date()), '</br>date de modification :</br> ', htmlspecialchars($onePost->update_date()) , '</br>auteur :</br> ', htmlspecialchars($onePost->username());

	}
}

  	if (isset($_GET['write']))
{

?>

    <form action="" method="post">

    	<h2>Ecrire un article</h2>

      <p>

        Titre :<input type="text" name="title" maxlength="50" /> </br>

        Chapo :<input type="text" name="chapo" maxlength="100" /> </br>

        Contenu :<textarea name="content" rows="4" cols="40"></textarea></br>

        <input type="submit" value="Envoyer" name="addPost" /></br>


      </p>

    </form>

<?php

}

?>

  </body>

</html>





