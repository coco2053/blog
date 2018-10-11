<?php

class Backend
{
    protected $postmanager,
              $usermanager,
              $db;

    public function __construct()
    {
        $this->db = DBFactory::getMysqlConnexionWithPDO();
        $this->postmanager = new PostManagerPDO($this->db);
        $this->usermanager = new UserManagerPDO($this->db);
    }

    function addPost($formData)
    {

    if (!$this->postmanager->exists($formData['title'])) {

        $post = new Post($formData);
        $this->postmanager->add($post);
        $post = $this->postmanager->get($post->id_post());
        include 'view/frontend/postView.php';

    } else {

        throw new Exception('Cet article existe déja !</br>');

        }
    }

    function writePostView()
    {
        include 'view/backend/writePost.php';
    }

    function editPostView($id_post)

    {
       $post = $this->postmanager->get($id_post);
       $_SESSION['post'] = serialize( $post );

       include 'view/backend/editPost.php';
    }

    function editPost($formData)

    {
       $post = new Post($formData);
       $this->postmanager->update($post);
       $post = $this->postmanager->get($post->id_post());
       include 'view/frontend/postView.php';

    }

    function deletePost($id_post)

    {

       $this->postmanager->delete($id_post);

       header('location: index.php');

    }

    function getUser($id_user)

    {

       $user = $this->usermanager->get($id_user);

       include 'view/backend/userView.php';

       $this->usermanager->updateSigninDate($id_user);

    }

    function getUsers($id_user)

    {

       $users = $this->usermanager->getList($id_user);

       include 'view/backend/usersListView.php';

    }

    function validateUser($id_user)

    {

       $users = $this->usermanager->validate($id_user);

       //header('location: '. $_SERVER["HTTP_REFERER"]);

    }

    function signOut()

    {
       $_SESSION = array();
       session_destroy();
       header('location: index.php');

    }

    function getPendingUsers($id_user)

    {

       $users = $this->usermanager->getPendingList($id_user);

       include 'view/backend/pendingUsersListView.php';

    }

    function deleteUser($id_user)

    {

       $this->usermanager->delete($id_user);

       header('location: index.php?action=getUsersView');

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
