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

    function allow($action)
    {
        // On verifie que l'utilisateur dispose des droits necessaires
        if(empty($_SESSION['user'])) {

            throw new Exception('Vous ne disposez pas des droits pour acceder à cette page !</br>');

        } else if(strpos($_SESSION['user'] -> perm_action(), $action) === false) {

            throw new Exception('Vous ne disposez pas des droits pour acceder à cette page !  ' . $action.'   ' .$_SESSION['user'] -> perm_action() .'</br>');

        }
    }

    function addPost($formData)
    {

      $this->allow(__FUNCTION__);

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
        $this->allow(__FUNCTION__);
        include 'view/backend/writePost.php';
    }

    function editPostView($id_post)

    {
       $this->allow(__FUNCTION__);
       $post = $this->postmanager->get($id_post);
       $_SESSION['post'] = serialize( $post );

       include 'view/backend/editPost.php';
    }

    function editPost($formData)

    {
       $this->allow(__FUNCTION__);
       $post = new Post($formData);
       $this->postmanager->update($post);
       $post = $this->postmanager->get($post->id_post());
       include 'view/frontend/postView.php';

    }

    function deletePost($id_post)

    {
       $this->allow(__FUNCTION__);

       $this->postmanager->delete($id_post);

       header('location: index.php');

    }

    function getUser($id_user)

    {

       $user = $this->usermanager->get($id_user);
       $_SESSION['user'] = $user;
       $this->allow(__FUNCTION__);
       include 'view/backend/userView.php';

       $this->usermanager->updateSigninDate($id_user);

    }

    function getUsers($id_user)

    {
       $this->allow(__FUNCTION__);
       $users = $this->usermanager->getList($id_user);

       include 'view/backend/usersListView.php';

    }

    function validateUser($id_user)

    {
       $this->allow(__FUNCTION__);
       $users = $this->usermanager->validate($id_user);

       header('location: '. $_SERVER["HTTP_REFERER"]);

    }

    function awakeUser($email)

    {

       $this->usermanager->awake($email);
       echo '<script type="text/javascript">alert("message sent")</script>';

       //throw new Exception('Votre inscription a bien été prise en compte ! <br> Elle est desormais en attente de validation par un administrateur du site.');

    }

    function signOut()

    {

       $_SESSION = array();
       session_destroy();
       header('location: index.php');

    }

    function getPendingUsers()

    {
       $this->allow(__FUNCTION__);

       $users = $this->usermanager->getPendingList();

       include 'view/backend/pendingUsersListView.php';

    }

    function deleteUser($id_user)

    {
       $this->allow(__FUNCTION__);

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
