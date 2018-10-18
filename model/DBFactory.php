<?php
class DBFactory
{
  public static function getMysqlConnexionWithPDO()
  {
    $data = require __DIR__ . '/../config/connect.php';
    $db = new PDO('mysql:host=' . $data['host'] . ';dbname=' . $data['dbname'] . ';charset=utf8', $data['username'], $data['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //On émet une alerte à chaque fois qu'une requête a échoué.

    return $db;
  }

  public static function getMysqlConnexionWithMySQLi()
  {
    return new MySQLi('localhost', 'root', '', 'blog');
  }
}
