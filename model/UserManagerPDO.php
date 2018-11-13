<?php

/**
* Classe representant le manager des utilisateurs en PDO.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

class UserManagerPDO extends UserManager
{

    protected $database; // Instance de PDO

    /**
    * Constructeur de la classe qui permet d'instancier la Bdd.
    * @param object PDO
    * @return void
    */

    public function __construct(\PDO $database)
    {

        $this->database = $database;
    }

    /**
    * Méthode permettant d'ajouter un user.
    * @param object User Le user à ajouter
    * @return void
    */

    public function add(User $user)
    {

        // Préparation de la requête d'insertion.
        $req = $this->database->prepare('INSERT INTO user(email, password, username, lastname,
                                             firstname, asleep, valid, signupDate, signinDate, idRole)

                                 VALUES (:email, :password, :username, :lastname, :firstname,
                                         :asleep, :valid,  NOW(), NOW(), :idRole)');

        // Assignation des valeurs du user.
        $req->bindValue(':email', $user->email());
        $req->bindValue(':password', $user->password());
        $req->bindValue(':username', $user->username());
        $req->bindValue(':lastname', $user->lastname());
        $req->bindValue(':firstname', $user->firstname());
        $req->bindValue(':asleep', $user->asleep());
        $req->bindValue(':valid', $user->valid());
        $req->bindValue(':idRole', $user->idRole());

        // Exécution de la requête.
        $req->execute();

        // Hydratation du user passé en paramètre avec assignation de son identifiant.
        $user->hydrate(['idUser' => $this->database->lastInsertId()]);
    }

    /**
    * Méthode permettant de supprimer un user.
    * @param int L'identifiant du user à supprimer
    * @return void
    */

    public function delete($idUser)
    {

        // Exécute une requête de type DELETE.
        $this->database->exec('DELETE
                         FROM user
                         WHERE idUser = '.(int) $idUser);
    }

    /**
    * Méthode retournant une liste des users demandés.
    * @return array La liste des user. Chaque entrée est une instance de User.
    */

    public function getList($idUser)
    {

        $req = $this->database->prepare('SELECT
                                user.idUser,
                                user.email,
                                user.username,
                                user.lastname,
                                user.firstname,
                                user.valid,
                                user.signinDate AS signinDate,
                                user.signupDate AS signupDate,
                                user.username
                                FROM user
                                WHERE user.idUser != :idUser
                                ORDER BY user.signupDate');

        $req->bindValue(':idUser', (int) $idUser, \PDO::PARAM_INT);

        $req->execute();
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\blog\\model\\User');
        $users = $req->fetchAll();

        /* On parcourt notre liste de news pour pouvoir placer des instances
        de DateTime en guise de dates d'ajout et de modification. */

        foreach ($users as $user) {
            $user->setSigninDate(new \DateTime($user->signinDate()));
            $user->setSignupDate(new \DateTime($user->signupDate()));
        }

        $req->closeCursor();

        return $users;
    }

    /**
    * Méthode retournant une liste de user non valides.
    * @return array La liste des user non valides.
    */

    public function getPendingList()
    {

        $req = $this->database->prepare('SELECT
                                        user.idUser,
                                        user.email,
                                        user.username,
                                        user.lastname,
                                        user.firstname,
                                        user.valid,
                                        user.signinDate AS signinDate,
                                        user.signupDate AS signupDate,
                                        user.username
                                        FROM user
                                        WHERE user.valid = \'No\'
                                        ORDER BY user.signupDate');

        $req->execute();
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\blog\\model\\User');
        $users = $req->fetchAll();

        /* On parcourt notre liste de news pour pouvoir placer des instances
        de DateTime en guise de dates d'ajout et de modification. */

        foreach ($users as $user) {
            $user->setSigninDate(new \DateTime($user->signinDate()));
            $user->setSignupDate(new \DateTime($user->signupDate()));
        }

        $req->closeCursor();

        return $users;
    }

    /**
    * Méthode retournant un user précis.
    * @param int L'identifiant du user à récupérer
    * @return User Le user demandé
    */

    public function get($idUser)
    {

        $req = $this->database->prepare('SELECT
                                user.idUser, user.email, user.username, user.lastname,
                                user.firstname, user.valid, role.name AS roleName, permission.actionList AS permAction,
                                user.signinDate AS signinDate,
                                user.signupDate AS signupDate,
                                user.username
                                FROM user
                                LEFT JOIN role ON user.idRole = role.idRole
                                LEFT JOIN permission ON role.idPermission = permission.idPermission
                                WHERE idUser = :idUser');

        $req->bindValue(':idUser', (int) $idUser, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\blog\\model\\User');

        $user = $req->fetch();

        $user->setSigninDate(new \DateTime($user->signinDate()));
        $user->setSignupDate(new \DateTime($user->signupDate()));

        return $user;
    }

    /**
    * Méthode permettant de valider un user.
    * @param int L'identifiant du user
    * @return void
    */

    public function isValid($email)
    {

        // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
        $req = $this->database->prepare('SELECT email, valid
                                 FROM user
                                 WHERE email = :email
                                 AND valid = \'Yes\' ');

        $req->execute([':email' => $email]);

        return (bool) $req->fetchColumn();
    }

    /**
    * Méthode permettant de vérifier login et mot de passe.
    * @param array Le mail et password à vérifier
    * @return bool
    */

    public function validate($idUser)
    {

        // Prépare une requête de type UPDATE.
        $req = $this->database->prepare('UPDATE user
                                  SET
                                  valid = :valid
                                  WHERE
                                  idUser = :idUser');

        // Assignation des valeurs à la requête.
        $req->bindValue(':valid', 'Yes', \PDO::PARAM_STR);
        $req->bindValue(':idUser', $idUser, \PDO::PARAM_INT);


        // Exécution de la requête.
        $req->execute();
    }

    /**
    * Méthode permettant d'activer un compte nouvelement crée.
    * @param string Le mail du compte à activer.
    * @return void
    */

    public function awake($email)
    {

        // Prépare une requête de type UPDATE.
        $req = $this->database->prepare('UPDATE user
                                  SET
                                  asleep = \'Yes\'
                                  WHERE
                                  email = :email');

        // Assignation des valeurs à la requête.
        $req->bindValue(':email', $email, \PDO::PARAM_STR);


        // Exécution de la requête.
        $req->execute();
    }

    /**
    * Méthode permettant de vérifier login et mot de passe.
    * @param array Le mail et password à vérifier
    * @return bool
    */

    public function checkPassword($formData)
    {

        $req = $this->database->prepare('SELECT email, password, idUser
                                 FROM user
                                 WHERE email = :email');

        $req->execute([':email' => $formData['email']]);

        $result = $req->fetch();
        $idUser = $result['idUser'];

        // Comparaison du pass envoyé via le formulaire avec celui de la base
        if (password_verify($formData['password'], $result['password'])) {
            return $idUser;
        } else {
            return null;
        }
    }

    /**
    * Méthode permettant de mettre à jour la date de connexion.
    * @param int l'id du user.
    * @return void
    */

    public function updateSigninDate($idUser)
    {

        $req = $this->database->prepare('UPDATE user
                                 SET
                                 signinDate = NOW()
                                 WHERE
                                 idUser = :idUser');

        // Assignation des valeurs à la requête.
        $req->bindValue(':idUser', $idUser, \PDO::PARAM_INT);

         // Exécution de la requête.
        $req->execute();
    }

    /**
    * Méthode permettant de mettre à jour le mot de passe.
    * @param array email et mot de passe de l'utilisateur
    * @return void
    */

    public function updatePassword($formData)
    {

        $req = $this->database->prepare('UPDATE user
                                 SET
                                 password = :password
                                 WHERE
                                 email = :email');

        // Assignation des valeurs à la requête.
        $req->bindValue(':password', $formData['password'], \PDO::PARAM_STR);
        $req->bindValue(':email', $formData['email'], \PDO::PARAM_STR);

         // Exécution de la requête.
        $req->execute();
    }

    /**
    * Méthode permettant de vérifier si un user existe déja.
    * @param string Le mail du user à vérifier
    * @return bool
    */

    public function exists($info)
    {

        // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
        $req = $this->database->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
        $req->execute([':email' => $info]);

        return (bool) $req->fetchColumn();
    }
}
