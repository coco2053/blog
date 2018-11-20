blog
====

Projet 5 - Parcours développeur d'application PHP/Symfony - OpenClassrooms
--------------------------------------------------------------------------

[![SymfonyInsight](https://insight.symfony.com/projects/db527d54-43b6-4adc-bc27-148092a615b0/big.svg)](https://insight.symfony.com/projects/db527d54-43b6-4adc-bc27-148092a615b0)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/60d62b4aea024fa0887f58955f6b395a)](https://www.codacy.com/app/coco2053/blog?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=coco2053/blog&amp;utm_campaign=Badge_Grade)

### ___Installation sur serveur___

Une fois le site déployé, le dossier racine doit être /public . Faire pointer le _virtual host_ sur celui-ci.

### ___Connexion à la BDD___

Le site utilise une base de données afin d'enregistrer les articles, commentaires, comptes utilisateur etc.

* Utilisez le fichier script *blog.sql* pour la création de la BDD et son remplissage.
* Entrez vos parametres de connexion à la Bdd dans le fichier 'config/connect.php'

    * 'host'    => 'nom_hote',
    * 'dbname'  => 'BBD',
    * 'username'=> 'nom_utilisateur',
    * 'password'=> 'mot_de_passe'

### ___Configurer l'envoie de mail___

* '/config/mailer.php' contient un tableau qui doit être renseigné afin de rendre fonctionnels le formulaire de contact, le système de récupération du mot de passe ainsi que l'inscription au site.
    * 'smtp' : l'adresse de votre serveur smtp
    * 'port' : le port de votre serveur smtp
    * 'mode' : le mode de votre serveur smtp
    * 'username' : votre identifiant pour le serveur, souvent une adresse courriel
    * 'password' : le mot de passe
    * 'email' : l'adresse de l'administrateur, par exemple contact@monblog.com
    * 'address' : l'adresse de votre site, par exemple www.monsite.fr

### ___Configurer recaptcha___

*Entrez votre clé privée racptcha dans config/recaptcha.php


 Et voilà !, vous pouvez desormais utiliser le blog.

 Theme Bootstrap :

 [https://startbootstrap.com/template-overviews/1-col-portfolio/](https://startbootstrap.com/template-overviews/1-col-portfolio/ "theme bootstrap")

 Pour consulter mon blog:

 [https://bastienvacherand.000webhostapp.com/blog/](https://bastienvacherand.000webhostapp.com/blog/ "Mon site")

 À bientôt ...


