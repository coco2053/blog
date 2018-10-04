<?php

class Frontend
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


    function getPost($id_post)
    {

        $post = $this->postmanager->get($id_post);

        require('view/frontend/postView.php');
    }

    function getPosts()
    {
        $posts = $this->postmanager->getList();
        require('view/frontend/postsListView.php');
    }

    function signUpView()
    {

        require('view/frontend/signupView.php');
    }

    function forgotPasswordView()
{

    require('view/frontend/forgotpasswordView.php');
}

    function forgotPassword()
{

    // envoyer un mail à l'utilisateur avec le lien pour reinitialiser le mdp.
}
    function signInView()
    {

        require('view/frontend/signinView.php');
    }

    function signUp()
    {

        $formData = ['email' => htmlspecialchars($_POST['email']),
                     'password' => htmlspecialchars($_POST['password'])];

         if (null !== $this->usermanager->checkPassword($formData)) {

            header ('Location: index.php?action=getUser&id=' . $this->usermanager->checkPassword($formData));

       } else {

             throw new Exception('Mauvais login ou mot de passe ! </br>');
        }

    }

    function signIn()
    {

        // On check que le pseudo soit valide
        if (preg_match("#[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{3,60}#i", $_POST['username']) and preg_match("#[^0-9]#", $_POST['username']) ) {

            $username = strip_tags($_POST['username']);

        } else {

            throw new Exception('Pseudo non valide ! </br>');
        }

        // On check que le mdp fasse au moins 8 caracteres
        if (preg_match("#.{8,60}#", $_POST['password'])) {

            $password = strip_tags($_POST['password']);

        } else {

             throw new Exception('Votre mot de passe doit comporter au moins 8 caracteres ! </br>');
        }

        // On check que les 2 mdp soient les mêmes
        if ($_POST['passwordbis'] == $_POST['password'] ) {

            $passwordbis = strip_tags($_POST['passwordbis']);

        } else {

            throw new Exception('Veuillez retapper votre mot de passe ! </br>');
        }

        // On check que l'adresse mail soit valide
        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) {

            $email_valid = true;

        } else {

            throw new Exception('L\'adresse ' . $_POST['email'] . ' n\'est pas valide, recommencez !');

        }

        if ($email_valid) {

            $email_valid = false;

            if (!$this->usermanager->exists($_POST['email'])) {
                $email = strip_tags($_POST['email']);

            } else {

                throw new Exception('L\'adresse ' . $_POST['email'] . ' a deja été enregistrée !');
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
                        'lastname' => htmlspecialchars($_POST['lastname'])];

            $user = new User($formData);
            $this->usermanager->add($user);

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
