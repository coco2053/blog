<?php

/**
* Classe abstraite representant le manager des commntaires.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

abstract class CommentManager
{
    /**
    * Méthode permettant d'ajouter un comment.
    * @param Object Comment Le comment à ajouter
    * @return void
    */

    abstract public function add(Comment $comment);

    /**
    * Méthode permettant de supprimer un comment.
    * @param int L'identifiant du comment à supprimer
    * @return void
    */

    abstract public function delete($idComment);

    /**
    * Méthode retournant une liste de comments demandés.
    * @return array La liste des comment. Chaque entrée est une instance de Comment.
    */

    abstract public function getList($idPost);

    /**
    * Méthode retournant les commentaires en attente de validation.
    * @return array La liste des comment non valides.
    */

    abstract public function getPendingList();

    /**
    * Méthode permettant de valider un comment.
    * @param int L'identifiant du comment à valider.
    * @return void.
    */

    abstract public function validate($idComment);
}
