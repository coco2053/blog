<?php

class Backend
{
    protected $postmanager,
              $useranager,
              $db;

    public function __construct()
    {
        $this->db = DBFactory::getMysqlConnexionWithPDO();
        $this->postmanager = new PostmanagerPDO($this->db);
        $this->usermanager = new UsermanagerPDO($this->db);
    }

    function addPost($formData)
    {

    if (!$this->postmanager->exists($formData['title'])) {

        $post = new Post($formData);
        $this->postmanager->add($post);
        $post = $this->postmanager->get($post->id_post());
        require('view/frontend/postView.php');


        /* Je voudrais afficher le post qui vient d'étre crée mais je n'y arrive pas. $this->postmanager->get($post->id_post()); */

    } else {

        throw new Exception('Cet article existe déja !</br>');

        }
    }

    function writePostView()
    {
        require('view/backend/writePost.php');
    }

    function editPostView($id_post)

    {
       $post = $this->postmanager->get($id_post);
       $_SESSION['post'] = serialize( $post );

       require('view/backend/editPost.php');
    }

    function editPost($formData)

    {
       $post = new Post($formData);
       $this->postmanager->update($post);
       $post = $this->postmanager->get($post->id_post());
       require('view/frontend/postView.php');

    }

    function deletePost($id_post)

    {

       $this->postmanager->delete($id_post);

       header('location: index.php');

    }

    function getUser($id_user)

    {

       $user = $this->usermanager->get($id_user);

       require('view/backend/userView.php');

       $this->usermanager->updateSignupDate($id_user);

    }

    function getUsers()

    {

       $users = $this->usermanager->getList();

       require('view/backend/usersListView.php');



    }

        // GETTERS //

    public function postmanager()
    {
        return $this->postmanager;
    }

    public function usermanager()
    {
        return $this->usermanager;
    }

    public function db()
    {
        return $this->db;
    }

        // SETTERS //

    public function setPostmanager($postmanager)
    {

        $this->postmanager = $postmanager;

    }


    public function setUsermanager($usermanager)
    {

        $this->usermanager = $usermanager;

    }

    public function setDb($db)
    {

        $this->db = $db;

    }
}






