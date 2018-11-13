<?php

/**
* Classe représentant un post.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

class Post
{

    protected $idPost;
    protected $idUser;
    protected $title;
    protected $chapo;
    protected $content;
    protected $image;
    protected $creationDate;
    protected $updateDate;
    protected $username;

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

    public function idPost()
    {

        return $this->idPost;
    }

    public function idUser()
    {

        return $this->idUser;
    }

    public function title()
    {

        return $this->title;
    }

    public function chapo()
    {

        return $this->chapo;
    }

    public function content()
    {

        return $this->content;
    }

    public function image()
    {

        return $this->image;
    }

    public function creationDate()
    {

        return $this->creationDate;
    }

    public function updateDate()
    {

        return $this->updateDate;
    }

    public function username()
    {

        return $this->username;
    }

    // SETTERS //

    public function setIdPost($idPost)
    {

        $idPost = (int) $idPost;

        if ($idPost > 0) {
            $this->idPost = $idPost;
        }
    }

    public function setIdUser($idUser)
    {

        $idUser = (int) $idUser;

        if ($idUser > 0) {
            $this->idUser = $idUser;
        }
    }

    public function setTitle($title)
    {

        if (is_string($title)) {
            $this->title = $title;
        }
    }

    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->chapo = $chapo;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setImage($image)
    {
        if (is_string($image)) {
            $this->image = $image;
        }
    }

    public function setCreationDate(\DateTime $creationDate)
    {

        $this->creationDate = $creationDate->format('d.m.Y à H:i');
    }

    public function setUpdateDate(\DateTime $updateDate)
    {

        $this->updateDate = $updateDate->format('d.m.Y à H:i');
    }

    public function setUsername($username)
    {
        if (is_string($username)) {
            $this->username = $username;
        }
    }
}
