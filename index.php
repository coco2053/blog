<?php

include 'controller/Frontend.php';
include 'controller/Backend.php';
include  'model/autoload.php';

session_start();

try {

    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'addPostView') {

            $backend = New Backend();
            $backend->writePostView();

        } elseif ($_GET['action'] == 'addPost') {

            $backend = New Backend();

           $formData = ['title' => nl2br(htmlspecialchars($_POST['title'])),
                        'chapo' => nl2br(htmlspecialchars($_POST['chapo'])),
                        'content' => nl2br(htmlspecialchars($_POST['content'])),
                        'id_user' => nl2br(htmlspecialchars($_SESSION['user'] -> id_user())),
                        'image' => $backend->checkFile($_FILES)];

            $backend->addPost($formData);

        } elseif ($_GET['action'] == 'editPostView') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->editPostView($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'deleteComment') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->deleteComment($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'editPost') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $formData = ['id_post' => nl2br(htmlspecialchars($_GET['id'])),
                            'title' => nl2br(htmlspecialchars($_POST['title'])),
                            'chapo' => nl2br(htmlspecialchars($_POST['chapo'])),
                            'content' => nl2br(htmlspecialchars($_POST['content'])),
                            'id_user' => '1'];

                $backend = New Backend();
                $backend->editPost($formData);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'deletePost') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->deletePost($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'readPost') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $frontend = New Frontend();
                $frontend->getPost($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'getUser') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->getUser($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'deleteUser') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->deleteUser($_GET['id']);


            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'addComment') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->addComment($_GET['id']);


            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'postsList') {

                $frontend = New Frontend();
                $frontend->getPosts();

        } elseif ($_GET['action'] == 'writePostView') {

                $backend = New Backend();
                $backend->writePostView();

        } elseif ($_GET['action'] == 'forgotPasswordView') {

        $frontend = New Frontend();
        $frontend->forgotPasswordView();

        } elseif ($_GET['action'] == 'forgotPassword') {

        $frontend = New Frontend();
        $frontend->forgotPassword();

        } elseif ($_GET['action'] == 'resetPasswordView') {

        $frontend = New Frontend();
        $frontend->resetPasswordView();

       } elseif ($_GET['action'] == 'resetPassword') {

        $frontend = New Frontend();
        $frontend->resetPassword();


        } elseif ($_GET['action'] == 'signUpView') {

        $frontend = New Frontend();
        $frontend->signUpView();

        } elseif ($_GET['action'] == 'signInView') {

        $frontend = New Frontend();
        $frontend->signInView();

        } elseif ($_GET['action'] == 'signOut') {

        $backend = New Backend();
        $backend->signOut();

        } elseif ($_GET['action'] == 'getPendingComments') {

        $backend = New Backend();
        $backend->getPendingComments();

        } elseif ($_GET['action'] == 'getUsersView') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->getUsers($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'awakeUser') {

            if (isset($_GET['email'])) {

                $backend = New Backend();
                $backend->awakeUser($_GET['email']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'validateUser') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->validateUser($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'validateComment') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $backend = New Backend();
                $backend->validateComment($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'signUp') {

            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {

                $frontend = New Frontend();
                $frontend->signUp();
            }

        } elseif ($_GET['action'] == 'signIn') {

            // On check que le formulaire a été envoyé
            if (isset($_POST['email'])) {

                $frontend = New Frontend();
                $frontend->signIn();
            }

        } elseif ($_GET['action'] == 'getPendingUsersView') {

                $backend = New Backend();
                $backend->getPendingUsers();

        } elseif ($_GET['action'] == 'cvView') {

                $frontend = New Frontend();
                $frontend->cvView();

        } elseif ($_GET['action'] == 'homeView') {

                $frontend = New Frontend();
                $frontend->homeView();

        } elseif ($_GET['action'] == 'contactView') {

                $frontend = New Frontend();
                $frontend->contactView();

        } elseif ($_GET['action'] == 'postsListView') {

            $frontend = New Frontend();
            $frontend->getPosts();

        } elseif ($_GET['action'] == 'contact') {

            $frontend = New Frontend();
            $frontend->contact();
        }

    } else {

        $frontend = New Frontend();
        $frontend->homeView();
    }

} catch (Exception $e) {

    $errorMessage = $e->getMessage();

    include 'view/errorView.php';
}

