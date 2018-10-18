<?php

class CommentManagerPDO extends CommentManager
{
    protected $db; // Instance de PDO

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function add(Comment $comment)
    {

        // Préparation de la requête d'insertion.
        $q = $this->db->prepare('INSERT INTO comment(content, creation_date, valid, id_user, id_post)
                                  VALUES (:content, NOW(), \'No\', :id_user, :id_post)');

        // Assignation des valeurs du comment.
        $q->bindValue(':content', $comment->content());
        $q->bindValue(':id_user', $comment->id_user());
        $q->bindValue(':id_post', $comment->id_post());

        // Exécution de la requête.
        $q->execute();

        // Hydratation du comment passé en paramètre avec assignation de son identifiant.
        $comment->hydrate(['id_comment' => $this->db->lastInsertId()]);

    }

    public function delete($id_comment)
    {

      // Exécute une requête de type DELETE.
      $this->db->exec('DELETE FROM comment WHERE id_comment = '.(int) $id_comment);

    }

    public function update(Comment $comment)
    {

        // Prépare une requête de type UPDATE.
        $q = $this->db->prepare('UPDATE comment
                                  SET
                                  content = :content,
                                  id_user = :id_user
                                  WHERE
                                  id_comment = :id_comment');

        // Assignation des valeurs à la requête.
        $q->bindValue(':content', $comment->content(), PDO::PARAM_STR);
        $q->bindValue(':id_user', $comment->id_user(), PDO::PARAM_INT);
        $q->bindValue(':id_comment', $comment->id_comment(), PDO::PARAM_INT);


        // Exécution de la requête.
        $q->execute();
    }




    public function getList($id_post)
    {

        // On verifie qu'il y a des commentaires correspondants à ce post.
        $q = $this->db->prepare('SELECT COUNT(*) FROM comment WHERE id_post = :id_post');
        $q->execute([':id_post' => $id_post]);

        if((bool) $q->fetchColumn()) {

            $q = $this->db->prepare('SELECT
                        comment.id_comment,
                        comment.content,
                        comment.id_post,
                        comment.creation_date AS creation_date,
                        user.username
                        FROM comment
                        LEFT JOIN user ON user.id_user = comment.id_user
                        WHERE comment.id_post = :id_post
                        AND comment.valid = \'Yes\'
                        ORDER BY comment.creation_date');


            $q->bindValue(':id_post', (int) $id_post, PDO::PARAM_INT);

            $q->execute();

            $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
            $comments = $q->fetchAll();

            // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout.

            foreach ($comments as $comment) {

                $comment->setCreation_date(new DateTime($comment->creation_date()));

            }

            $q->closeCursor();

            return $comments;
        }

    }

    public function get($id_comment)
    {
        $q = $this->db->prepare('SELECT
                                comment.id_comment, comment.content,
                                comment.creation_date AS creation_date,
                                user.username
                                FROM comment
                                INNER JOIN user
                                ON comment.id_user = user.id_user
                                WHERE id_comment = :id_comment');

        $q->bindValue(':id_comment', (int) $id_comment, PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');

        $comment = $q->fetch();

        $comment->setCreation_date(new DateTime($comment->creation_date()));

        return $comment;

    }

   public function getPendingList()
    {

        $q = $this->db->prepare('SELECT
                                        comment.id_comment,
                                        comment.content,
                                        comment.creation_date,
                                        comment.valid,
                                        user.username
                                        FROM comment
                                        LEFT JOIN user ON comment.id_user = user.id_user
                                        WHERE comment.valid = \'No\'
                                        ORDER BY comment.creation_date');

        $q->execute();
        $q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
        $comments = $q->fetchAll();

        // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout et de modification.

        foreach ($comments as $comment) {

            $comment->setCreation_date(new DateTime($comment->Creation_date()));


        }

        $q->closeCursor();

        return $comments;
    }

    public function validate($id_comment)
    {

        // Prépare une requête de type UPDATE.
        $q = $this->db->prepare('UPDATE comment
                                  SET
                                  valid = :valid
                                  WHERE
                                  id_comment = :id_comment');

        // Assignation des valeurs à la requête.
        $q->bindValue(':valid', 'Yes', PDO::PARAM_STR);
        $q->bindValue(':id_comment', $id_comment, PDO::PARAM_INT);


        // Exécution de la requête.
        $q->execute();
    }

}

