-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 25 juil. 2018 à 15:54
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `utilisateur_commentaire_fk` (`id_user`),
  KEY `post_commentaire_fk` (`id_post`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `utilisateur_post_fk` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id_post`, `title`, `chapo`, `content`, `creation_date`, `update_date`, `id_user`) VALUES
(4, 'Les aquariums d\'eau douce', 'Un loisir très apaisant!', 'kjbgeibgejjg e gbijgb eibgi zebgijbeijg biebgiejb igjbeijbgiejbgib iezjgbkjbtgkjebtgijbe gkjebkjgbekjtbg kjbezkjbkjbgkejbtgkj bzkejt bgkjbtg kjbtgk zjbgkj btkzjbgkjbktjzbgk zjebtgkùsjbeg tezbgkjb zekbgkzebgkh', '2018-07-23 20:39:19', '2018-07-23 20:39:19', 1),
(5, 'Le festival ZIK ZAC', 'Festival de musique gratuit au Jas de Bouffan !', 'kjbgeibgejjg e gbijgb eibgi zebgijbeijg biebgiejb igjbeijbgiejbgib iezjgbkjbtgkjebtgijbe gkjebkjgbekjtbg kjbezkjbkjbgkejbtgkj bzkejt bgkjbtg kjbtgk zjbgkj btkzjbgkjbktjzbgk zjebtgkùsjbeg tezbgkjb zekbgkzebgkh', '2018-07-24 16:26:01', '2018-07-24 16:26:01', 1),
(6, 'Apprendre la guitare', 'C\'est pas simple !', 'srgherh ethj tej tey nj jetntnet,tr,tr,e,edy,eh,ethe,thrznjtzynj tn t', '2018-07-25 16:48:13', '2018-07-25 16:48:13', 1),
(8, 'Partir en vacances', 'Indispensable cet été !', 'oaigoaeogno aegoneojgn oejngo zeobj rzoje gojze boj etzojb goeztj bojrz ebjo etzojtg boj btro', '2018-07-25 17:03:38', '2018-07-25 17:03:38', 1);

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id_rights` int(11) NOT NULL AUTO_INCREMENT,
  `rights` varchar(50) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_rights`),
  KEY `role_droits_fk` (`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `role_utilisateur_fk` (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `mail`, `pass`, `username`, `lastname`, `firstname`, `id_role`) VALUES
(1, 'coco2053@hotmail.com', 'zazazaza', 'coco2053', 'Vacherand', 'Bastien', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
