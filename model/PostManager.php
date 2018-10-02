<?php

abstract class PostManager
{
  /**
   * Méthode permettant d'ajouter un post.
   * @param $post Post Le post à ajouter
   * @return void
   */

    abstract public function add(Post $post);

  /**
   * Méthode permettant de supprimer un post.
   * @param $id int L'identifiant du post à supprimer
   * @return void
   */

    abstract public function delete($id_post);

  /**
   * Méthode permettant de modifier un post.
   * @param $post Post le post à modifier
   * @return void
   */
    abstract public function update(Post $post);

  /**
   * Méthode retournant une liste de posts demandés.
   * @return array La liste des post. Chaque entrée est une instance de Post.
   */
    abstract public function getList();

  /**
   * Méthode retournant un post précis.
   * @param $id int L'identifiant du post à récupérer
   * @return Post Le post demandé
   */

    abstract public function get($id_post);


  /**
   * Méthode permettant de vérifier si un post existe déja.
   * @param $info string Le titre du post à vérifier
   * @return bool
   */

    abstract public function exists($info);
}
