<?php

/**
* Classe représentant la connexion à la bdd.
* @author Bastien Vacherand.
*/

class DBFactory
{

    /**
    * Methode qui permet d'intancier la connexion à la bdd en PDO.
    * @param void
    * @return object PDO
    */

    public static function getMysqlConnexionWithPDO()
    {

        $data = require __DIR__ . '/../config/connect.php';
        $db = new PDO('mysql:host=' . $data['host'] . ';dbname=' . $data['dbname'].
                      ';charset=utf8', $data['username'], $data['password']);

        //On émet une alerte à chaque fois qu'une requête a échoué.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $db;
    }

    /**
    * Methode qui permet d'intancier la connexion à la bdd en MySQLi.
    * @param void
    * @return object MySQLi
    */

    public static function getMysqlConnexionWithMySQLi()
    {

        return new MySQLi('localhost', 'root', '', 'blog');
    }
}
