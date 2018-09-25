<?php

class Backend
{
    protected $manager,
              $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.

        $this->manager = new PostManager($this->db);
    }

    function addPost($formData)
    {

    if (!$this->manager->exists($formData['title'])) {

        $post = new Post($formData);
        $this->manager->add($post);

    } else {

        throw new Exception('Cet article existe déja !</br>');

        }
    }

    function writePostView()
    {
    require('view/backend/writePost.php');
    }



        // GETTERS //

    public function manager()
    {
        return $this->id_post;
    }

    public function db()
    {
        return $this->id_user;
    }

        // SETTERS //

    public function setManager($manager)
    {

        $this->manager = $manager;

    }

    public function setDb($db)
    {

        $this->db = $db;

    }
}






