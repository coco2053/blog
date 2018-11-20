<?php

use \Bastien\controller\Frontend;
use \Bastien\controller\Backend;
use \Bastien\model\Session;

//Autoload
require_once 'vendor/autoload.php';

$session = new Session();
$session->start();

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'addPostView') {
            $backend = new Backend();
            $backend->writePostView();
            return;
        } elseif ($_GET['action'] == 'addPost') {
            $backend = new Backend();
            $myfile = $_FILES;
            $formData = ['title' => strip_tags($_POST['title']),
                        'chapo' => strip_tags($_POST['chapo']),
                        'content' => strip_tags($_POST['content']),
                        'idUser' => $session->get('user') -> idUser(),
                        'image' => $backend->checkFile($myfile)];
            $backend->addPost($formData);
            return;
        } elseif ($_GET['action'] == 'editPostView') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idPost = $_GET['id'];
                $backend = new Backend();
                $backend->editPostView($idPost);
                return;
            }
            throw new \Exception('Aucun identifiant de billet envoyé');
            return;
        } elseif ($_GET['action'] == 'deleteComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idComment = $_GET['id'];
                $backend = new Backend();
                $backend->deleteComment($idComment);
                return;
            }
            throw new \Exception('Aucun identifiant de commentaire envoyé');
            return;
        } elseif ($_GET['action'] == 'editPost') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idPost = $_GET['id'];
                $formData = ['idPost' => strip_tags($idPost),
                            'title' => strip_tags($_POST['title']),
                            'chapo' => strip_tags($_POST['chapo']),
                            'content' => strip_tags($_POST['content']),
                            'idUser' => '1'];

                $backend = new Backend();
                $backend->editPost($formData);
                return;
            }
            throw new \Exception('Aucun identifiant de billet envoyé');
        } elseif ($_GET['action'] == 'deletePost') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idPost = $_GET['id'];
                $backend = new Backend();
                $backend->deletePost($idPost);
                return;
            }
            throw new \Exception('Aucun identifiant de billet envoyé');
            return;
        } elseif ($_GET['action'] == 'readPost') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idPost = $_GET['id'];
                $frontend = new Frontend();
                $frontend->getPost($idPost);
                return;
            }
            throw new \Exception('Aucun identifiant de billet envoyé');
            return;
        } elseif ($_GET['action'] == 'getUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idUser = $_GET['id'];
                $backend = new Backend();
                $backend->getUser($idUser);
                return;
            }
            throw new \Exception('Aucun identifiant d\'utilisateur envoyé');
            return;
        } elseif ($_GET['action'] == 'deleteUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idUser = $_GET['id'];
                $backend = new Backend();
                $backend->deleteUser($idUser);
                return;
            }
            throw new \Exception('Aucun identifiant d\'utilisateur envoyé');
            return;
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idComment = $_GET['id'];
                $backend = new Backend();
                $backend->addComment($idComment);
                return;
            }
            throw new \Exception('Aucun identifiant de commentaire envoyé');
            return;
        } elseif ($_GET['action'] == 'postsList') {
                $frontend = new Frontend();
                $frontend->getPosts();
                return;
        } elseif ($_GET['action'] == 'writePostView') {
                $backend = new Backend();
                $backend->writePostView();
                return;
        } elseif ($_GET['action'] == 'forgotPasswordView') {
                $frontend = new Frontend();
                $frontend->forgotPasswordView();
                return;
        } elseif ($_GET['action'] == 'forgotPassword') {
                $frontend = new Frontend();
                $frontend->forgotPassword();
                return;
        } elseif ($_GET['action'] == 'resetPasswordView') {
                $frontend = new Frontend();
                $frontend->resetPasswordView();
                return;
        } elseif ($_GET['action'] == 'resetPassword') {
                $frontend = new Frontend();
                $frontend->resetPassword();
                return;
        } elseif ($_GET['action'] == 'signUpView') {
                $frontend = new Frontend();
                $frontend->signUpView();
                return;
        } elseif ($_GET['action'] == 'signInView') {
                $frontend = new Frontend();
                $frontend->signInView();
                return;
        } elseif ($_GET['action'] == 'signOut') {
                $backend = new Backend();
                $backend->signOut();
                return;
        } elseif ($_GET['action'] == 'getPendingComments') {
                $backend = new Backend();
                $backend->getPendingComments();
                return;
        } elseif ($_GET['action'] == 'getUsersView') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idUser = $_GET['id'];
                $backend = new Backend();
                $backend->getUsers($idUser);
                return;
            }
            throw new \Exception('Aucun identifiant d\'utilisateur envoyé');
            return;
        } elseif ($_GET['action'] == 'awakeUser') {
            if (isset($_GET['email'])) {
                $email = nl2br(htmlspecialchars($_GET['email']));
                $backend = new Backend();
                $backend->awakeUser($email);
                return;
            }
            throw new \Exception('Aucun identifiant d\'utilisateur envoyé');
        } elseif ($_GET['action'] == 'validateUser') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idUser = $_GET['id'];
                $backend = new Backend();
                $backend->validateUser($idUser);
                return;
            }
            throw new \Exception('Aucun identifiant d\'utilisateur envoyé');
            return;
        } elseif ($_GET['action'] == 'validateComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $idComment = $_GET['id'];
                $backend = new Backend();
                $backend->validateComment($idComment);
                return;
            }
            throw new \Exception('Aucun identifiant de commentaire envoyé');
        } elseif ($_GET['action'] == 'signUp') {
            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {
                $frontend = new Frontend();
                $frontend->signUp();
                return;
            }
        } elseif ($_GET['action'] == 'signIn') {
            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {
                $frontend = new Frontend();
                $frontend->signIn();
                return;
            }
        } elseif ($_GET['action'] == 'getPendingUsersView') {
            $backend = new Backend();
            $backend->getPendingUsers();
            return;
        } elseif ($_GET['action'] == 'cvView') {
            $frontend = new Frontend();
            $frontend->cvView();
            return;
        } elseif ($_GET['action'] == 'homeView') {
            $frontend = new Frontend();
            $frontend->homeView();
            return;
        } elseif ($_GET['action'] == 'contactView') {
            $frontend = new Frontend();
            $frontend->contactView();
            return;
        } elseif ($_GET['action'] == 'postsListView') {
            $frontend = new Frontend();
            $frontend->getPosts();
            return;
        } elseif ($_GET['action'] == 'contact') {
            $frontend = new Frontend();
            $frontend->contact();
            return;
        }
    }
    $frontend = new Frontend();
    $frontend->homeView();
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();

    include 'view/errorView.php';
}
