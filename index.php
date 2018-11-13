<?php
/*
include 'controller/Frontend.php';
include 'controller/Backend.php';
include  'model/autoload.php';
//use \Bastien\Blog\Controller\Frontend;
*/

use \Bastien\blog\Autoloader;
use \Bastien\blog\controller\Frontend;
use \Bastien\blog\controller\Backend;

//Autoload
require('Autoloader.php');

Autoloader::register();

session_start();

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'addPostView') {
            $backend = new Backend();
            $backend->writePostView();
        } elseif ($_GET['action'] == 'addPost') {
            $backend = new Backend();

            $formData = ['title' => nl2br(htmlspecialchars($_POST['title'])),
                        'chapo' => nl2br(htmlspecialchars($_POST['chapo'])),
                        'content' => nl2br(htmlspecialchars($_POST['content'])),
                        'idUser' => nl2br(htmlspecialchars($_SESSION['user'] -> idUser())),
                        'image' => $backend->checkFile($_FILES)];
            $backend->addPost($formData);
        } elseif ($_GET['action'] == 'editPostView') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->editPostView($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->deleteComment($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'editPost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $formData = ['idPost' => nl2br(htmlspecialchars($_GET['id'])),
                            'title' => nl2br(htmlspecialchars($_POST['title'])),
                            'chapo' => nl2br(htmlspecialchars($_POST['chapo'])),
                            'content' => nl2br(htmlspecialchars($_POST['content'])),
                            'idUser' => '1'];

                $backend = new Backend();
                $backend->editPost($formData);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->deletePost($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'readPost') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $frontend = new Frontend();
                $frontend->getPost($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'getUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->getUser($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'deleteUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->deleteUser($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->addComment($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'postsList') {
                $frontend = new Frontend();
                $frontend->getPosts();
        } elseif ($_GET['action'] == 'writePostView') {
                $backend = new Backend();
                $backend->writePostView();
        } elseif ($_GET['action'] == 'forgotPasswordView') {
                $frontend = new Frontend();
                $frontend->forgotPasswordView();
        } elseif ($_GET['action'] == 'forgotPassword') {
                $frontend = new Frontend();
                $frontend->forgotPassword();
        } elseif ($_GET['action'] == 'resetPasswordView') {
                $frontend = new Frontend();
                $frontend->resetPasswordView();
        } elseif ($_GET['action'] == 'resetPassword') {
                $frontend = new Frontend();
                $frontend->resetPassword();
        } elseif ($_GET['action'] == 'signUpView') {
                $frontend = new Frontend();
                $frontend->signUpView();
        } elseif ($_GET['action'] == 'signInView') {
                $frontend = new Frontend();
                $frontend->signInView();
        } elseif ($_GET['action'] == 'signOut') {
                $backend = new Backend();
                $backend->signOut();
        } elseif ($_GET['action'] == 'getPendingComments') {
                $backend = new Backend();
                $backend->getPendingComments();
        } elseif ($_GET['action'] == 'getUsersView') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->getUsers($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'awakeUser') {
            if (isset($_GET['email'])) {
                $backend = new Backend();
                $backend->awakeUser($_GET['email']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'validateUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->validateUser($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'validateComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $backend = new Backend();
                $backend->validateComment($_GET['id']);
            } else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'signUp') {
            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {
                $frontend = new Frontend();
                $frontend->signUp();
            }
        } elseif ($_GET['action'] == 'signIn') {
            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {
                $frontend = new Frontend();
                $frontend->signIn();
            }
        } elseif ($_GET['action'] == 'getPendingUsersView') {
            $backend = new Backend();
            $backend->getPendingUsers();
        } elseif ($_GET['action'] == 'cvView') {
            $frontend = new Frontend();
            $frontend->cvView();
        } elseif ($_GET['action'] == 'homeView') {
            $frontend = new Frontend();
            $frontend->homeView();
        } elseif ($_GET['action'] == 'contactView') {
            $frontend = new Frontend();
            $frontend->contactView();
        } elseif ($_GET['action'] == 'postsListView') {
            $frontend = new Frontend();
            $frontend->getPosts();
        } elseif ($_GET['action'] == 'contact') {
            $frontend = new Frontend();
            $frontend->contact();
        }
    } else {
        $frontend = new Frontend();
        $frontend->homeView();
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();

    include 'view/errorView.php';
}
