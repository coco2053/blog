<?php

class Frontend
{
    protected $manager,
              $db;

    public function __construct()
    {
        $this->db = DBFactory::getMysqlConnexionWithPDO();
        $this->manager = new PostManagerPDO($this->db);
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

    function signUpView()
    {

        require('view/frontend/signupView.php');
    }

    function signInView()
    {

        require('view/frontend/signinView.php');
    }

        // GETTERS //

    public function manager()
    {
        return $this->manager;
    }

    public function db()
    {
        return $this->db;
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
