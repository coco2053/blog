<?php
class User
{

    protected $id_user,
              $id_role,
              $email,
              $password,
              $username,
              $firstname,
              $lastname,
              $signin_date,
              $signup_date;


    public function __construct(array $formData)
    {

        $this->hydrate($formData);

    }

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

    public function id_user()
    {
        return $this->id_user;
    }

    public function id_role()
    {
        return $this->id_role;
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

    public function signin_date()
    {
        return $this->signin_date;
    }

    public function signup_date()
    {
        return $this->signup_date;
    }

    public function username()
    {
        return $this->username;
    }

    // SETTERS //
    public function setId_user($id_user)
    {
        $id_usert = (int) $id_user;

        if ($id_user > 0) {

            $this->id_user = $id_user;
        }
    }

    public function setId_role($id_user)
    {
        $id_role = (int) $id_role;

        if ($id_role > 0) {

          $this->id_role = $id_role;
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

    public function setSignin_date($signin_date)
    {
        if (is_string($signin_date)) {

            $this->signin_date = $signin_date;
        }
    }

    public function setSignup_date($signin_date)
    {
        if (is_string($signup_date)) {

            $this->signup_date = $signup_date;
        }
    }

    public function setUsername($username)
    {
        if (is_string($username)) {

            $this->username = $username;
        }
    }

}
