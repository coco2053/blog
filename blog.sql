-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 20 nov. 2018 à 12:21
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
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `creationDate` datetime NOT NULL,
  `valid` varchar(5) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  PRIMARY KEY (`idComment`),
  KEY `id_user` (`idUser`),
  KEY `id_post` (`idPost`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`idComment`, `content`, `creationDate`, `valid`, `idUser`, `idPost`) VALUES
(6, 'Une grande leçon...', '2018-11-06 16:20:39', 'Yes', 1, 132),
(7, 'Grenouille explosée !', '2018-11-06 16:24:05', 'Yes', 13, 132),
(8, 'Je l\'ai bien apprise à l\'école mais je suis incapable de la réciter.', '2018-11-06 16:24:56', 'Yes', 13, 133),
(10, 'bonjour', '2018-11-08 15:51:04', 'Yes', 1, 132),
(11, 'et Bim!', '2018-11-19 13:38:06', 'Yes', 16, 132),
(13, 'J\'ai toujours été mauvais à Tetris et je pense pas que çà va s\'ameliorer avec ce genre de devices...', '2018-11-19 18:44:47', 'Yes', 1, 158),
(14, 'On se raproche petit à petit de Matrix.', '2018-11-19 18:46:27', 'Yes', 14, 158),
(15, 'Attention au carambolage taile XXL !', '2018-11-19 18:49:23', 'Yes', 1, 157),
(16, 'Qui a dit que PHP était mort ?', '2018-11-19 18:50:29', 'Yes', 1, 156),
(17, 'Je vous rassure le blog est en v7.1 ;-)', '2018-11-19 18:51:33', 'Yes', 1, 155),
(18, 'Sinon les transports en commun c\'est bien aussi et plus simple...', '2018-11-19 18:58:31', 'Yes', 17, 157),
(19, 'Envoyez les pepettes !', '2018-11-19 18:59:05', 'Yes', 17, 156),
(20, 'Le bug de l\'an 2019 !', '2018-11-19 18:59:47', 'Yes', 17, 155),
(21, 'Je ne suis pas un robot', '2018-11-19 19:01:37', 'No', 13, 158),
(22, 'A quand une grosse MAJ ?', '2018-11-19 19:02:23', 'No', 13, 155);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `idPermission` int(11) NOT NULL AUTO_INCREMENT,
  `actionList` text NOT NULL,
  PRIMARY KEY (`idPermission`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idPermission`, `actionList`) VALUES
(1, 'addPostView;addPost;editPostView;editPost;deletePost;getUser;deleteUser;writePostView;getUsersView;getPendingUsersView;validateUser;addComment;deleteComment;getPendingComments;validateComment;'),
(2, 'addPostView;addPost;editPostView;editPost;deletePost;getUser;writePostView;getPendingUsersView;validateUser;addComment;deleteComment;getPendingComments;validateComment;'),
(3, 'getUser;addComment;');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `idPost` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `creationDate` datetime NOT NULL,
  `updateDate` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idPost`),
  KEY `utilisateur_post_fk` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`idPost`, `title`, `chapo`, `content`, `image`, `creationDate`, `updateDate`, `idUser`) VALUES
(155, 'plus de 60 % des sites Web tournent sur PHP 5.x', 'Une version qui ne sera plus supportée après le 31 décembre 2018', '  Passé le 31 décembre 2018, aucune version de PHP 5.x ne va encore bénéficier de mise à jour de sécurité, puisque PHP 5.6, la dernière version de la branche, sera également coupée de ces mises à jour. Cela n\'est toutefois pas une nouvelle, car c\'est bien connu de la communauté PHP depuis plus d\'un an. Ce qui devrait donc avoir laissé suffisamment de temps aux sites Web utilisant PHP 5.x pour migrer vers PHP 7.1+ (la fin des mises à jour de sécurité de PHP 7.0 étant prévue pour le 3 décembre).\r\n\r\nMais le constat est que des millions de sites internet utilisent encore PHP 5.x à 10 semaines de la fin des mises à jour de sécurité de cette branche du langage de programmation Web. C\'est en tout cas ce que révèlent les dernières statistiques de W3Tech.\r\n\r\nPour information, W3Techs (World Wide Web Technology Surveys) est un site spécialisé dans les enquêtes sur l’utilisation des technologies du Web. Il produit donc régulièrement des statistiques sur les technologies Web les plus populaires selon différentes catégories, y compris les langages utilisés pour le développement de sites Web.\r\n\r\nD\'après W3Tech, la version 5.x de PHP est utilisée par 78,3 % des sites Web utilisant PHP. Or au mois d\'octobre 2018, PHP est de très loin le langage de programmation Web côté serveur le plus utilisé. Le même baromètre indique en effet que PHP est utilisé par 78,9 % de tous les sites Web dont il a pu identifier le langage côté serveur. Ce qui veut dire qu\'environ 62 % de tous les sites Web utilisent PHP et pourraient donc être exposés après le 31 décembre 2018.', '1542648134.jpg', '2018-11-19 18:22:14', '2018-11-19 18:22:14', 1),
(156, 'Les salaires des développeurs par langage en 2017 ', 'Le point sur les rémunérations des développeurs en France.', '                              Cabinet de recrutement français spécialisé dans les profils de développeurs, Urban Linker livre le 6e opus de son baromètre annuel de rémunération. L\'étude se concentre sur les profils techniques des métiers du web pour des postes basés en Île-de-France : développeurs PHP, Ruby/Python, Java, DevOps, iOS, Android.... D\'un année sur l\'autre, Urban Linker constate des augmentations de salaire à l\'embauche pour plusieurs de ces profils. \r\n\"Le langage PHP reste très utilisé, et on constate cette année une hausse des salaires liés à ce langage, particulièrement sur les profils seniors\", commente le cabinet. \"Les salaires des développeurs Java sont restés relativement stables par rapport à 2016, même si la demande demeure forte pour ce langage. En revanche, on note une baisse des demandes pour le langage .Net. Il en résulte une légère baisse des salaires, en particulier pour les profils juniors, qui perdent 5,2% de leur salaire.\"\r\nSource : JDN ', '1542648546.jpg', '2018-11-19 18:29:06', '2018-11-19 18:30:06', 1),
(157, 'Voitures Apple', 'Apple veut créer des pelotons de voitures électriques reliées par leurs batteries', ' La firme a la pomme vient d\'obtenir un brevet pour un concept reliant physiquement des voitures autonomes entre elles afin de partager l\'énergie de leurs batteries et de réduire la résistance au vent.\r\nAprès le pare-brise à réalité augmentée et le siège auto intelligent capable d\'avertir le conducteur d\'un danger, Apple continue de breveter des concepts liés à l\'automobile et plus particulièrement à la voiture autonome.\r\n\r\nCette fois, la firme californienne vient d\'obtenir un brevet pour une idée surprenante : un système de navigation en convoi dans lequel les voitures sans chauffeur sont reliées physiquement entre elles. Baptisé Peloton, le système utiliserait un bras rétractable pour interconnecter les véhicules avec pour objectif de mutualiser l\'énergie des batteries et abaisser la résistance au vent par ce principe de file indienne.\r\n\r\nDans son brevet déposé auprès de l\'USPTO, Apple explique que Peloton pourrait fonctionner avec un minimum de deux voitures autonomes mais que le bénéfice serait évidemment plus important si le convoi comporte un plus grand nom de participants. Le système organiserait la disposition des voitures en fonction de leurs itinéraires respectifs, celles ayant le trajet le plus court se trouvant vraisemblablement en fin de convoi pour pouvoir se détacher sans désorganiser la caravane.\r\n\r\nPlutôt pertinente sur le papier, cette idée semble assez complexe à concrétiser et ne pourrait s\'entendre que sur des trajets longs sur autoroute. Mais le système pourrait peut-être plus facilement s\'appliquer aux camions pour lesquels le fonctionnement en convoi est prometteur et a déjà été testé avec succès.\r\n\r\nSource : Futura Tech', '1542649097.jpg', '2018-11-19 18:38:17', '2018-11-19 18:38:17', 1),
(158, 'BrainNet, interface neuronale', 'Une interface entre cerveaux pour jouer à Tetris par la pensée', ' Des chercheurs de l\'université de Washington ont créé la première interface de cerveau à cerveau qui a permis à trois personnes de collaborer via les ondes cérébrales pour jouer à Tetris.\r\n\r\nÀ l\'avenir, l\'expression « brainstorming » pourrait bien prendre un tout autre sens, assez littéral. Capitalisant sur les travaux qu\'ils mènent sur les interfaces de cerveau à cerveau depuis plusieurs années, des chercheurs de l\'université de Washington viennent de franchir une étape majeure en créant un réseau qui a permis à trois personnes d\'envoyer et de recevoir des informations directement à leur cerveau.\r\n\r\nCe « réseau social de cerveaux connectés » dénommé BrainNet a été utilisé avec succès par ce trio pour jouer à Tetris en collaboration. Le dispositif repose sur un électroencéphalographe qui enregistre l\'activité électrique du cerveau « émetteur » via des électrodes répartis sur la tête. Le signal est décodé puis transmis au cerveau « récepteur » via un casque de stimulation magnétique transcrânienne (TMS). Ce dernier envoie des impulsions au niveau du cortex visuel pour créer un phosphène, une illusion lumineuse qui donne l\'impression de voir une lumière de son champ visuel.\r\n\r\nCe procédé non invasif avait déjà été utilisé par le passé par l\'équipe de l\'université de Washington (voir l\'article initial, ci-après) en 2013 puis par un autre groupe de chercheurs pour réaliser une transmission de pensée. Mais c\'est la première fois que plus de deux personnes peuvent communiquer entre elles de cette manière.\r\n\r\nPour cette expérimentation, trois volontaires devaient jouer à Tetris en se tenant dans des pièces séparées et sans voir ce que les autres faisaient. Deux personnes munies d\'un casque EEG étaient chargées d\'émettre les commandes pour la troisième. Sur un écran, elles observaient les briques en train de tomber et devaient décider s\'il fallait ou non les faire pivoter pour les insérer correctement dans le bloc inférieur. Pour indiquer au troisième joueur l\'action à accomplir, les deux « émetteurs » devaient fixer des LED situées sur le côté de l\'écran, l\'une travaillant à 15 Hz, l\'autre à 17 Hz.\r\n\r\nL\'idée est qu\'en percevant ces flashs lumineux, le cerveau produit des ondes qui correspondent à ces fréquences. L\'électroencéphalographe peut alors les capter et interpréter la commande. En l\'occurrence, la LED 15 Hz valait pour faire pivoter la brique et 17 Hz valait pour ne rien faire. Si le système captait le signal à 15 Hz, il le relayait à l\'équipement TMS, lequel générait une impulsion dans le cerveau du « récepteur » qui percevait un phosphène, signe qu\'il devait faire pivoter la brique. \r\n\r\nL\'expérience a été menée avec cinq groupes de trois personnes. Le taux moyen de réussite est d\'un peu plus de 81 %, ce qui est assez impressionnant. Partant de là, les chercheurs estiment qu\'il serait tout à fait envisageable d\'augmenter le nombre de personnes participant à ce réseau via une connexion Internet. Ils imaginent une « interface de cerveau à cerveau hébergée sur un serveur cloud » qui servirait de nœud de transmission à un réseau de personnes réparties un peu partout dans le monde. La communication humaine n\'a sans doute pas épuisé toutes ses possibilités...\r\n\r\nSource : Futura Tech', '1542649396.jpg', '2018-11-19 18:43:16', '2018-11-19 18:43:16', 1),
(128, 'Le corbeau et le renard', 'Livre I, fâble 2', '        Maître Corbeau, sur un arbre perché,\r\n           Tenait en son bec un fromage.\r\n       Maître Renard, par l\'odeur alléché,\r\n           Lui tint à peu près ce langage :\r\n       Et bonjour, Monsieur du Corbeau,\r\n    Que vous êtes joli ! que vous me semblez beau !\r\n           Sans mentir, si votre ramage,\r\n           Se rapporte à votre plumage,\r\n     Vous êtes le Phénix des hôtes de ces bois.\r\nÀ ces mots le Corbeau ne se sent pas de joie,\r\n           Et pour montrer sa belle voix,\r\n   Il ouvre un large bec, laisse tomber sa proie.\r\n   Le Renard s\'en saisit, et dit : Mon bon Monsieur,\r\n              Apprenez que tout flatteur,\r\n     Vit aux dépens de celui qui l\'écoute.\r\n   Cette leçon vaut bien un fromage sans doute.\r\n           Le Corbeau honteux et confus,\r\n   Jura, mais un peu tard, qu\'on ne l\'y prendrait plus.', '1541156591.jpg', '2018-11-02 12:03:11', '2018-11-02 12:03:11', 1),
(127, 'La cigale et la fourmi', 'Livre I, fâble 1', 'La Cigale, ayant chanté tout l\'été, Se trouva fort dépourvue, Quand la bise fut venue. Pas un seul petit morceau, De mouche ou de vermisseau. Elle alla crier famine, Chez la Fourmi sa voisine, La priant de lui prêter, Quelque grain pour subsister, Jusqu\'à la saison nouvelle. Je vous paierai, lui dit-elle, Avant l\'août, foi d\'animal, Intérêt et principal. La Fourmi n\'est pas prêteuse ; C\'est là son moindre défaut. Que faisiez-vous au temps chaud ? Dit-elle à cette emprunteuse. Nuit et jour à tout venant, Je chantais, ne vous déplaise. Vous chantiez ? j\'en suis fort aise : Et bien ! dansez maintenant.  ', '1541156210.jpg', '2018-11-02 11:56:50', '2018-11-02 11:57:48', 1),
(129, 'La laitière et le pot de lait', 'Livre VII, fâble 9 ', ' Perrette, sur sa tête ayant un Pot au lait,\r\n            Bien posé sur un coussinet,\r\nPrétendait arriver sans encombre à la ville.\r\nLégère et court vêtue elle allait à grands pas ;\r\nAyant mis ce jour-là pour être plus agile,\r\n            Cotillon simple, et souliers plats.\r\n            Notre Laitière ainsi troussée,\r\n            Comptait déjà dans sa pensée,\r\nTout le prix de son lait, en employait l’argent,\r\nAchetait un cent d’ œufs, faisait triple couvée ;\r\nLa chose allait à bien par son soin diligent.\r\n            Il m’est, disait-elle, facile,\r\nD’élever des poulets autour de ma maison : \r\n            Le Renard sera bien habile,\r\nS’il ne m’en laisse assez pour avoir un cochon.\r\nLe porc à s’engraisser coûtera peu de son ;\r\nIl était quand je l’eus de grosseur raisonnable ;\r\nJ’aurai le revendant de l’argent bel et bon ;\r\nEt qui m’empêchera de mettre en notre étable,\r\nVu le prix dont il est, une vache et son veau,\r\nQue je verrai sauter au milieu du troupeau ?\r\nPerrette là-dessus saute aussi, transportée.\r\nLe lait tombe ; adieu veau, vache, cochon, couvée ;\r\nLa Dame de ces biens, quittant d’un oeil marri,\r\n            Sa fortune ainsi répandue,\r\n            Va s’excuser à son mari,\r\n            En grand danger d’être battue.\r\n            Le récit en farce en fut fait ;\r\n            On l\' appela le Pot au lait.\r\n            Quel esprit ne bat la campagne ?\r\n            Qui ne fait châteaux en Espagne ?\r\nPicrochole, Pyrrhus, la Laitière, enfin tous,\r\n            Autant les sages que les fous ?\r\nChacun songe en veillant, il n’est rien de plus doux :\r\nUne flatteuse erreur emporte alors nos âmes :\r\n            Tout le bien du monde est à nous,\r\n            Tous les honneurs, toutes les femmes.\r\nQuand je suis seul, je fais au plus brave un défi ;\r\nJe m écarte, je vais détrôner le Sophi ;\r\n            On m’élit Roi, mon peuple m’aime ;\r\nLes diadèmes vont sur ma tête pleuvant :\r\nQuelque accident fait-il que je rentre en moi-même ;\r\n            Je suis gros Jean comme devant.', '1541156967.jpg', '2018-11-02 12:09:27', '2018-11-02 12:09:27', 1),
(131, 'Le loup et l\'agneau', 'Livre I, fâble 10', '                             La raison du plus fort est toujours la meilleure : Nous l\'allons montrer tout à l\'heure. Un Agneau se désaltérait, Dans le courant d\'une onde pure. Un Loup survient à jeun, qui cherchait aventure, Et que la faim en ces lieux attirait. Qui te rend si hardi de troubler mon breuvage ? Dit cet animal plein de rage : Tu seras châtié de ta témérité. Sire, répond l\'Agneau, que Votre Majesté, Ne se mette pas en colère ; Mais plutôt qu\'elle considère, Que je me vas désaltérant, Dans le courant, Plus de vingt pas au-dessous d\'Elle ; Et que par conséquent, en aucune façon, Je ne puis troubler sa boisson. Tu la troubles, reprit cette bête cruelle, Et je sais que de moi tu médis l\'an passé. Comment l\'aurais-je fait si je n\'étais pas né ? Reprit l\'Agneau ; je tette encor ma mère, Si ce n\'est toi, c\'est donc ton frère. Je n\'en ai point. C\'est donc quelqu\'un des tiens: Car vous ne m\'épargnez guère, Vous, vos Bergers et vos Chiens. On me l\'a dit : il faut que je me venge.\" Là-dessus, au fond des forêts, Le loup l\'emporte et puis le mange, Sans autre forme de procès.  ', '1541157382.jpg', '2018-11-02 12:16:22', '2018-11-19 16:13:13', 1),
(132, 'La grenouille qui se veut faire aussi grosse que le bœuf', 'Livre I, fâble 3', '                                              Une Grenouille vit un Bœuf,&lt;br /&gt;<br />\r\n               Qui lui sembla de belle taille.&lt;br /&gt;<br />\r\nElle qui n\'était pas grosse en tout comme un œuf,&lt;br /&gt;<br />\r\nEnvieuse s\'étend, et s\'enfle, et se travaille,&lt;br /&gt;<br />\r\n               Pour égaler l\'animal en grosseur,&lt;br /&gt;<br />\r\n...............Disant : Regardez bien, ma sœur ;&lt;br /&gt;<br />\r\nEst-ce assez ? dites-moi ; n\'y suis-je point encore ?&lt;br /&gt;<br />\r\nNenni. M\'y voici donc ? Point du tout. M\'y voilà ?&lt;br /&gt;<br />\r\nVous n\'en approchez point. La chétive Pécore,&lt;br /&gt;<br />\r\n               S\'enfla si bien qu\'elle creva.&lt;br /&gt;<br />\r\nLe monde est plein de gens qui ne sont pas plus sages:&lt;br /&gt;<br />\r\nTout bourgeois veut bâtir comme les grands seigneurs,&lt;br /&gt;<br />\r\n        Tout petit prince a des ambassadeurs,&lt;br /&gt;<br />\r\n              Tout marquis veut avoir des pages.   ', '1541157781.jpg', '2018-11-02 12:23:01', '2018-11-14 14:48:16', 1),
(133, 'Le lièvre et la tortue', 'Livre VI, fâble 10', 'Rien ne sert de courir ; il faut partir à point.<br />\r\nLe Lièvre et la Tortue en sont un témoignage.<br />\r\nGageons, dit celle-ci, que vous n\'atteindrez point,<br />\r\nSi tôt que moi ce but. Si tôt ? Êtes-vous sage ?<br />\r\n              Repartit l\'Animal léger.<br />\r\n              Ma Commère, il vous faut purger,<br />\r\n              Avec quatre grains d\'ellébore.<br />\r\n              Sage ou non, je parie encore.<br />\r\n              Ainsi fut fait : et de tous deux,&lt;br /&gt;&lt;br /&gt;<br />\r\n              On mit près du but les enjeux.&lt;br /&gt;&lt;br /&gt;<br />\r\n              Savoir quoi, ce n\'est pas l\'affaire ;&lt;br /&gt;&lt;br /&gt;<br />\r\n              Ni de quel juge l\'on convint.&lt;br /&gt;&lt;br /&gt;<br />\r\n   Notre Lièvre n\'avait que quatre pas à faire ;&lt;br /&gt;&lt;br /&gt;<br />\r\n   J\'entends de ceux qu\'il fait lorsque prêt d\'être atteint,&lt;br /&gt;&lt;br /&gt;<br />\r\n   Il s\'éloigne des Chiens, les renvoie aux calendes,&lt;br /&gt;&lt;br /&gt;<br />\r\n              Et leur fait arpenter les landes.&lt;br /&gt;&lt;br /&gt;<br />\r\n   Ayant, dis-je, du temps de reste pour brouter,&lt;br /&gt;&lt;br /&gt;<br />\r\n              Pour dormir, et pour écouter,&lt;br /&gt;&lt;br /&gt;<br />\r\n       D\'où vient le vent, il laisse la Tortue,&lt;br /&gt;&lt;br /&gt;<br />\r\n              Aller son train de Sénateur.&lt;br /&gt;&lt;br /&gt;<br />\r\n              Elle part, elle s\'évertue ;&lt;br /&gt;&lt;br /&gt;<br />\r\n              Elle se hâte avec lenteur.&lt;br /&gt;&lt;br /&gt;<br />\r\n   Lui cependant méprise une telle victoire ;&lt;br /&gt;&lt;br /&gt;<br />\r\n              Tient la gageure à peu de gloire ;&lt;br /&gt;&lt;br /&gt;<br />\r\n              Croit qu\'il y va de son honneur,&lt;br /&gt;&lt;br /&gt;<br />\r\n       De partir tard. Il broute, il se repose,&lt;br /&gt;&lt;br /&gt;<br />\r\n              Il s\'amuse à toute autre chose,&lt;br /&gt;&lt;br /&gt;<br />\r\n       Qu\'à la gageure. À la fin, quand il vit&lt;br /&gt;&lt;br /&gt;<br />\r\n   Que l\'autre touchait presque au bout de la carrière,&lt;br /&gt;&lt;br /&gt;<br />\r\n   Il partit comme un trait ; mais les élans qu\'il fit,&lt;br /&gt;&lt;br /&gt;<br />\r\n   Furent vains : la Tortue arriva la première.&lt;br /&gt;&lt;br /&gt;<br />\r\n   Eh bien, lui cria-t-elle, avais-je pas raison ?&lt;br /&gt;&lt;br /&gt;<br />\r\n              De quoi vous sert votre vitesse ?&lt;br /&gt;&lt;br /&gt;<br />\r\n              Moi l\'emporter ! et que serait-ce,&lt;br /&gt;&lt;br /&gt;<br />\r\n              Si vous portiez une maison ?  ', '1541158022.jpg', '2018-11-02 12:27:03', '2018-11-19 16:08:15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `idPermission` int(11) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`idRole`, `name`, `idPermission`) VALUES
(1, 'member', 3),
(2, 'admin', 2),
(3, 'super_admin', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `signinDate` datetime NOT NULL,
  `signupDate` datetime NOT NULL,
  `asleep` varchar(5) NOT NULL,
  `valid` varchar(3) NOT NULL,
  `idRole` int(11) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `email`, `password`, `username`, `lastname`, `firstname`, `signinDate`, `signupDate`, `asleep`, `valid`, `idRole`) VALUES
(1, 'coco2053@hotmail.com', '$2y$10$jCfh8MlrmyILcExUha3eie1f2JA5SK5n1QXMrTXu9t2vllNSqoltS', 'coco2053', 'Vacherand', 'Bastien', '2018-11-20 13:03:00', '2018-10-01 15:00:00', 'No', 'Yes', 3),
(13, 'coco2053@gmail.com', '$2y$10$pE7pdyu4uxMGycE/hrBlSeY5TyauGu.bohDWT7vYY5U0EQaf77OnS', 'Beber', 'Bertrand', 'Tessaro', '2018-11-19 19:01:11', '2018-11-06 12:27:55', 'Yes', 'Yes', 1),
(18, 'luigi@fabio.com', '$2y$10$OHwiw/U0xM2ip05/NYtmkOP3mWEp5A461nCPwfBjGMaKXocVwEMr.', 'Luigi', 'Fabio', 'Alain', '2018-11-19 19:04:27', '2018-11-19 19:04:27', 'No', 'No', 1),
(17, 'bastienvacherand2@gmail.com', '$2y$10$0gURIBSIUl3SN3w5JicHv.jWwGlRFIjF0lyhdOnC4ACuH2cW/jciu', 'Sly', 'Huguet', 'Sylvain', '2018-11-19 18:52:40', '2018-11-19 14:50:44', 'Yes', 'Yes', 1),
(14, 'bastienvacherand@gmail.com', '$2y$10$cqhyaGCDTIU7rMruyzB8yeDrjtKBom55dOeQAwMBclJZ0FZXFMT8a', 'Lulu', 'Gaudion', 'Lucien', '2018-11-19 18:45:30', '2018-11-06 12:29:10', 'Yes', 'Yes', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
