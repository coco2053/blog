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
              $database;

    /**
    * Constructeur de la classe qui permet d'instancier la bdd et les managers.
    * @param void
    * @return void
    */

    public function __construct()
    {
        $this->database = DBFactory::getMysqlConnexionWithPDO();
        $this->postmanager = new PostManagerPDO($this->database);
        $this->usermanager = new UserManagerPDO($this->database);
        $this->commentmanager = new CommentManagerPDO($this->database);

    }

    /**
    * Methode qui permet de verifier que l'utilisateur dispose bien des droits nécessaires.
    * @param string, le nom de la fonction qui fait appel à cette methode.
    * @return void
    */

    public function allow($action)
    {
        // On verifie que l'utilisateur dispose des droits necessaires
        if(empty($_SESSION['user'])) {

          $_SESSION['show_message'] = true;
          $_SESSION['message'] = 'Vous ne disposez pas des droits requis pour acceder à cette page !';
          header('location: '. $_SERVER["HTTP_REFERER"]);

        } else if(strpos($_SESSION['user'] -> perm_action(), $action) === false) {

          $_SESSION['show_message'] = true;
          $_SESSION['message'] = 'Vous ne disposez pas des droits requis pour acceder à cette page !';
          header('location: '. $_SERVER["HTTP_REFERER"]);

        }
    }

    /**
    * Methode qui permet de verifier l'image envoyé par le formulaire.
    *L'image est formatée et deplacée dans le bon repertoire.
    * @param array, provenant du formulaire.
    * @return string
    */

    public function checkFile($file)
    {

        if ($_FILES['my_file']['size'] > 100) {


            if ($_FILES['my_file']['error'] > 0) {
                echo "Erreur lors du transfert";
            }

            $maxsize = 1048576;
            $uploads_dir = 'public/upload';
            $valid_extensions = array( 'jpg' , 'jpeg' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['my_file']['name'], '.')  ,1)  );

            if ( !in_array($extension_upload, $valid_extensions) ) {
                echo "Extension incorrecte";
            }

            if ($_FILES['my_file']['size'] > $maxsize){
                echo "Le fichier est trop gros";
            }

            $file_name1 = time();
            $file_name2 = "{$file_name1}.{$extension_upload}";

            $width = 700;
            $height = 350;

            $image = imagecreatefromjpeg("$uploads_dir/$file_name2");
            $size = getimagesize("$uploads_dir/$file_name2");

            $output = imagecreatetruecolor($width,$height);

            $ratio = min($size[0]/$width,$size[1]/$height);

            $deltax = $size[0]-($ratio * $width);
            $deltay = $size[1]-($ratio * $height);

            imagecopyresampled($output,$image,0,0,$deltax/2,$deltay/2,$width,$height,$size[0]-$deltax,$size[1]-$deltay);

            imagejpeg($output, "$uploads_dir/$file_name2", 100);

            return $file_name2;

        } else {

            $file_name2 ='no-image.jpg';
            return $file_name2;
        }
    }

    /**
    * Methode qui permet d'ajouter un post.
    * @param array, provenant du formulaire.
    * @return void
    */

    public function addPost($formData)
    {

      $this->allow(__FUNCTION__);

      if (!$this->postmanager->exists($formData['title'])) {

          $post = new Post($formData);
          $this->postmanager->add($post);
          $post = $this->postmanager->get($post->id_post());
          $_SESSION['show_message'] = true;
          $_SESSION['message'] = 'Votre article est publié !';

          header('location: article-'.$post->id_post());

      } else {

          $_SESSION['show_message'] = true;
          $_SESSION['message'] = 'Votre article est publié !';

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

        if(strpos($_SESSION['user'] -> perm_action(), 'validateComment') === false) {
            $valid = 'No';

        } else {

          $valid = 'Yes';
        }

        $formData = ['id_post' => $id_post,
                    'content' => nl2br(htmlspecialchars(htmlspecialchars($_POST['content'])),
                    'valid' => $valid,
                    'id_user' => $_SESSION['user'] -> id_user()];

        $comment = new Comment($formData);
        $this->commentmanager->add($comment);

        if($valid == 'No') {
            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Votre commentaire est en attente de validation par un administrateur.';
        }

        header('location: article-'.$id_post);

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
    * @param int, id du post à modifier.
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
    * @param array, du formulaire de modification.
    * @return void
    */

    public function editPost($formData)
    {

        $this->allow(__FUNCTION__);
        $post = new Post($formData);
        $this->postmanager->update($post);
        $post = $this->postmanager->get($post->id_post());
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Article modifié !';
        header('location: article-'.$post->id_post());

    }

    /**
    * Methode qui permet de supprimer un post.
    * @param int, id du post à supprimer.
    * @return void
    */

    public function deletePost($id_post)
    {

        $this->allow(__FUNCTION__);

        $this->postmanager->delete($id_post);
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Article supprimé !';

        header('Location: articles');
    }

    /**
    * Methode qui permet de supprimer un commentaire.
    * @param int, id du commentaire à supprimer.
    * @return void
    */

    public function deleteComment($id_comment)
    {

        $this->allow(__FUNCTION__);

        $this->commentmanager->delete($id_comment);

        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Commentaire supprimé !';

        header('location: '. $_SERVER["HTTP_REFERER"]);
    }

    /**
    * Methode qui permet de recuperer les info d'un utilisateur.
    * @param int, id de l'utilisateur.
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
    * @param int, id de l'utilisateur.
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
    * @param int, id de l'utilisateur.
    * @return void
    */

    public function validateUser($id_user)
    {

        $this->allow(__FUNCTION__);

        $this->usermanager->validate($id_user);
        $user = $this->usermanager->get($id_user);

        include_once 'vendor/autoload.php';
        include_once 'model/transport.php';

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message())

            ->setSubject('Blog, votre compte a été validé !')
            ->setFrom([nl2br(htmlspecialchars($data['email'])) => nl2br(htmlspecialchars($data['name']))])
            ->setTo([nl2br(htmlspecialchars($user->email())), nl2br(htmlspecialchars($user->email()))])
            ->setBody('Votre compte vient d\'etre validé ! Clickez sur le lien pour
                      <a href=\''.nl2br(htmlspecialchars($data['address'])).'connexion\'>vous connecter.</a>', 'text/html');

        // Send the message
        $mailer->send($message);
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Compte validé ! Email envoyé à l\'utilisateur.';
        header('location: '. $_SERVER["HTTP_REFERER"]);
    }

    /**
    * Methode qui permet de valider un commentaire.
    * @param int, id du commentaire.
    * @return void
    */

    public function validateComment($id_comment)
    {

        $this->allow(__FUNCTION__);

        $this->commentmanager->validate($id_comment);
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Commentaire validé !';
        header('location: '. $_SERVER["HTTP_REFERER"]);
    }

    /**
    * Methode qui permet d'activer un compte depuis le lien envoyé par mail.
    * @param string, adresse mail de l'utilisateur.
    * @return void
    */
    public function awakeUser($email)
    {

        $this->usermanager->awake($email);
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Votre inscription a bien été prise en compte.
                                Un administrateur doit maintenant la valider.';

        header('location: connexion');
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
        session_start();

        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Vous avez été deconnecté.';

        header('location: articles');
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

    /**
    * Methode qui permet de recuperer la liste des commentaires en attente de validation.
    * @param void
    * @return void
    */

    public function getPendingComments()
    {

        $this->allow(__FUNCTION__);

        $comments = $this->commentmanager->getPendingList();

        include 'view/backend/pendingCommentsListView.php';
    }

    /**
    * Methode qui permet de supprimer un utilisateur.
    * @param int, id de l'utilisateur à supprimer.
    * @return void
    */

    public function deleteUser($id_user)
    {

        $this->allow(__FUNCTION__);

        $this->usermanager->delete($id_user);
        $_SESSION['show_message'] = true;
        $_SESSION['message'] = 'Compte supprimé !';

        header('location: '. $_SERVER["HTTP_REFERER"]);
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

    public function database()
    {

        return $this->database;
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

    public function setDatabase($database)
    {

        $this->database = $database;
    }
}
