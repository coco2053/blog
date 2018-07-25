<?php

// On enregistre notre autoload.

function chargerClasse($classname)

{

  require 'model/'.$classname.'.php';

}

spl_autoload_register('chargerClasse');

$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.




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



