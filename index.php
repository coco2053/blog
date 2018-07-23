<?php

// On enregistre notre autoload.

function chargerClasse($classname)

{

  require 'model/'.$classname.'.php';

}

spl_autoload_register('chargerClasse');

$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.




$formData = ['title' => 'Les aquariums d\'eau douce',
			 'chapo' => 'Un loisir très apaisant!',
			 'content' => 'kjbgeibgejjg e gbijgb eibgi zebgijbeijg biebgiejb igjbeijbgiejbgib iezjgbkjbtgkjebtgijbe gkjebkjgbekjtbg kjbezkjbkjbgkejbtgkj bzkejt bgkjbtg kjbtgk zjbgkj btkzjbgkjbktjzbgk zjebtgkùsjbeg tezbgkjb zekbgkzebgkh',
			 'id_user' => '1'];

$manager = new PostManager($db);
$post = new Post($formData);

if (!$manager->exists($formData['title']))
{
	$manager->add($post);
}
else {
	echo 'cet article existe déja !';
}

