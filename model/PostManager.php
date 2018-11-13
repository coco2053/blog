<?php

/**
* Classe abstraite representant le manager des posts.
* @author Bastien Vacherand.
*/

namespace Bastien\blog\model;

abstract class PostManager
{

    /**
    * Méthode permettant d'ajouter un post.
    * @param object Post Le post à ajouter
    * @return void
    */

    abstract public function add(Post $post);

    /**
    * Méthode permettant de supprimer un post.
    * @param int L'identifiant du post à supprimer
    * @return void
    */

    abstract public function delete($idPost);

    /**
    * Méthode permettant de modifier un post.
    * @param object Post le post à modifier
    * @return void
    */

    abstract public function update(Post $post);

    /**
    * Méthode retournant une liste de posts demandés.
    * @return array La liste des posts. Chaque entrée est une instance de Post.
    */

    abstract public function getList();

    /**
    * Méthode retournant un post précis.
    * @param int L'identifiant du post à récupérer
    * @return object Post Le post demandé
    */

    abstract public function get($idPost);

    /**
    * Méthode permettant de vérifier si un post existe déja.
    * @param string Le titre du post à vérifier
    * @return bool
    */

    abstract public function exists($info);
}
