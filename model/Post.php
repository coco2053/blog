<?php

/**
* Classe représentant un post.
* @author Bastien Vacherand.
*/

class Post
{

    protected $id_post,
              $id_user,
              $title,
              $chapo,
              $content,
              $image,
              $creation_date,
              $update_date,
              $username;

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

    public function id_post()
    {

        return $this->id_post;
    }

    public function id_user()
    {

        return $this->id_user;
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

    public function creation_date()
    {

        return $this->creation_date;
    }

    public function update_date()
    {

        return $this->update_date;
    }

    public function username()
    {

        return $this->username;
    }

    // SETTERS //

    public function setId_post($id_post)
    {

        $id_post = (int) $id_post;

        if ($id_post > 0) {

            $this->id_post = $id_post;
        }
    }

    public function setId_user($id_user)
    {

        $id_user = (int) $id_user;

        if ($id_user > 0) {

            $this->id_user = $id_user;
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

    public function setCreation_date(DateTime $creation_date)
    {

        $this->creation_date = $creation_date->format('d.m.Y à H:i');
    }

    public function setUpdate_date(DateTime $update_date)
    {

        $this->update_date = $update_date->format('d.m.Y à H:i');

    }

    public function setUsername($username)
    {
        if (is_string($username)) {

            $this->username = $username;
        }
    }

}
