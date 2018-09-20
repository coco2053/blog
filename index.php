<?php

$_SESSION['id_user'] = '1';
require('controller/frontend.php');
require('controller/backend.php');


try {

    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'addPost') {

        $formData = ['title' => htmlspecialchars($_POST['title']),
            'chapo' => htmlspecialchars($_POST['chapo']),
            'content' => htmlspecialchars($_POST['content']),
            'id_user' => htmlspecialchars($_SESSION['id_user'])];

        addPost($formData);

        } elseif ($_GET['action'] == 'readPost') {

            if (isset($_GET['id']) && $_GET['id'] > 0) {

                getPost($_GET['id']);

            } else {

                throw new Exception('Aucun identifiant de billet envoyé');
            }

        } elseif ($_GET['action'] == 'postsList') {

            getPosts();

        } elseif ($_GET['action'] == 'writePostView') {

            writePostView();
        }

    } else {

        getPosts();
    }
} catch (Exception $e) {

    $errorMessage = $e->getMessage();

    require('view/errorView.php');
}
