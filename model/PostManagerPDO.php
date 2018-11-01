<?php

/**
* Classe abstraite representant le manager des posts en PDO.
* @author Bastien Vacherand.
*/

class PostManagerPDO extends PostManager
{
    protected $db; // Instance de PDO

    /**
    * Constructeur de la classe qui permet d'instancier la Bdd.
    * @param object PDO
    * @return void
    */

    public function __construct(PDO $db)
    {

        $this->db = $db;
    }

    /**
    * Méthode permettant d'ajouter un post.
    * @param object Post Le post à ajouter
    * @return void
    */

    public function add(Post $post)
    {

        // Préparation de la requête d'insertion.
        $q = $this->db->prepare('INSERT INTO post(title, chapo, content, image, creation_date, update_date, id_user)
                                  VALUES (:title, :chapo, :content, :image, NOW(), NOW(), :id_user)');

        // Assignation des valeurs du post.
        $q->bindValue(':title', $post->title());
        $q->bindValue(':chapo', $post->chapo());
        $q->bindValue(':content', $post->content());
        $q->bindValue(':image', $post->image());
        $q->bindValue(':id_user', $post->id_user());

        // Exécution de la requête.
        $q->execute();

        // Hydratation du post passé en paramètre avec assignation de son identifiant.
        $post->hydrate(['id_post' => $this->db->lastInsertId()]);
    }

    /**
    * Méthode permettant de supprimer un post.
    * @param int L'identifiant du post à supprimer
    * @return void
    */

    public function delete($id_post)
    {

       $q = $this->db->prepare('SELECT
                        post.id_post, post.image
                        FROM post
                        WHERE id_post = :id_post');

        $q->bindValue(':id_post', (int) $id_post, PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        $post = $q->fetch();

        if ($post->image() != 'no-image.jpeg') {

            unlink('public/upload/'.$post->image());
        }

        // Exécute une requête de type DELETE.
        $this->db->exec('DELETE FROM post WHERE id_post = '.(int) $id_post);
        $this->db->exec('DELETE FROM comment WHERE id_post = '.(int) $id_post);
    }

    /**
    * Méthode permettant de modifier un post.
    * @param object Post le post à modifier
    * @return void
    */

    public function update(Post $post)
    {

        // Prépare une requête de type UPDATE.
        $q = $this->db->prepare('UPDATE post
                                  SET
                                  title = :title,
                                  chapo = :chapo,
                                  content = :content,
                                  update_date = NOW(),
                                  id_user = :id_user
                                  WHERE
                                  id_post = :id_post');

        // Assignation des valeurs à la requête.
        $q->bindValue(':title', $post->title(), PDO::PARAM_STR);
        $q->bindValue(':chapo', $post->chapo(), PDO::PARAM_STR);
        $q->bindValue(':content', $post->content(), PDO::PARAM_STR);
        $q->bindValue(':id_user', $post->id_user(), PDO::PARAM_INT);
        $q->bindValue(':id_post', $post->id_post(), PDO::PARAM_INT);

        // Exécution de la requête.
        $q->execute();
    }

    /**
    * Méthode retournant une liste de posts demandés.
    * @return array La liste des posts. Chaque entrée est une instance de Post.
    */

    public function getList()
    {

        $sql = 'SELECT
                    post.id_post,
                    post.title,
                    post.chapo,
                    post.content,
                    post.image,
                    post.creation_date AS creation_date,
                    post.update_date AS update_date,
                    user.username
                    FROM post
                    INNER JOIN user
                    ON post.id_user = user.id_user
                    ORDER BY post.update_date DESC';


        $q = $this->db->query($sql);
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
        $posts = $q->fetchAll();

        // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout et de modification.
        foreach ($posts as $post) {

            $post->setCreation_date(new DateTime($post->creation_date()));
            $post->setUpdate_date(new DateTime($post->update_date()));
        }

        $q->closeCursor();

        return $posts;
    }

    /**
    * Méthode retournant un post précis.
    * @param int L'identifiant du post à récupérer
    * @return object Post Le post demandé
    */

    public function get($id_post)
    {

        $q = $this->db->prepare('SELECT
                                post.id_post, post.title, post.chapo, post.content, post.image,
                                post.creation_date AS creation_date,
                                post.update_date AS update_date,
                                user.username
                                FROM post
                                INNER JOIN user
                                ON post.id_user = user.id_user
                                WHERE id_post = :id_post');

        $q->bindValue(':id_post', (int) $id_post, PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        $post = $q->fetch();

        $post->setCreation_date(new DateTime($post->creation_date()));
        $post->setUpdate_date(new DateTime($post->update_date()));

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
        $q = $this->db->prepare('SELECT COUNT(*) FROM post WHERE title = :title');
        $q->execute([':title' => $info]);

        return (bool) $q->fetchColumn();
    }
}
