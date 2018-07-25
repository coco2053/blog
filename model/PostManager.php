<?php
class PostManager
{
  private $_db; // Instance de PDO
  
  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function add(Post $post)
  {

    // Préparation de la requête d'insertion.
    $q = $this->_db->prepare('INSERT INTO post(title, chapo, content, creation_date, update_date, id_user) VALUES(:title, :chapo, :content, NOW(), NOW(), :id_user)');

     // Assignation des valeurs du post.

    $q->bindValue(':title', $post->title());
    $q->bindValue(':chapo', $post->chapo());
    $q->bindValue(':content', $post->content());
    $q->bindValue(':id_user', $post->id_user());

    // Exécution de la requête.
    $q->execute();

    // Hydratation du post passé en paramètre avec assignation de son identifiant.    
    $post->hydrate(['id' => $this->_db->lastInsertId()]);
  }

  public function delete(Post $post)
  {
    // Exécute une requête de type DELETE.
    $this->_db->exec('DELETE FROM post WHERE id_post = '.$post->id());
  }

  public function update(Post $post)
  {

    // Prépare une requête de type UPDATE.
    $q = $this->_db->prepare('UPDATE post SET title = :title,  chapo = :chapo, content = :content, update_date = NOW (), id_user = :id_user, WHERE id_post = :id_post');

    // Assignation des valeurs à la requête.    
    $q->bindValue(':title', $post->title(), PDO::PARAM_INT);
    $q->bindValue(':chapo', $post->chapo(), PDO::PARAM_INT);
    $q->bindValue(':content', $post->content(), PDO::PARAM_INT);
    $q->bindValue(':id_user', $post->id_user(), PDO::PARAM_INT);

    // Exécution de la requête.
    $q->execute();
  }
  

  public function getList()
  {

    
    $posts = [];
    
    $q = $this->_db->query('SELECT post.id_post, post.title, post.chapo, post.content, DATE_FORMAT(post.creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date ,  DATE_FORMAT(post.update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date, user.username 
    						  FROM post
    						  INNER JOIN user
    						  ON post.id_user = user.id_user 
    						  ORDER BY post.creation_date');
    

    // Le résultat sera un tableau d'instances de Post.    
    while ($data = $q->fetch(PDO::FETCH_ASSOC))
    {
      $posts[] = new Post($data);
    }
    
    return $posts;
}

  public function get($caca)
  {

  $q = $this->_db->query('SELECT post.title, post.chapo, post.content, DATE_FORMAT(post.creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date ,  DATE_FORMAT(post.update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date, user.username 
						  FROM post
						  INNER JOIN user
						  ON post.id_user = user.id_user 
						  WHERE id_post = '.$caca);

  $data = $q->fetch(PDO::FETCH_ASSOC);
  
  return new Post($data);
  
}

  public function exists($info)
  {
  	// Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
    $q = $this->_db->prepare('SELECT COUNT(*) FROM post WHERE title = :title');

    
    $q->execute([':title' => $info]);
    
    return (bool) $q->fetchColumn();
  }
  

	
  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }

}
