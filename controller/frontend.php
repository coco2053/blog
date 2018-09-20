<?php

class Frontend
{
    protected $manager,
              $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.

        $this->manager = new PostManager($this->db);
    }


    function getPost($id_post)
    {

        $post = $this->manager->get($id_post);

        require('view/frontend/postView.php');
    }

    function getPosts()
    {
        $posts = $this->manager->getList();
        require('view/frontend/postsListView.php');
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
