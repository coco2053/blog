<?php

/**
* Classe représentant le controller Frontend, qui gere la partie accessible à tous.
* @author Bastien Vacherand.
*/

namespace Bastien\controller;

use \Bastien\model\PostManagerPDO;
use \Bastien\model\UserManagerPDO;
use \Bastien\model\CommentManagerPDO;
use \Bastien\model\DBFactory;
use \Bastien\model\Comment;
use \Bastien\model\Post;
use \Bastien\model\User;
use \Bastien\model\Session;

class Frontend
{

    protected $postmanager;
    protected $usermanager;
    protected $commentmanager;
    protected $database;
    protected $session;

    /**
    * Constructeur de la classe qui permet d'instancier la bdd et les managers.
    * @param void
    * @return void
    */

    public function __construct()
    {
        $this->database = new DBFactory();
        $this->session = new Session();
        $this->postmanager = new PostManagerPDO($this->database->getMysqlConnexionWithPDO());
        $this->usermanager = new UserManagerPDO($this->database->getMysqlConnexionWithPDO());
        $this->commentmanager = new CommentManagerPDO($this->database->getMysqlConnexionWithPDO());
    }

    /**
    * Methode qui permet d'afficher la page contact.
    * @param void
    * @return void
    */

    public function homeView()
    {

        include 'view/frontend/home.php';
    }

    /**
    * Methode qui permet d'afficher la page cv.
    * @param void
    * @return void
    */

    public function cvView()
    {

        include 'view/frontend/cv.php';
    }

    /**
    * Methode qui permet d'afficher la page contact.
    * @param void
    * @return void
    */

    public function contactView()
    {

        include 'view/frontend/contact.php';
    }

    /**
    * Methode qui permet d'envoyer le message de l'utilisateur à l'administrateur du site.
    * @param void
    * @return void
    */

    public function contact()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {
            // On supprime les retour à la ligne
            $secure_mail = str_replace(array("\n","\r", PHP_EOL), '', $_POST['email']);

            include_once 'model/transport.php';

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);
            $user_name = nl2br(htmlspecialchars($_POST['firstname'])).' '.nl2br(htmlspecialchars($_POST['lastname']));


            // Create a message
            $message = (new \Swift_Message())

                ->setSubject('Blog, nouveau message d\'un vitieur')
                ->setFrom([nl2br(htmlspecialchars($secure_mail)) => nl2br(htmlspecialchars($user_name))])
                ->setTo([nl2br(htmlspecialchars($data['email'])), nl2br(htmlspecialchars($data['email']))])
                ->setBody('Message du visiteur : '.nl2br(htmlspecialchars($_POST['message'])), 'text/html');

            // Send the message
            $mailer->send($message);
            $this->session->set('show_message', true);
            $this->session->set('message', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            header('location: '. $_SERVER["HTTP_REFERER"]);
            return;
        }
        $this->session->set('show_message', true);
        $this->session->set('message', 'Vous n\'êtes pas humain !');
        header('location: '. $_SERVER["HTTP_REFERER"]);
    }

    /**
    * Methode qui permet de recuperer un post et de l'afficher.
    * @param int, id du post.
    * @return void
    */

    public function getPost($idPost)
    {
        $post = $this->postmanager->get($idPost);
        $comments = $this->commentmanager->getList($idPost);

        include 'view/frontend/postView.php';
    }

    /**
    * Methode qui permet de recuperer la liste de tous les posts et de les afficher.
    * @param void
    * @return void
    */

    public function getPosts()
    {

        $posts = $this->postmanager->getList();
        include 'view/frontend/postsListView.php';
    }

    /**
    * Methode qui permet d'afficher la page d'inscription.
    * @param void
    * @return void
    */

    public function signUpView()
    {

        include 'view/frontend/signupView.php';
    }

    /**
    * Methode qui permet d'afficher la page de recuperation du mot de passe.
    * @param void
    * @return void
    */

    public function forgotPasswordView()
    {

        include 'view/frontend/forgotpasswordView.php';
    }

    /**
    * Methode qui permet d'afficher la page de reinitialisation du mot de passe.
    * @param void
    * @return void
    */

    public function resetPasswordView()
    {

        include 'view/frontend/resetpasswordView.php';
    }

    /**
    * Methode qui permet de reinitialiser le mot de passe.
    * @param void
    * @return void
    */

    public function resetPassword()
    {

        // On check que le mdp fasse au moins 8 caracteres
        if (!preg_match("#.{8,60}#", $_POST['password'])) {
            $this->session->set('show_message', true);
            $this->session->set('message', 'Votre mot de passe doit comporter au moins 8 caracteres !');
            header('location: '. $_SERVER["HTTP_REFERER"]);
            return;
        }
        // On check que les 2 mdp soient les mêmes
        if ($_POST['passwordbis'] !== $_POST['password']) {
            $this->session->set('show_message', true);
            $this->session->set('message', 'Veuillez retapper votre mot de passe !');
            header('location: '. $_SERVER["HTTP_REFERER"]);
            return;
        }

        $password = strip_tags($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $formData = ['email' => nl2br(htmlspecialchars($_POST['email'])),
                        'password' => $hashed_password];
        $this->usermanager->updatePassword($formData);
        $this->session->set('show_message', true);
        $this->session->set('message', 'Votre nouveau mot de passe a bien été enregistré !');
        header('location: connexion');
    }

    /**
    * Methode qui permet d'envoyer le mail de reinitialiser du mot de passe.
    * @param void
    * @return void
    */

    public function forgotPassword()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {
            // On supprime les retour à la ligne
            $secure_mail = str_replace(array("\n", "\r", PHP_EOL), '', $_POST['email']);
            // On check que l'adresse email soit dans la bdd
            if ($this->usermanager->exists($secure_mail)) {
                include_once 'vendor/autoload.php';
                include_once 'model/transport.php';

                // Create the Mailer using your created Transport
                $mailer = new \Swift_Mailer($transport);

                // Create a message
                $message = (new \Swift_Message())

                    ->setSubject('Blog, réinitialisez votre mot de passe')
                    ->setFrom([nl2br(htmlspecialchars($data['email'])) => nl2br(htmlspecialchars($data['name']))])
                    ->setTo([nl2br(htmlspecialchars($secure_mail)), nl2br(htmlspecialchars($data['email']))])
                    ->setBody('Cliquez sur le lien pour <a href=\''. nl2br(htmlspecialchars($data['address'])).'redefinition-mot-de-passe-'. nl2br(htmlspecialchars($secure_mail)).'\'>réinitialiser votre mot de passe.</a>', 'text/html');

                // Send the message
                $mailer->send($message);
                $this->session->set('show_message', true);
                $this->session->set('message', 'Un email vous a été envoyé à ' . nl2br(htmlspecialchars($secure_mail)) .
                                       ' comprenant un lien pour réinitialiser votre mot de passe. Si vous ne voyez
                                        pas l\'email, regardez dans vos courriers indésirables.');

                header('location: connexion');
                return;
            }
            $this->session->set('show_message', true);
            $this->session->set('message', 'L\'adresse ' . nl2br(htmlspecialchars($secure_mail)) .
                                   ' n\'est pas enregistrée !');
            header('location: '. $_SERVER["HTTP_REFERER"]);
            return;
        }
        $this->session->set('show_message', true);
        $this->session->set('message', 'Vous n\'êtes pas humain !');
        header('location: '. $_SERVER["HTTP_REFERER"]);
    }

    /**
    * Methode qui permet d'afficher la page de connexion.
    * @param void
    * @return void
    */

    public function signInView()
    {

        include 'view/frontend/signinView.php';
    }

    /**
    * Methode qui permet à l'utilisateur de se connecter.
    * @param void
    * @return void
    */

    public function signIn()
    {
        include_once 'model/recaptcha.php';
        if ($decode['success'] == true) {
            $formData = ['email' => nl2br(htmlspecialchars($_POST['email'])),
                         'password' => nl2br(htmlspecialchars($_POST['password']))];
            if ($this->usermanager->exists($_POST['email'])) {
                if ($this->usermanager->isValid($_POST['email'])) {
                    if (null !== $this->usermanager->checkPassword($formData)) {
                        header('Location: profile-' . $this->usermanager->checkPassword($formData));
                        return;
                    }
                    $this->session->set('show_message', true);
                    $this->session->set('message', 'Mauvais login ou mot de passe !');
                    header('location: '. $_SERVER["HTTP_REFERER"]);
                    return;
                }
                $this->session->set('show_message', true);
                $this->session->set('message', 'L\'addresse email ' . nl2br(htmlspecialchars($_POST['email'])).' n\'a pas encore été validée !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }
            $this->session->set('show_message', true);
            $this->session->set('message', 'L\'addresse email ' . nl2br(htmlspecialchars($_POST['email'])).' n\'est pas enregistrée !');
            header('location: '. $_SERVER["HTTP_REFERER"]);
            return;
        }
        $this->session->set('show_message', true);
        $this->session->set('message', 'Vous n\'êtes pas humain !');
        header('location: connexion');
    }
    /**
    * Methode qui permet d'enregistrer un nouvel utilisateur.
    * @param void
    * @return void
    */

    public function signUp()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {
            // On check que le pseudo soit valide
            if (!preg_match("#[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{3,60}#i", $_POST['username']) or !preg_match("#[^0-9]#", $_POST['username'])) {
                $this->session->set('show_message', true);
                $this->session->set('message', 'Pseudo non valide !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }

            // On check que le mdp fasse au moins 8 caracteres
            if (!preg_match("#.{8,60}#", $_POST['password'])) {
                $this->session->set('show_message', true);
                $this->session->set('message', 'Votre mot de passe doit comporter au moins 8 caracteres !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }

            // On check que les 2 mdp soient les mêmes
            if ($_POST['passwordbis'] !== $_POST['password']) {
                $this->session->set('show_message', true);
                $this->session->set('message', 'Veuillez retapper votre mot de passe !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }

            // On check que l'adresse mail soit valide
            if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {
                $this->session->set('show_message', true);
                $this->session->set('message', 'L\'adresse ' . nl2br(htmlspecialchars($_POST['email'])) .
                                       ' n\'est pas valide, recommencez !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }

            if ($this->usermanager->exists($email)) {
                $this->session->set('show_message', true);
                $this->session->set('message', 'L\'adresse ' . nl2br(htmlspecialchars($_POST['email'])) .
                                           ' a deja été enregistrée !');
                header('location: '. $_SERVER["HTTP_REFERER"]);
                return;
            }
            $username = strip_tags($_POST['username']);
            $password = strip_tags($_POST['password']);
            $email = strip_tags($_POST['email']);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $formData = ['idRole' => '1',
                        'email' => $email,
                        'password' => $hashed_password,
                        'username' => $username,
                        'firstname' => nl2br(htmlspecialchars($_POST['firstname'])),
                        'valid' => 'No',
                        'asleep' => 'Yes',
                        'lastname' => nl2br(htmlspecialchars($_POST['lastname']))];

            $user = new User($formData);
            $this->usermanager->add($user);

            include_once 'model/transport.php';

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message())

                ->setSubject('Blog, validez votre compte')
                ->setFrom([nl2br(htmlspecialchars($data['email'])) => nl2br(htmlspecialchars($data['name']))])
                ->setTo([nl2br(htmlspecialchars($_POST['email'])), nl2br(htmlspecialchars($data['email']))])
                ->setBody('Cliquez sur le lien pour <a href=\''.nl2br(htmlspecialchars($data['address']))
                         .'?action=awakeUser&email='. nl2br(htmlspecialchars($_POST['email']))
                         .'\'>valider votre compte.</a>', 'text/html');

            // Send the message
            $mailer->send($message);

            $this->session->set('show_message', true);
            $this->session->set('message', 'Un email a été envoyé à l\'adresse : '
                                        .nl2br(htmlspecialchars($email)) . ' pour valider votre compte ! Si vous ne voyez
                                        pas l\'email, regardez dans vos courriers indésirables.');
            header('location: connexion');
            return;
        }
        $this->session->set('show_message', true);
        $this->session->set('message', 'Vous n\'êtes pas humain !');
        header('location: connexion');
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

    public function session()
    {

        return $this->session;
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

    public function setSession($session)
    {

        $this->session = $session;
    }
}
