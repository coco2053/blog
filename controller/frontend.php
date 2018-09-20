<?php

// On enregistre notre autoload.

function chargerClasse($classname)

{

  require 'model/'.$classname.'.php';

}

spl_autoload_register('chargerClasse');

$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new PostManager($db);


function getPost($id_post)
{
    global $manager;
    $post = $manager->get($id_post);

    require('view/frontend/postView.php');
}

function getPosts()
{
    global $manager;
    $posts = $manager->getList();
    require('view/frontend/postsListView.php');
}
