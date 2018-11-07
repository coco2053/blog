<?php

/**
* Classe représentant un commentaire.
* @author Bastien Vacherand.
*/

class Comment
{

    protected $id_comment,
              $content,
              $creation_date,
              $username,
              $valid,
              $id_post,
              $id_user;

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

    public function id_comment()
    {

        return $this->id_comment;
    }

    public function content()
    {

        return $this->content;
    }

    public function username()
    {

        return $this->username;
    }

    public function valid()
    {

        return $this->valid;
    }

    public function creation_date()
    {

        return $this->creation_date;
    }

    public function id_user()
    {

        return $this->id_user;
    }

    public function id_post()
    {

        return $this->id_post;
    }

    // SETTERS //

    public function setId_comment($id_comment)
    {

        $id_comment = (int) $id_comment;

        if ($id_comment > 0) {

            $this->id_comment = $id_comment;
        }
    }

    public function setId_user($id_user)
    {

        $id_user = (int) $id_user;

        if ($id_user > 0) {

          $this->id_user = $id_user;
        }
    }

    public function setId_post($id_post)
    {

        $id_post = (int) $id_post;

        if ($id_post > 0) {

          $this->id_post = $id_post;
        }
    }


    public function setContent($content)
    {

        if (is_string($content)) {

            $this->content = $content;
        }
    }

    public function setUsername($username)
    {

        if (is_string($username)) {

            $this->username = $username;
        }
    }


    public function setValid($valid)
    {

        if (is_string($valid)) {

            $this->valid = $valid;
        }
    }

    public function setCreation_date(DateTime $creation_date)
    {

        $this->creation_date = $creation_date->format('d.m.Y');
    }

}
