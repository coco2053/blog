<?php

abstract class CommentManager
{
  /**
   * Méthode permettant d'ajouter un comment.
   * @param $comment Comment Le comment à ajouter
   * @return void
   */

    abstract public function add(Comment $comment);

  /**
   * Méthode permettant de supprimer un comment.
   * @param $id int L'identifiant du comment à supprimer
   * @return void
   */

    abstract public function delete($id_comment);

  /**
   * Méthode permettant de modifier un comment.
   * @param $comment Comment le comment à modifier
   * @return void
   */
    abstract public function update(Comment $comment);

  /**
   * Méthode retournant une liste de comments demandés.
   * @return array La liste des comment. Chaque entrée est une instance de Comment.
   */
    abstract public function getList($id_post);

  /**
   * Méthode retournant un comment précis.
   * @param $id int L'identifiant du comment à récupérer
   * @return Comment Le comment demandé
   */

    abstract public function get($id_comment);

  /**
   * Méthode retournant les commentaires en attente de validation.
   * @return array La liste des comment non valides.
   */
     abstract public function getPendingList();

  /**
   * Méthode permettant de valider un comment.
   * @param $id int L'identifiant du comment à valider.
   * @return void.
   */
     abstract public function validate($id_comment);

}
