<?php

/**
* Classe representant le manager des commntaires en PDO.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

class CommentManagerPDO extends CommentManager
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
    * Methode qui permet d'ajouter un commentaire dans la bdd.
    * @param object Comment.
    * @return void
    */

    public function add(Comment $comment)
    {

        // Préparation de la requête d'insertion.
        $req = $this->database->prepare('INSERT INTO comment(content, creationDate, valid, idUser, idPost)
                                  VALUES (:content, NOW(), :valid, :idUser, :idPost)');

        // Assignation des valeurs du comment.
        $req->bindValue(':content', $comment->content());
        $req->bindValue(':valid', $comment->valid());
        $req->bindValue(':idUser', $comment->idUser());
        $req->bindValue(':idPost', $comment->idPost());

        // Exécution de la requête.
        $req->execute();

        // Hydratation du comment passé en paramètre avec assignation de son identifiant.
        $comment->hydrate(['idComment' => $this->database->lastInsertId()]);
    }

    /**
    * Methode qui permet de suprimmer un commentaire de la bdd.
    * @param int, id du post.
    * @return void
    */

    public function delete($idComment)
    {

        // Exécute une requête de type DELETE.
        $this->database->exec('DELETE FROM comment WHERE idComment = '.(int) $idComment);
    }

    /**
    * Methode qui permet de recuperer la liste des commentaires d'un post.
    * @param int, id du post.
    * @return array de commentaires.
    */

    public function getList($idPost)
    {

        // On verifie qu'il y a des commentaires correspondants à ce post.
        $req = $this->database->prepare('SELECT COUNT(*) FROM comment WHERE idPost = :idPost');
        $req->execute([':idPost' => $idPost]);

        if ((bool) $req->fetchColumn()) {
            $req = $this->database->prepare('SELECT
                        comment.idComment,
                        comment.content,
                        comment.idPost,
                        comment.creationDate AS creationDate,
                        user.username
                        FROM comment
                        LEFT JOIN user ON user.idUser = comment.idUser
                        WHERE comment.idPost = :idPost
                        AND comment.valid = \'Yes\'
                        ORDER BY comment.creationDate DESC');


            $req->bindValue(':idPost', (int) $idPost, \PDO::PARAM_INT);

            $req->execute();

            $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\blog\\model\\Comment');
            $comments = $req->fetchAll();

            // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout.
            foreach ($comments as $comment) {
                $comment->setCreationDate(new \DateTime($comment->creationDate()));
            }

            $req->closeCursor();

            return $comments;
        }
    }

    /**
    * Methode qui permet de recuperer les commentaires en attente de validation.
    * @param void
    * @return array de commentaires
    */

    public function getPendingList()
    {
        $req = $this->database->prepare('SELECT
                                        comment.idComment,
                                        comment.content,
                                        comment.creationDate,
                                        comment.valid,
                                        user.username
                                        FROM comment
                                        LEFT JOIN user ON comment.idUser = user.idUser
                                        WHERE comment.valid = \'No\'
                                        ORDER BY comment.creationDate');

        $req->execute();
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\\Bastien\\blog\\model\\Comment');
        $comments = $req->fetchAll();

        /* On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise
        de dates d'ajout et de modification. */
        foreach ($comments as $comment) {
            $comment->setCreationDate(new \DateTime($comment->CreationDate()));
        }

        $req->closeCursor();

        return $comments;
    }

    /**
    * Methode qui permet de valider un commentaire.
    * @param int id du comment
    * @return void
    */

    public function validate($idComment)
    {

        // Prépare une requête de type UPDATE.
        $req = $this->database->prepare('UPDATE comment
                                  SET
                                  valid = :valid
                                  WHERE
                                  idComment = :idComment');

        // Assignation des valeurs à la requête.
        $req->bindValue(':valid', 'Yes', \PDO::PARAM_STR);
        $req->bindValue(':idComment', $idComment, \PDO::PARAM_INT);

        // Exécution de la requête.
        $req->execute();
    }
}
