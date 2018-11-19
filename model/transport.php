<?php

//Mise en place des parametres de swiftMailer.

$data = require __DIR__ . '/../config/mailer.php';

// Create the Transport
$transport = (new \Swift_SmtpTransport($data['smpt'], $data['port'], $data['mode']))
    ->setUsername($data['username'])
    ->setPassword($data['password'])
    ->setStreamOptions(array('ssl' => array(
                             'verify_peer' => false,
                             'verify_peer_name' => false,
                             'allow_self_signed' => true)));
