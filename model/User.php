<?php

/**
* Classe représentant un utilisateur.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

class User
{

    protected $idUser;
    protected $idRole;
    protected $email;
    protected $password;
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $asleep;
    protected $valid;
    protected $signinDate;
    protected $roleName;
    protected $permAction;
    protected $signupDate;

    /**
    * Constructeur de la classe qui permet d'hydrater l'objet à l'instanciation.
    * @param array, du formulaire
    * @return void
    */


    public function __construct($formData = [])
    {

        if (!empty($formData)) {
            $this->hydrate($formData);
        }
    }

    /**
    * Methode qui permet d'hydrater l'objet.
    * @param array, du formulaire
    * @return void
    */

    public function hydrate(array $formData)
    {

        foreach ($formData as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // GETTERS //

    public function idUser()
    {

        return $this->idUser;
    }

    public function idRole()
    {

        return $this->idRole;
    }

    public function email()
    {

        return $this->email;
    }

    public function password()
    {

        return $this->password;
    }

    public function firstname()
    {

        return $this->firstname;
    }

    public function lastname()
    {

        return $this->lastname;
    }

    public function signinDate()
    {

        return $this->signinDate;
    }

    public function signupDate()
    {

        return $this->signupDate;
    }

    public function username()
    {

        return $this->username;
    }

    public function asleep()
    {

        return $this->asleep;
    }

    public function valid()
    {

        return $this->valid;
    }

    public function roleName()
    {

        return $this->roleName;
    }

    public function permAction()
    {

        return $this->permAction;
    }

    // SETTERS //

    public function setIdUser($idUser)
    {

        $idUser = (int) $idUser;

        if ($idUser > 0) {
            $this->idUser = $idUser;
        }
    }

    public function setIdRole($idRole)
    {

        $idRole = (int) $idRole;

        if ($idRole > 0) {
            $this->idRole = $idRole;
        }
    }

    public function setEmail($email)
    {

        if (is_string($email)) {
            $this->email = $email;
        }
    }

    public function setPassword($password)
    {

        if (is_string($password)) {
            $this->password = $password;
        }
    }

    public function setFirstname($firstname)
    {

        if (is_string($firstname)) {
            $this->firstname = $firstname;
        }
    }

    public function setLastname($lastname)
    {

        if (is_string($lastname)) {
            $this->lastname = $lastname;
        }
    }

    public function setSigninDate(\DateTime $signinDate)
    {

        $this->signinDate = $signinDate->format('d.m.Y');
    }

    public function setSignupDate(\DateTime $signupDate)
    {

        $this->signupDate = $signupDate->format('d.m.Y');
    }

    public function setUsername($username)
    {

        if (is_string($username)) {
            $this->username = $username;
        }
    }

    public function setAsleep($asleep)
    {

        if (is_string($asleep)) {
            $this->asleep = $asleep;
        }
    }

    public function setValid($valid)
    {

        if (is_string($valid)) {
            $this->valid = $valid;
        }
    }

    public function setRoleName($roleName)
    {

        if (is_string($roleName)) {
            $this->roleName = $roleName;
        }
    }

    public function setPermAction($permAction)
    {

        if (is_string($permAction)) {
            $this->permAction = $permAction;
        }
    }
}
