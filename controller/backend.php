<?php

function chargerClasse($classname)
{
  require 'model/'.$classname.'.php';
}
spl_autoload_register('chargerClasse');

$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new PostManager($db);

function writePostView()
{
    require('view/backend/writePost.php');
}

function addPost($formData)
{
    global $manager;
    if (!$manager->exists($formData['title'])) {

        $post = new Post($formData);
        $manager->add($post);

    } else {

        throw new Exception('Cet article existe déja !</br>');

    }
}
