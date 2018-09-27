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
        $post = $this->manager->get($post->id_post());
        require('view/frontend/postView.php');


        /* Je voudrais afficher le post qui vient d'étre crée mais je n'y arrive pas. $this->manager->get($post->id_post()); */

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
       $post = $this->manager->get($id_post);
       $_SESSION['post'] = serialize( $post );

       require('view/backend/editPost.php');
    }

    function editPost($formData)

    {
       $post = new Post($formData);
       $this->manager->update($post);
       $post = $this->manager->get($post->id_post());
       require('view/frontend/postView.php');

    }

    function deletePost($id_post)

    {

       $this->manager->delete($id_post);

       header('location: index.php');

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






