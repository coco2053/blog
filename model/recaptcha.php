<?php

//Mise en place des parametres de recaptcha
$data = require __DIR__ . '/../config/recaptcha.php';

// Ma clé privée
$secret = $data['private_key'];

// Paramètre renvoyé par le recaptcha
$response = $_POST['g-recaptcha-response'];

// On récupère l'IP de l'utilisateur
$remoteip = $_SERVER['REMOTE_ADDR'];

$api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
    . $secret
    . "&response=" . $response
    . "&remoteip=" . $remoteip ;

$decode = json_decode(file_get_contents($api_url), true);
