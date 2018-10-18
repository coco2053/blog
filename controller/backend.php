<?php
/**
 * Classe représentant le controller Backend, qui gere la partie admin du site.
 * @author Bastien Vacherand.
 */

class Backend
{

    protected $postmanager,
              $usermanager,
              $commentmanager,
              $db;

      /**
   * Constructeur de la classe qui permet d'instancier la bdd et les managers.
   * @param void
   * @return void
   */

    public function __construct()
    {
        $this->db = DBFactory::getMysqlConnexionWithPDO();
        $this->postmanager = new PostManagerPDO($this->db);
        $this->usermanager = new UserManagerPDO($this->db);
        $this->commentmanager = new CommentManagerPDO($this->db);

    }

      /**
   * Methode qui permet de verifier que l'utilisateur dispose bien des droits nécessaires.
   * @param $action, le nom de la fonction qui fait appel à cette methode.
   * @return void
   */

    public function allow($action)
    {
        // On verifie que l'utilisateur dispose des droits necessaires
        if(empty($_SESSION['user'])) {

            throw new Exception('Vous ne disposez pas des droits pour acceder à cette page !</br>');

        } else if(strpos($_SESSION['user'] -> perm_action(), $action) === false) {

            throw new Exception('Vous ne disposez pas des droits pour acceder à cette page !  ' . $action.'   ' .$_SESSION['user'] -> perm_action() .'</br>');

        }
    }

      /**
   * Methode qui permet d'ajouter un post.
   * @param $formdata, array provenant du formulaire.
   * @return void
   */

    public function addPost($formData)
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

      /**
   * Methode qui permet d'ajouter un commentaire.
   * @param $id_post, id du post contenant le commentaire.
   * @return void
   */

    public function addComment($id_post)
    {

      $this->allow(__FUNCTION__);
      $formData = ['id_post' => $id_post,
                  'content' => htmlspecialchars($_POST['content']),
                  'id_user' => $_SESSION['user'] -> id_user()];
      $comment = new Comment($formData);
      $this->commentmanager->add($comment);
      throw new Exception('Votre commentaire est en attente de validation par un administrateur.');
    }

      /**
   * Methode qui permet d'afficher la page de redaction d'un post.
   * @param void
   * @return void
   */

    public function writePostView()
    {
        $this->allow(__FUNCTION__);
        include 'view/backend/writePost.php';
    }

      /**
   * Methode qui permet de recuperer un post et d'afficher la page de modification du post.
   * @param $id_post, id du post à modifier.
   * @return void
   */

    public function editPostView($id_post)

    {
       $this->allow(__FUNCTION__);
       $post = $this->postmanager->get($id_post);

       include 'view/backend/editPost.php';
    }

      /**
   * Methode qui permet de mettre à jour le post avec les infos contenues dans le formulaire.
   * @param $formData, array du formulaire de modification.
   * @return void
   */

    public function editPost($formData)

    {
       $this->allow(__FUNCTION__);
       $post = new Post($formData);
       $this->postmanager->update($post);
       $post = $this->postmanager->get($post->id_post());
       include 'view/frontend/postView.php';

    }

      /**
   * Methode qui permet de supprimer un post.
   * @param $id_post, id du post à supprimer.
   * @return void
   */
    public function deletePost($id_post)

    {
       $this->allow(__FUNCTION__);

       $this->postmanager->delete($id_post);

       header('location: index.php');

    }

      /**
   * Methode qui permet de supprimer un commentaire.
   * @param $id_comment, id du commentaire à supprimer.
   * @return void
   */

    public function deleteComment($id_comment)

    {
       $this->allow(__FUNCTION__);

       $this->commentmanager->delete($id_comment);

       header('location: '. $_SERVER["HTTP_REFERER"]);

    }

      /**
   * Methode qui permet de recuperer les info d'un utilisateur.
   * @param $id_user, id de l'utilisateur.
   * @return void
   */

    public function getUser($id_user)

    {

       $user = $this->usermanager->get($id_user);
       $_SESSION['user'] = $user;
       $this->allow(__FUNCTION__);
       include 'view/backend/userView.php';

       $this->usermanager->updateSigninDate($id_user);

    }

      /**
   * Methode qui permet de recuperer la liste de tous les utilisateurs.
   * @param $id_user, id de l'utilisateur.
   * @return void
   */

    public function getUsers($id_user)

    {
       $this->allow(__FUNCTION__);
       $users = $this->usermanager->getList($id_user);

       include 'view/backend/usersListView.php';

    }

      /**
   * Methode qui permet de valider un compte.
   * @param $id_user, id de l'utilisateur.
   * @return void
   */

    public function validateUser($id_user)

    {
       $this->allow(__FUNCTION__);
       $this->usermanager->validate($id_user);

       header('location: '. $_SERVER["HTTP_REFERER"]);

    }

      /**
   * Methode qui permet de valider un commentaire.
   * @param $id_comment, id du commentaire.
   * @return void
   */

    public function validateComment($id_comment)

    {
       $this->allow(__FUNCTION__);
       $this->commentmanager->validate($id_comment);

       header('location: '. $_SERVER["HTTP_REFERER"]);

    }

      /**
   * Methode qui permet d'activer un compte depuis le lien envoyé par mail.
   * @param $email, adresse mail de l'utilisateur.
   * @return void
   */
    public function awakeUser($email)

    {

       $this->usermanager->awake($email);
       echo '<script type="text/javascript">alert("message sent")</script>';
    }

      /**
   * Methode qui permet de déconnecter un utilisateur.
   * @param void
   * @return void
   */
    public function signOut()

    {
       $_SESSION = array();
       session_destroy();
       header('location: index.php');

    }

      /**
   * Methode qui permet de recuperer la liste des utilisateurs en attente de validation.
   * @param void
   * @return void
   */

    public function getPendingUsers()

    {
       $this->allow(__FUNCTION__);

       $users = $this->usermanager->getPendingList();

       include 'view/backend/pendingUsersListView.php';

    }

    public function getPendingComments()

      /**
   * Methode qui permet de recuperer la liste des commentaires en attente de validation.
   * @param void
   * @return void
   */

    {
       $this->allow(__FUNCTION__);

       $comments = $this->commentmanager->getPendingList();

       include 'view/backend/pendingCommentsListView.php';

    }

      /**
   * Methode qui permet de supprimer un utilisateur.
   * @param $id_user, id de l'utilisateur à supprimer.
   * @return void
   */

    public function deleteUser($id_user)

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

    public function commentmanager()
    {
        return $this->commentmanager;
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

    public function setCommentmanager($commentmanager)
    {

        $this->commentmanager = $commentmanager;

    }

    public function setDb($db)
    {

        $this->db = $db;

    }
}
