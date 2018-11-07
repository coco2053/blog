<?php

/**
* Classe représentant le controller Frontend, qui gere la partie accessible à tous.
* @author Bastien Vacherand.
*/

class Frontend
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
    * Methode qui permet d'afficher la page contact.
    * @param void
    * @return void
    */

    function homeView()
    {

        include 'view/frontend/home.php';
    }

    /**
    * Methode qui permet d'afficher la page cv.
    * @param void
    * @return void
    */

    function cvView()
    {

        include 'view/frontend/cv.php';
    }

    /**
    * Methode qui permet d'afficher la page contact.
    * @param void
    * @return void
    */

    function contactView()
    {

        include 'view/frontend/contact.php';
    }

    /**
    * Methode qui permet d'envoyer le message de l'utilisateur à l'administrateur du site.
    * @param void
    * @return void
    */

    function contact()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {


            // On supprime les retour à la ligne
            $secure_mail = str_replace(array("\n","\r",PHP_EOL),'',$_POST['email']);

            include_once 'vendor/autoload.php';
            include_once 'model/transport.php';

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
            $user_name = htmlspecialchars($_POST['firstname']).' '.htmlspecialchars($_POST['lastname']);


            // Create a message
            $message = (new Swift_Message())

                ->setSubject('Blog, nouveau message d\'un vitieur')
                ->setFrom([$secure_mail => $user_name])
                ->setTo([$data['email'], $data['email']])
                ->setBody('Message du visiteur : '.htmlspecialchars($_POST['message']), 'text/html');

            // Send the message
            $result = $mailer->send($message);
            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.';

            header('location: '. $_SERVER["HTTP_REFERER"]);
        }
    }

    /**
    * Methode qui permet de recuperer un post et de l'afficher.
    * @param int, id du post.
    * @return void
    */

    function getPost($id_post)
    {

        $post = $this->postmanager->get($id_post);
        $comments = $this->commentmanager->getList($id_post);

        include 'view/frontend/postView.php';
    }

    /**
    * Methode qui permet de recuperer la liste de tous les posts et de les afficher.
    * @param void
    * @return void
    */

    function getPosts()
    {

        $posts = $this->postmanager->getList();
        include 'view/frontend/postsListView.php';
    }

    /**
    * Methode qui permet d'afficher la page d'inscription.
    * @param void
    * @return void
    */

    function signUpView()
    {

        include 'view/frontend/signupView.php';
    }

    /**
    * Methode qui permet d'afficher la page de recuperation du mot de passe.
    * @param void
    * @return void
    */

    function forgotPasswordView()
    {

    include 'view/frontend/forgotpasswordView.php';
    }

    /**
    * Methode qui permet d'afficher la page de reinitialisation du mot de passe.
    * @param void
    * @return void
    */

    function resetPasswordView()
    {

    include 'view/frontend/resetpasswordView.php';

    }

    /**
    * Methode qui permet de reinitialiser le mot de passe.
    * @param void
    * @return void
    */

    function resetPassword()
    {

        // On check que le mdp fasse au moins 8 caracteres
        if (preg_match("#.{8,60}#", $_POST['password'])) {

            $password = strip_tags($_POST['password']);

        } else {

            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Votre mot de passe doit comporter au moins 8 caracteres !';
            header('location: '. $_SERVER["HTTP_REFERER"]);
        }

        // On check que les 2 mdp soient les mêmes
        if ($_POST['passwordbis'] == $_POST['password'] ) {

            $passwordbis = strip_tags($_POST['passwordbis']);

        } else {

            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Veuillez retapper votre mot de passe !';
            header('location: '. $_SERVER["HTTP_REFERER"]);
        }

        if (isset($password, $passwordbis)) {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $formData = ['email' => htmlspecialchars($_POST['email']),
                        'password' => $hashed_password];

            $this->usermanager->updatePassword($formData);
            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Votre nouveau mot de passe a bien été enregistré !';
            header('location: connexion');
        }
    }

    /**
    * Methode qui permet d'envoyer le mail de reinitialiser du mot de passe.
    * @param void
    * @return void
    */

    function forgotPassword()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {

            // On check que l'adresse email soit dans la bdd
            if ($this->usermanager->exists($_POST['email'])) {

                // On supprime les retour à la ligne
                $secure_mail = str_replace(array("\n","\r",PHP_EOL),'',$_POST['email']);

                include_once 'vendor/autoload.php';
                include_once 'model/transport.php';

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message())

                    ->setSubject('Blog, réinitialisez votre mot de passe')
                    ->setFrom([$data['email'] => $data['name']])
                    ->setTo([htmlspecialchars($secure_mail), $data['email']])
                    ->setBody('Cliquez sur le lien pour <a href=\''. $data['address'].'redefinition-mot-de-passe-'. htmlspecialchars($secure_mail).'\'>réinitialiser votre mot de passe.</a>', 'text/html');

                // Send the message
                $result = $mailer->send($message);
                $_SESSION['show_message'] = true;
                $_SESSION['message'] = 'Un email vous a été envoyé à ' . htmlspecialchars($secure_mail) . ' comprenant
                                        un lien pour réinitialiser votre mot de passe.';

                header('location: connexion');

            } else {

                $_SESSION['show_message'] = true;
                $_SESSION['message'] = 'L\'adresse ' . htmlspecialchars($secure_mail) . ' n\'est pas enregistrée !';
                header('location: '. $_SERVER["HTTP_REFERER"]);
            }

        } else {


            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Vous n\'êtes pas humain !';
            header('location: '. $_SERVER["HTTP_REFERER"]);
        }
    }

    /**
    * Methode qui permet d'afficher la page de connexion.
    * @param void
    * @return void
    */

    function signInView()
    {

        include 'view/frontend/signinView.php';
    }

    /**
    * Methode qui permet à l'utilisateur de se connecter.
    * @param void
    * @return void
    */

    function signIn()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {

            $formData = ['email' => htmlspecialchars($_POST['email']),
                         'password' => htmlspecialchars($_POST['password'])];

            if ($this->usermanager->exists($_POST['email'])) {

                if ($this->usermanager->isValid($_POST['email'])) {

                    if (null !== $this->usermanager->checkPassword($formData)) {

                        header ('Location: profile-' . $this->usermanager->checkPassword($formData));

                    } else {

                        $_SESSION['show_message'] = true;
                        $_SESSION['message'] = 'Mauvais login ou mot de passe !';
                        header('location: '. $_SERVER["HTTP_REFERER"]);
                    }

                } else {

                    $_SESSION['show_message'] = true;
                    $_SESSION['message'] = 'L\'addresse email ' . $_POST['email'].' n\'a pas encore été validée !';
                    header('location: '. $_SERVER["HTTP_REFERER"]);
                }

            } else {

                $_SESSION['show_message'] = true;
                $_SESSION['message'] = 'L\'addresse email ' . $_POST['email'].' n\'est pas enregistrée !';
                header('location: '. $_SERVER["HTTP_REFERER"]);
            }

        } else {

            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Vous n\'êtes pas humain !';
            header('location: connexion');
        }
    }

    /**
    * Methode qui permet d'enregistrer un nouvel utilisateur.
    * @param void
    * @return void
    */

    function signUp()
    {

        include_once 'model/recaptcha.php';

        if ($decode['success'] == true) {

            // On check que le pseudo soit valide
            if (preg_match("#[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{3,60}#i",
               $_POST['username']) and preg_match("#[^0-9]#", $_POST['username']) ) {

                $username = strip_tags($_POST['username']);

            } else {

                 $_SESSION['show_message'] = true;
                 $_SESSION['message'] = 'Pseudo non valide !';
                 header('location: '. $_SERVER["HTTP_REFERER"]);
            }

            // On check que le mdp fasse au moins 8 caracteres
            if (preg_match("#.{8,60}#", $_POST['password'])) {

                $password = strip_tags($_POST['password']);

            } else {

                 $_SESSION['show_message'] = true;
                 $_SESSION['message'] = 'Votre mot de passe doit comporter au moins 8 caracteres !';
                 header('location: '. $_SERVER["HTTP_REFERER"]);
            }

            // On check que les 2 mdp soient les mêmes
            if ($_POST['passwordbis'] == $_POST['password'] ) {

                $passwordbis = strip_tags($_POST['passwordbis']);

            } else {

                 $_SESSION['show_message'] = true;
                 $_SESSION['message'] = 'Veuillez retapper votre mot de passe !';
                 header('location: '. $_SERVER["HTTP_REFERER"]);
                                 //throw new Exception('Veuillez retapper votre mot de passe ! </br>');
            }

            // On check que l'adresse mail soit valide
            if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {

                $email_valid = true;

            } else {

                $_SESSION['show_message'] = true;
                $_SESSION['message'] = 'L\'adresse ' . $_POST['email'] . ' n\'est pas valide, recommencez !';
                header('location: '. $_SERVER["HTTP_REFERER"]);
            }

            if ($email_valid) {

                $email_valid = false;

                if (!$this->usermanager->exists($_POST['email'])) {

                    $email = strip_tags($_POST['email']);

                } else {

                    $_SESSION['show_message'] = true;
                    $_SESSION['message'] = 'L\'adresse ' . $_POST['email'] . ' a deja été enregistrée !';
                    header('location: '. $_SERVER["HTTP_REFERER"]);
                }
            }

            if (isset($username, $password, $passwordbis, $email )) {

                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $formData = ['id_role' => '1',
                            'email' => $email,
                            'password' => $hashed_password,
                            'username' => $username,
                            'firstname' => htmlspecialchars($_POST['firstname']),
                            'valid' => 'No',
                            'asleep' => 'Yes',
                            'lastname' => htmlspecialchars($_POST['lastname'])];

                $user = new User($formData);
                $this->usermanager->add($user);

                include_once 'vendor/autoload.php';
                include_once 'model/transport.php';

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message())

                    ->setSubject('Blog, validez votre compte')
                    ->setFrom([$data['email'] => $data['name']])
                    ->setTo([htmlspecialchars($_POST['email']), $data['email']])
                    ->setBody('Cliquez sur le lien pour <a href=\''.$data['address']
                              .'?action=awakeUser&email='. htmlspecialchars($_POST['email'])
                              .'\'>valider votre compte.</a>', 'text/html');

                // Send the message
                $result = $mailer->send($message);

                 $_SESSION['show_message'] = true;
                 $_SESSION['message'] = 'Un email a été envoyé à l\'adresse : '
                                        .$email . ' pour valider votre compte !';
                 header('location: connexion');
            }

        } else {

            $_SESSION['show_message'] = true;
            $_SESSION['message'] = 'Vous n\'êtes pas humain !';
            header('location: connexion');
        }
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
