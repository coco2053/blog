<?php

abstract class UserManager
{
  /**
   * Méthode permettant d'ajouter un user.
   * @param $user User Le user à ajouter
   * @return void
   */

    abstract public function add(User $user);

  /**
   * Méthode permettant de supprimer un user.
   * @param $id int L'identifiant du user à supprimer
   * @return void
   */

    abstract public function delete($id_user);

  /**
   * Méthode retournant une liste de users demandés.
   * @return array La liste des user. Chaque entrée est une instance de User.
   */
    abstract public function getList($id_user);

  /**
   * Méthode retournant un user précis.
   * @param $id int L'identifiant du user à récupérer
   * @return User Le user demandé
   */

    abstract public function get($id_user);

  /**
   * Méthode retournant une liste de user non valides.
    * @return array La liste des user non valides.
   */

    abstract public function getPendingList($id_user);

  /**
   * Méthode vérifiant si un user est valide.
   * @param $id int L'identifiant du user à vérifier
   * @return bool
   */

    abstract public function isValid($id_user);

  /**
   * Méthode permettant de valider un user.
   * @param $id_user
   * @return void
   */

    abstract public function validate($id_user);

  /**
   * Méthode permettant de vérifier si un user existe déja.
   * @param $formData array Le mail et password à vérifier
   * @return bool
   */
    abstract public function checkPassword($formData);

  /**
   * Méthode permettant de vérifier si un user existe déja.
   * @param $info string Le mail du user à vérifier
   * @return bool
   */

    abstract public function exists($info);

  /**
   * Méthode permettant de mettre à jour la date de connexion.
   * @param $id_user
   * @return void
   */

    abstract public function updateSigninDate($id_user);

  /**
   * Méthode permettant de mettre à jour le mot de passe.
   * @param $formData email et mot de passe de l'utilisateur
   * @return void
   */

    abstract public function updatePassword($formData);

}
