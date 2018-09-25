<?php

$_SESSION['id_user'] = '1';
require('controller/Frontend.php');
require('controller/Backend.php');


try {

    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'addPostView') {

                $backend = New Backend();
                $backend->writePostView();




        } elseif ($_GET['action'] == 'addPost') {

               $formData = ['title' => htmlspecialchars($_POST['title']),
                            'chapo' => htmlspecialchars($_POST['chapo']),
                            'content' => htmlspecialchars($_POST['content']),
                            'id_user' => htmlspecialchars($_SESSION['id_user'])];

                $backend = New Backend();
                $backend->addPost($formData);


        } elseif ($_GET['action'] == 'readPost') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                $frontend = New Frontend();
                $frontend->getPost($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'postsList') {

                $frontend = New Frontend();
                $frontend->getPosts();

        } elseif ($_GET['action'] == 'writePostView') {

            writePostView();
        }

    } else {

        $frontend = New Frontend();
        $frontend->getPosts();
    }
} catch (Exception $e) {

    $errorMessage = $e->getMessage();

    require('view/errorView.php');
}
