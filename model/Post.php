<?php
class Post
{

	private $_id_post,
			$_id_user,
			$_title,
			$_chapo,
			$_content,
			$_creation_date,
			$_update_date,
			$_username;


  public function __construct(array $formData)
  {
    $this->hydrate($formData);
  }

   public function hydrate(array $formData)
  {
    foreach ($formData as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }


  // GETTERS //  

  public function id_post()
  {
    return $this->_id_post;
  }

    public function id_user()
  {
    return $this->_id_user;
  }
  
  
  public function title()
  {
    return $this->_title;
  }
  
  public function chapo()
  {
    return $this->_chapo;
  }

  public function content()
  {
    return $this->_content;
  }
  
  public function creation_date()
  {
    return $this->_creation_date;
  }
  
  public function update_date()
  {
    return $this->_update_date;
  }

  public function username()
  {
    return $this->_username;
  }


  // SETTERS //  
  public function setId_post($id_post)
  {
    $id_post = (int) $id_post;
    
    if ($id_post > 0)
    {
      $this->_id_post = $id_post;
    }
  }

    public function setId_user($id_user)
  {
    $id_user = (int) $id_user;
    
    if ($id_user > 0)
    {
      $this->_id_user = $id_user;
    }
  }
  
  public function setTitle($title)
  {
    if (is_string($title))
    {
      $this->_title = $title;
    }
  }
  
  public function setChapo($chapo)
  {
    if (is_string($chapo))
    {
      $this->_chapo = $chapo;
    }
  }

  public function setContent($content)
  {
    if (is_string($content))
    {
      $this->_content = $content;
    }
  }

  public function setCreation_date($creation_date)
  {
    if (is_string($creation_date))
    {
      $this->_creation_date = $creation_date;
    }
  }

  public function setUpdate_date($update_date)
  {
    if (is_string($update_date))
    {
      $this->_update_date = $update_date;
    }
  }

  public function setUsername($username)
  {
    if (is_string($username))
    {
      $this->_username = $username;
    }
  }  

}