<?php

/**
* Classe représentant un commentaire.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

class Comment
{

    protected $idComment;
    protected $content;
    protected $creationDate;
    protected $username;
    protected $valid;
    protected $idPost;
    protected $idUser;

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

    public function idComment()
    {

        return $this->idComment;
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

    public function creationDate()
    {

        return $this->creationDate;
    }

    public function idUser()
    {

        return $this->idUser;
    }

    public function idPost()
    {

        return $this->idPost;
    }

    // SETTERS //

    public function setIdComment($idComment)
    {

        $idComment = (int) $idComment;

        if ($idComment > 0) {
            $this->idComment = $idComment;
        }
    }

    public function setIdUser($idUser)
    {

        $idUser = (int) $idUser;

        if ($idUser > 0) {
            $this->idUser = $idUser;
        }
    }

    public function setIdPost($idPost)
    {

        $idPost = (int) $idPost;

        if ($idPost > 0) {
            $this->idPost = $idPost;
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

    public function setCreationDate(\DateTime $creationDate)
    {

        $this->creationDate = $creationDate->format('d.m.Y');
    }
}
