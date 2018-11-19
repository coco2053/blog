<?php

/**
* Classe abstraite representant le manager des posts en PDO.
* @author Bastien Vacherand.
*/

namespace Bastien\model;

class PostManagerPDO extends PostManager
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
    * Méthode permettant d'ajouter un post.
    * @param object Post Le post à ajouter
    * @return void
    */

    public function add(Post $post)
    {

        // Préparation de la requête d'insertion.
        $req = $this->database->prepare('INSERT INTO post(title, chapo, content, image, creationDate, updateDate, idUser)
                                  VALUES (:title, :chapo, :content, :image, NOW(), NOW(), :idUser)');

        // Assignation des valeurs du post.
        $req->bindValue(':title', $post->title());
        $req->bindValue(':chapo', $post->chapo());
        $req->bindValue(':content', $post->content());
        $req->bindValue(':image', $post->image());
        $req->bindValue(':idUser', $post->idUser());

        // Exécution de la requête.
        $req->execute();

        // Hydratation du post passé en paramètre avec assignation de son identifiant.
        $post->hydrate(['idPost' => $this->database->lastInsertId()]);
    }

    /**
    * Méthode permettant de supprimer un post.
    * @param int L'identifiant du post à supprimer
    * @return void
    */

    public function delete($idPost)
    {

        $req = $this->database->prepare('SELECT
                        post.idPost, post.image
                        FROM post
                        WHERE idPost = :idPost');

        $req->bindValue(':idPost', (int) $idPost, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\model\\Post');

        $post = $req->fetch();

        if ($post->image() != 'no-image.jpg') {
            unlink('public/upload/'.$post->image());
        }

        // Exécute une requête de type DELETE.
        $this->database->exec('DELETE FROM post WHERE idPost = '.(int) $idPost);
        $this->database->exec('DELETE FROM comment WHERE idPost = '.(int) $idPost);
    }

    /**
    * Méthode permettant de modifier un post.
    * @param object Post le post à modifier
    * @return void
    */

    public function update(Post $post)
    {

        // Prépare une requête de type UPDATE.
        $req = $this->database->prepare('UPDATE post
                                  SET
                                  title = :title,
                                  chapo = :chapo,
                                  content = :content,
                                  updateDate = NOW(),
                                  idUser = :idUser
                                  WHERE
                                  idPost = :idPost');

        // Assignation des valeurs à la requête.
        $req->bindValue(':title', $post->title(), \PDO::PARAM_STR);
        $req->bindValue(':chapo', $post->chapo(), \PDO::PARAM_STR);
        $req->bindValue(':content', $post->content(), \PDO::PARAM_STR);
        $req->bindValue(':idUser', $post->idUser(), \PDO::PARAM_INT);
        $req->bindValue(':idPost', $post->idPost(), \PDO::PARAM_INT);

        // Exécution de la requête.
        $req->execute();
    }

    /**
    * Méthode retournant une liste de posts demandés.
    * @return array La liste des posts. Chaque entrée est une instance de Post.
    */

    public function getList()
    {

        $sql = 'SELECT
                    post.idPost,
                    post.title,
                    post.chapo,
                    post.content,
                    post.image,
                    post.creationDate AS creationDate,
                    post.updateDate AS updateDate,
                    user.username
                    FROM post
                    INNER JOIN user
                    ON post.idUser = user.idUser
                    ORDER BY post.updateDate DESC';


        $req = $this->database->query($sql);
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\model\\Post');
        $posts = $req->fetchAll();

        // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout et de modification.
        foreach ($posts as $post) {
            $post->setCreationDate(new \DateTime($post->creationDate()));
            $post->setUpdateDate(new \DateTime($post->updateDate()));
        }

        $req->closeCursor();

        return $posts;
    }

    /**
    * Méthode retournant un post précis.
    * @param int L'identifiant du post à récupérer
    * @return object Post Le post demandé
    */

    public function get($idPost)
    {

        $req = $this->database->prepare('SELECT
                                post.idPost, post.title, post.chapo, post.content, post.image,
                                post.creationDate AS creationDate,
                                post.updateDate AS updateDate,
                                user.username
                                FROM post
                                INNER JOIN user
                                ON post.idUser = user.idUser
                                WHERE idPost = :idPost');

        $req->bindValue(':idPost', (int) $idPost, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\model\\Post');

        $post = $req->fetch();

        $post->setCreationDate(new \DateTime($post->creationDate()));
        $post->setUpdateDate(new \DateTime($post->updateDate()));

        return $post;
    }

    /**
    * Méthode permettant de vérifier si un post existe déja.
    * @param string Le titre du post à vérifier
    * @return bool
    */

    public function exists($info)
    {

        // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.
        $req = $this->database->prepare('SELECT COUNT(*) FROM post WHERE title = :title');
        $req->execute([':title' => $info]);

        return (bool) $req->fetchColumn();
    }
}
