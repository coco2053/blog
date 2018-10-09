<?php

class UserManagerPDO extends UserManager
{
    protected $db; // Instance de PDO

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function add(User $user)
    {

        // Préparation de la requête d'insertion.
        $q = $this->db->prepare('INSERT INTO user(email, password, username, lastname, firstname, valid, signup_date, signin_date, id_role)
                                  VALUES (:email, :password, :username, :lastname, :firstname, :valid,  NOW(), NOW(), :id_role)');

        // Assignation des valeurs du user.
        $q->bindValue(':email', $user->email());
        $q->bindValue(':password', $user->password());
        $q->bindValue(':username', $user->username());
        $q->bindValue(':lastname', $user->lastname());
        $q->bindValue(':firstname', $user->firstname());
        $q->bindValue(':valid', $user->valid());
        $q->bindValue(':id_role', $user->id_role());

        // Exécution de la requête.
        $q->execute();

        // Hydratation du user passé en paramètre avec assignation de son identifiant.
        $user->hydrate(['id_user' => $this->db->lastInsertId()]);

    }

    public function delete($id_user)
    {

      // Exécute une requête de type DELETE.
      $this->db->exec('DELETE
                       FROM user
                       WHERE id_user = '.(int) $id_user);

    }


    public function getList()
    {

        $sql = 'SELECT
                    user.id_user,
                    user.email,
                    user.username,
                    user.lastname,
                    user.firstname,
                    user.valid,
                    user.signin_date AS signin_date,
                    user.signup_date AS signup_date,
                    user.username
                    FROM user
                    ORDER BY user.signin_date';


        $q = $this->db->query($sql);
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $users = $q->fetchAll();

        // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout et de modification.

        foreach ($users as $user) {

            $user->setSignin_date(new DateTime($user->signin_date()));
            $user->setSignup_date(new DateTime($user->signup_date()));

        }

        $q->closeCursor();

        return $users;
    }

    public function get($id_user)
    {


        $q = $this->db->prepare('SELECT
                                user.id_user, user.email, user.username, user.lastname, user.firstname, user.valid,
                                user.signin_date AS signin_date,
                                user.signup_date AS signup_date,
                                user.username
                                FROM user
                                WHERE id_user = :id_user');

        $q->bindValue(':id_user', (int) $id_user, PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        $user = $q->fetch();

        $user->setSignin_date(new DateTime($user->signin_date()));
        $user->setSignup_date(new DateTime($user->signup_date()));

        return $user;


    }

    public function getPending()
    {

        $users = [];
        $q = $this->db->query('SELECT
                                user.id_user,
                                user.email,
                                user.username,
                                user.lastname,
                                user.firstname,
                                user.valid,
                                DATE_FORMAT(user.signin_date, \'%d/%m/%Y à %Hh%imin%ss\') AS signin_date,
                                DATE_FORMAT(user.signup_date, \'%d/%m/%Y à %Hh%imin%ss\') AS signup_date,
                                FROM user
                                WHERE user.valid = No
                                ORDER BY user.signin_date');

        // Le résultat sera un tableau d'instances de User.
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }

        return $users;
    }

    public function isValid($id_user)
    {

        // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
        $q = $this->db->prepare('SELECT id_user, valid
                                 FROM user
                                 WHERE id_user = :id_user');
        $q->execute([':id_user' => $id_user]);
        /* je voudrais retourner un boolean qui verifie si valid = Yes
        return $q->fetchColumn();*/
    }


    public function validate(User $user)
    {

        // Prépare une requête de type UPDATE.
        $q = $this->db->prepare('UPDATE user
                                  SET
                                  valid = :valid
                                  WHERE
                                  id_user = :id_user');

        // Assignation des valeurs à la requête.
        $q->bindValue(':valid', 'Yes', PDO::PARAM_STR);
        $q->bindValue(':id_user', $user->id_user(), PDO::PARAM_INT);


        // Exécution de la requête.
        $q->execute();
    }

     public function checkPassword($formData)

    {
        $q = $this->db->prepare('SELECT email, password, id_user
                              FROM user
                              WHERE email = :email');

        $q->execute([':email' => $formData['email']]);

        $result = $q->fetch();
        $id = $result['id_user'];

        // Comparaison du pass envoyé via le formulaire avec celui de la base
        if (password_verify($formData['password'], $result['password'])) {

            return $id;
        } else {
            return NULL;
        }

    }

     public function updateSignupDate($id_user)
     {
        $q = $this->db->prepare('UPDATE user
                                 SET
                                 signup_date = NOW()
                                 WHERE
                                 id_user = :id_user');

        // Assignation des valeurs à la requête.
        $q->bindValue(':id_user', $id_user, PDO::PARAM_INT);

         // Exécution de la requête.
        $q->execute();
    }

     public function updatePassword($formData)
     {
        $q = $this->db->prepare('UPDATE user
                                 SET
                                 password = :password
                                 WHERE
                                 email = :email');

        // Assignation des valeurs à la requête.
        $q->bindValue(':password', $formData['password'], PDO::PARAM_STR);
        $q->bindValue(':email', $formData['email'], PDO::PARAM_STR);

         // Exécution de la requête.
        $q->execute();
    }

    public function exists($info)
    {

        // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
        $q = $this->db->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
        $q->execute([':email' => $info]);

        return (bool) $q->fetchColumn();
    }

}
