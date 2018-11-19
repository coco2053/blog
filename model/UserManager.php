<?php

/**
* Classe abstraite representant le manager des utilisateurs.
* @author Bastien Vacherand.
*/

namespace Bastien\model;

abstract class UserManager
{

    /**
    * Méthode permettant d'ajouter un user.
    * @param object User Le user à ajouter
    * @return void
    */

    abstract public function add(User $user);

    /**
    * Méthode permettant de supprimer un user.
    * @param int L'identifiant du user à supprimer
    * @return void
    */

    abstract public function delete($idUser);

    /**
    * Méthode retournant une liste des users demandés.
    * @return array La liste des user. Chaque entrée est une instance de User.
    */

    abstract public function getList($idUser);

    /**
    * Méthode retournant un user précis.
    * @param int L'identifiant du user à récupérer
    * @return User Le user demandé
    */

    abstract public function get($idUser);

    /**
    * Méthode retournant une liste de user non valides.
    * @return array La liste des user non valides.
    */

    abstract public function getPendingList();

    /**
    * Méthode vérifiant si un user est valide.
    * @param int L'identifiant du user à vérifier
    * @return bool
    */

    abstract public function isValid($idUser);

    /**
    * Méthode permettant de valider un user.
    * @param int L'identifiant du user
    * @return void
    */

    abstract public function validate($idUser);

    /**
    * Méthode permettant d'activer un compte nouvelement crée.
    * @param string Le mail du compte à activer.
    * @return void
    */

    abstract public function awake($email);

    /**
    * Méthode permettant de vérifier login et mot de passe.
    * @param array Le mail et password à vérifier
    * @return bool
    */

    abstract public function checkPassword($formData);

    /**
    * Méthode permettant de vérifier si un user existe déja.
    * @param string Le mail du user à vérifier
    * @return bool
    */

    abstract public function exists($info);

    /**
    * Méthode permettant de mettre à jour la date de connexion.
    * @param int l'id du user.
    * @return void
    */

    abstract public function updateSigninDate($idUser);

    /**
    * Méthode permettant de mettre à jour le mot de passe.
    * @param array email et mot de passe de l'utilisateur
    * @return void
    */

    abstract public function updatePassword($formData);
}
