-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 11 Juin 2014 à 17:00
-- Version du serveur: 5.1.73
-- Version de PHP: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `carolinepirlot_tfejuin`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires_events`
--

CREATE TABLE IF NOT EXISTS `commentaires_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contenu` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `commentaires_events`
--

INSERT INTO `commentaires_events` (`id`, `pseudo`, `contenu`, `event_id`, `membre_id`) VALUES
(7, 'Valentin', 'Un prÃ©fÃ©rence pour les chip''s peut-Ãªtre ?', 5, 31);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires_jeux`
--

CREATE TABLE IF NOT EXISTS `commentaires_jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contenu` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jeu_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `commentaires_jeux`
--

INSERT INTO `commentaires_jeux` (`id`, `pseudo`, `contenu`, `jeu_id`, `membre_id`) VALUES
(9, 'Valentin', 'Super jeu', 28, 31),
(12, 'Valentin', 'Super jeu, facile Ã  prendre en main quelque soit l''Ã¢ge !', 26, 31),
(13, 'Laura', 'Semble enfantin au premier abord, mais mÃ©fiez-vous, il faut Ãªtre trÃ¨s futÃ© pour gagner !', 28, 33),
(14, 'kooka', 'pas mal', 24, 42);

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE IF NOT EXISTS `evenements` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `jeux` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heure` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nbre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `regles` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `infos` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `membre_id` int(11) NOT NULL,
  `pseudo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `evenements`
--

INSERT INTO `evenements` (`id_event`, `titre`, `jeux`, `ville`, `date`, `heure`, `nbre`, `regles`, `infos`, `membre_id`, `pseudo`) VALUES
(2, 'PitiÃ©, jouez avec moi !', 'Le Pendu', 'Bruxelles', '18 Juin 2014', '20.30', '5', 'Chacun compose un mot et chaque joueur doit deviner le mot de son adversaire. C''est le plus plus jeune joueur qui commence.\r\n\r\nSi le joueur annonce une mauvaise lettre, il commence Ã  dessiner son pendu.\r\n\r\nLes mots Ã  deviner doivent Ãªtre des noms de prÃ©sident, quel que soit le pays.', 'Des chips please ! Et des biÃ¨res, Ã§a sera plus convivial.\r\n\r\nSi vous connaissez des jeux dans ce style lÃ , n''hÃ©sitez surtout pas Ã  les proposer et Ã  les apporter pour les faire dÃ©couvrir.', 27, 'Caroline'),
(5, 'Jouer c''est bien, Ã  6, c''est mieux', 'Charmed - La Source', 'Bioul', '14 juin 2014', '14.00', '5', 'Le joueur le plus jeune dÃ©bute la partie, puis c''est au tour du joueur situÃ© Ã  sa gauche et ainsi de suite. A son tour de jeu, chaque joueur lance le dÃ© et avance du nombre de case indiquÃ©es.\r\n\r\nLes dÃ©placements se font toujours dans le sens des aiguilles d''une montre. Suivez le sens des flÃ¨ches sur le plateau de jeu. Lors du dÃ©placement, seule la case oÃ¹ l''on s''arrÃªte a une influence sur le jeu, les cases traversÃ©es n''ont pas d''incidence particuliÃ¨re.\r\n\r\nL''effet des cases sur lesquelles on arrive s''applique immÃ©diatement, sauf prÃ©cisions contraires.\r\n\r\nDeux personnages se trouvant sur la mÃªme case peuvent s''Ã©changer un Indice ou un pion "Magie" (Potion, Invocation, Pouvoir ou Sort).', 'L''Ã©vÃ©nement aurait lieu vers 14.00 dans le parc du petit village de Bioul, pas trÃ¨s loin de l''Ã©glise.\r\n\r\nSi vous souhaitez apporter d''autres jeux, n''hÃ©sitez surtout pas. Je suis particuliÃ¨rement fan des jeux basÃ©s sur des films ou des sÃ©ries.\r\n\r\nCe qui serait sympa, ce serait que chacun apporte un petit truc Ã  grignoter, plus c''est convivial, mieux c''est !', 27, 'Caroline'),
(10, 'Ne pas finir pendu !', 'Le Pendu', 'Nice', '20 Juillet 2014', '10.00', '5', 'Composez un mot de 8 lettres maximum ou moins sur le support et placez-le ensuite face Ã  vous.\r\n\r\nC''est le plus jeune joueur qui dÃ©bute la partie. Vous annoncez une lettre que vous pensez faire partie du mot de votre adversaire. \r\n\r\nSi la lettre que vous annoncez fait partie du mot de votre adversaire, celui-ci retourne la lettre correspondante sur le support de faÃ§on Ã  ce que vous puissiez la voir. Votre tour est terminÃ©.\r\n\r\nSi la lettre que vous annoncez ne figure pas dans le mot de votre adversaire, votre tour est terminÃ©. Votre adversaire fait tourner son cadran d''un cran, dans le sens inverse des aiguilles d''une montre, pour faire apparaÃ®tre la premiÃ¨re figurine du Pendu.', 'Pour le lieu exact, je propose tout simplement la plage ! Le soleil, il n''y a rien de mieux. Pensez donc Ã  prendre vos serviettes et votre maillot, au cas oÃ¹ l''envie de vous baigner vous traverserait l''esprit.', 27, 'Valentin'),
(14, 'Boum', 'Monopoly', 'Namur', '16 septembre 2014', '19:00', '6', 'c''est cool', 'Apportez des chips, du coco et des bonbons', 45, 'tibocvl'),
(16, 'Djenga folie !', 'Djenga', 'Namur', '18 juin 2014', '18h', '8', 'Aucune !', 'Chips au paprika et CuraÃ§ao', 50, 'Starsam');

-- --------------------------------------------------------

--
-- Structure de la table `evenements_inscrits`
--

CREATE TABLE IF NOT EXISTS `evenements_inscrits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Contenu de la table `evenements_inscrits`
--

INSERT INTO `evenements_inscrits` (`id`, `id_event`, `id_user`, `active`) VALUES
(9, 4, 31, 1),
(11, 2, 27, 0),
(12, 4, 27, 0),
(13, 6, 27, 0),
(14, 5, 31, 1),
(15, 5, 27, 0),
(17, 6, 33, 0),
(18, 5, 33, 0),
(19, 4, 33, 0),
(20, 2, 33, 1),
(21, 10, 27, 1),
(22, 2, 31, 1),
(23, 2, 39, 0),
(24, 12, 31, 1),
(25, 6, 31, 0),
(26, 13, 31, 1),
(27, 13, 43, 1),
(28, 10, 45, 1),
(29, 14, 42, 1),
(30, 5, 42, 0),
(31, 14, 46, 1),
(32, 10, 50, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE IF NOT EXISTS `jeux` (
  `id_jeu` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `visuel` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `duree` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auteur` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `editeur` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `illustrateur` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auteur_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `editeur_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `illustrateur_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sortie` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `regles` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invention` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `validation` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_jeu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`id_jeu`, `nom`, `visuel`, `duree`, `nombre`, `type`, `age`, `auteur`, `editeur`, `illustrateur`, `auteur_url`, `editeur_url`, `illustrateur_url`, `sortie`, `description`, `regles`, `invention`, `validation`) VALUES
(23, 'Rummikub', 'rummikub(1).jpg', 'Moins de 30 min', 'Minimum 2', 'StratÃ©gie', 'A partir de 6 ans', 'Ephraim Hertzano', 'Goliath', 'Non renseignÃ©', '#', '#', '#', 1995, 'Chaque jour, dans le monde entier, un nombre de plus en plus croissant de gens, dÃ©couvre Rummikub.\r\n\r\nRummikub est un jeu de stratÃ©gie et de chance qui vous captivera pendant des heures. La gamme Rummikub s''Ã©tend Ã Â  plusieurs variantes de base. C''est un jeu pour toute la famille, qui prÃ©sente vÃ©ritablement un stimulus intellectuel et un passe-temps agrÃ©able.', 'Chaque joueur reÃ§oit 14 plaques qu''il pose sur son support. Les autres plaques constituent la pioche.\r\n\r\nChaque joueur, Ã  tour de rÃ´le, doit rÃ©aliser de nouvelles combinaisons : suites de chiffres de mÃªme couleur ou sÃ©ries de chiffres identiques de couleur diffÃ©rente.\r\n\r\nLe joker est prÃ©cieux pour composer des sÃ©ries. Si un joueur a dÃ©posÃ© un joker, un autre joueur peut l''Ã©changer s''il a la plaque correspondante.\r\n\r\nLe premier joueur qui pose toutes ses plaques sur la table gagne la partie.', 'Les joueurs peuvent rÃ©aliser une nouvelle combinaison : une suite de chiffres composÃ©e de deux couleurs qui s''alternent.', 'oui'),
(24, 'Monopoly', 'monopoly(1).jpg', 'Plus de 60 min', 'Minimum 2', 'RÃ©flexion', 'A partir de 8 ans', 'Parker Brothers', 'Hasbro', 'Non renseignÃ©', '#', '#', '#', 1996, 'Il devient difficile de trouver quelqu''un qui ne connaisse pas le Monopoly. En effet, des millions de familles ÃƒÂ  travers le monde y ont jouÃ©. Pourquoi ?\r\n\r\nParce que chacun rÃªve de ressentir, ne serait-ce que pour un moment, la satisfaction produite par le fait d''Ãªtre propriÃ©taire de la rue Neuve.\r\n\r\nEssayez, en utilisant avec sagesse l''argent qui vous est donnÃ© en dÃ©but de partie et en prenant les bonnes dÃ©cisions, d''accumuler autant de propriÃ©tÃ©s que possible. Si vous n''avez pas de chance, vous pouvez toujours hypothÃ©quer... ou nÃ©gocier une affaire avec l''un des autres joueurs.\r\n\r\nLe gagnant sera celui qui possÃ©dera tellement de propriÃ©tÃ©s et d''argent, qu''aucun de ses adversaires n''aura plus la moindre chance. Richesse, sens des affaires et chance font partie de ce jeu de sociÃ©tÃ© unique appelÃ© Monopoly.', 'En partant de la case DÃ©part, dÃ©placez votre pion sur le plateau de jeu suivant votre rÃ©sultat au lancÃ© de dÃ©s. Quand vous arrivez sur une case qui n''appartient encore Ã  personne, vous pouvez l''acheter Ã  la Banque. Si vous dÃ©cidez de ne pas l''acheter, la propriÃ©tÃ© sera proposÃ©e aux autres joueurs dans une vente aux enchÃ¨res et reviendra au plus offrant.\r\n\r\nLes joueurs qui sont propriÃ©taires perÃ§oivent des loyers de la part de leurs adversaires s''arrÃªtant sur leur terrain. La construction de Maisons et HÃ´tels augmente considÃ©rablement le loyer que vous pouvez recevoir pour vos propriÃ©tÃ©s ; aussi, il est conseillÃ© de construire dans un maximum de sites.\r\n\r\nSi vous avez besoin d''avantage d''argent, la Banque peut vous en prÃªter par la biais d''hypothÃ¨ques sur vos propriÃ©tÃ©s. Vous devez toujours vous plier aux instructions donnÃ©es par les cartes Caisse de CommunautÃ© et Chance. Parfois, vous serez envoyÃ© en prison.', 'Avant de commencer la partie, convenez d''une heure limite pour la fin du jeu. Le joueur le plus riche Ã  l''heure convenue est le vainqueur.\r\n\r\nAu dÃ©but de la partie, les Cartes de PropriÃ©tÃ© sont mÃ©langÃ©es et coupÃ©es, et le Banquier donne deux cartes Ã  chaque joueur. Les joueurs payent aussitÃ´t Ã  la Banque le prix de ces propriÃ©tÃ©s et le jeu continue normalement.', 'oui'),
(25, 'Charmed - La Source', 'charmed_source(1).jpg', 'Plus de 60 min', 'Minimum 2', 'CoopÃ©ration', 'A partir de 10 ans', 'TILSIT Team', 'TILSIT Editions', 'TILSIT Studio', '#', '#', '#', 2003, 'La Source est un jeu reprenant les hÃ©ros et les thÃ¨mes des derniÃ¨res saisons de la sÃ©rie tÃ©lÃ©visÃ©e Charmed. Vous en incarnez les personnages principaux, Piper, Phoebe, Paige et Cole dans leur lutte acharnÃ©e contre la Source.\r\n\r\nA vous de dÃ©voiler l''identitÃ© des lieutenants de la Source et de les Ã©liminer avant de pouvoir atteindre le maÃ®tre du mal !\r\n\r\nMais attention, il vous faudra faire vite si vous ne voulez pas que la Source trouve un moyen de contourner le Pouvoir des 3 et ne remporte la partie !', 'Le joueur le plus jeune dÃ©bute la partie, puis c''est au tour du joueur situÃ© Ã  sa gauche et ainsi de suite. A son tour de jeu, chaque joueur lance le dÃ© et avance du nombre de case indiquÃ©es.\r\n\r\nLes dÃ©placements se font toujours dans le sens des aiguilles d''une montre. Suivez le sens des flÃ¨ches sur le plateau de jeu. Lors du dÃ©placement, seule la case oÃ¹ l''on s''arrÃªte a une influence sur le jeu, les cases traversÃ©es n''ont pas d''incidence particuliÃ¨re.\r\n\r\nL''effet des cases sur lesquelles on arrive s''applique immÃ©diatement, sauf prÃ©cisions contraires.\r\n\r\nDeux personnages se trouvant sur la mÃªme case peuvent s''Ã©changer un Indice ou un pion "Magie" (Potion, Invocation, Pouvoir ou Sort).', 'Deux joueurs sont tirÃ©s au sort. Ces deux lÃ  ne peuvent pas s''entraider et s''Ã©changer des pions ou des indices.', 'oui'),
(26, 'Complots', 'complots(1).jpg', 'Moins de 30 min', 'Minimum 2', 'RÃ©flexion', 'A partir de 8 ans', 'Rikki Tahta', 'Ferti', 'NaÃ¯ade', '#', '#', '#', 2013, 'Il ne doit en rester qu''un !\r\n\r\nUne ville corrompue, soumise aux vices et avarices, est sous le contrÃ´le de vils personnages. Le pouvoir est vacant, Ã Â  vous de vous en emparer.\r\n\r\nVous disposez en secret de l''aide de deux personnages et par la ruse, la manipulation et le bluff, vous n''aurez qu''une obsession : Ã©liminer tous les autres de votre chemin.\r\n\r\nA votre tour vous pourrez user du pouvoir d''un des 6 personnages pour espionner, soudoyer, prendre ou voler de l''argent et assassiner vos adversaires... Si personne ne remet en doute votre parole, vous pourrez effectuer librement votre action, sinon un duel de bluff s''engagera et un seul sortira vivant !\r\n\r\nSerez-vous le dernier ?', 'On joue toujours dans le sens horaire. A son tour, un joueur doit choisir une Action parmi quatre possibles (il ne peut jamais passer son tour).\r\n\r\nAprÃ¨s avoir choisi son Action, les autres joueurs peuvent le mettre en doute ou le contrer.\r\n\r\nLes diffÃ©rentes actions sont : le revenu, l''aide Ã©trangÃ¨re, l''assassinat et l''utilisation du pouvoir d''un des 5 personnages.\r\n\r\nSi les adversaires ne remettent pas en doute la parole du joueur, celui-ci peut effectuer librement son action. Et ainsi de suite.', 'Les joueurs piochent au hasard un des personnages et suppriment tous ses pouvoirs.', 'oui'),
(27, 'Le Pendu', 'pendu(1).jpg', 'Moins de 30 min', 'Minimum 2', 'RÃ©flexion', 'A partir de 8 ans', 'Non renseignÃ©', 'Hasbro', 'Non renseignÃ©', '#', '#', '#', 1997, 'Le classique des jeux de lettres.\r\n\r\nQui sera le premier Ã Â  Ãªtre Pendu ? Vous ou votre adversaire ? Plus vite vous trouvez les lettres qui font partie du mot de votre adversaire, plus vous avez des chances de gagner.\r\n\r\nLorsque vous pensez avoir trouvÃ© le mot de votre adversaire, faites une proposition. Attention - une proposition incorrecte vous fera faire un pas de plus vers la potence.', 'Composez un mot de 8 lettres maximum ou moins sur le support et placez-le ensuite face Ã  vous.\r\n\r\nC''est le plus jeune joueur qui dÃ©bute la partie. Vous annoncez une lettre que vous pensez faire partie du mot de votre adversaire. \r\n\r\nSi la lettre que vous annoncez fait partie du mot de votre adversaire, celui-ci retourne la lettre correspondante sur le support de faÃ§on Ã  ce que vous puissiez la voir. Votre tour est terminÃ©.\r\n\r\nSi la lettre que vous annoncez ne figure pas dans le mot de votre adversaire, votre tour est terminÃ©. Votre adversaire fait tourner son cadran d''un cran, dans le sens inverse des aiguilles d''une montre, pour faire apparaÃ®tre la premiÃ¨re figurine du Pendu.\r\n\r\nLa suite du jeu se dÃ©roule de la mÃªme faÃ§on. Pour gagner une partie vous devez trouver le mot de votre adversaire avant qu''il ne trouve le vÃ´tre ou bien votre adversaire doit se tromper en annonÃ§ant votre mot.', 'Lorsque votre mot contient plusieurs fois la lettre indiquÃ©e, vous pouvez n''en dÃ©voiler qu''une Ã  chaque tour.\r\n\r\nLes joueurs peuvent convenir d''utiliser des noms propres, de personnes, des abrÃ©viations, des mots Ã©trangers, ...', 'oui'),
(28, 'Le poker des cafards', 'poker-cafards(1).jpg', 'Moins de 30 min', 'Minimum 2', 'StratÃ©gie', 'A partir de 8 ans', 'Jacques Zeimet', 'Drei Magier Spiele', 'Rolf Vogt', '#', '#', '#', 2010, 'Un jeu qui ne vous donnera pas le cafard !\r\n\r\nLes cartes reprÃ©sentent diffÃ©rentes bestioles trÃ¨s sympathiques (chauve-souris, cafard, scorpion, ...). Un joueur pose une carte devant lui, face cachÃ©e, et annonce un animal Ã Â  l''adversaire de son choix. Celui-ci va alors devoir dÃ©cider s''il pense que le joueur lui ment ou pas. S''il est perspicace, le joueur qui a prÃ©sentÃ© la carte reprend et la dÃ©pose face visible devant lui ; mais s''il se trompe, c''est lui qui la prend ! Il est aussi possible de repasser le dilemme Ã Â  un autre joueur... Le premier Ã  se retrouver avec 4 animaux de la mÃªme espÃ¨ce a perdu.\r\n\r\nLes clefs du jeu : observation, stratÃ©gie et... bluff !', 'Il faut mÃ©langer les 64 cartes et les distribuer entre les joueurs. \r\n\r\nLe plus jeune commence et choisit une de ses cartes qu''il pose face cachÃ©e et la propose au joueur de son choix en lui annonÃ§ant le nom d''une bestiole. Le joueur Ã  qui la carte est proposÃ©e a alors 2 options :\r\n\r\n- soit accepter la carte : il annonce "vrai" s''il pense que la carte annoncÃ©e correspond rÃ©ellement Ã  Ã§a, ou bien "faux" s''il pense le contraire. Si sa rÃ©ponse est la bonne, le joueur qui a proposÃ© la carte doit la garder devant lui face visible. S''il s''est trompÃ©, c''est lui qui doit la garder de la mÃªme faÃ§on.\r\n\r\n- soit repasser la carte : il dÃ©cide de la repasser Ã  un tiers. Dans ce cas, il regarde secrÃ¨tement la carte et confirme ou non l''annonce du premier joueur. La suite se passe comme dans la premiÃ¨re solution.\r\n\r\nEt ainsi de suite. La partie est terminÃ©e lorsqu''un des joueurs a accumulÃ© 4 cartes reprÃ©sentant la mÃªme bestiole. Dans ce cas ce joueur perd la partie et tous les autres gagnent.', 'Un joueur doit accumuler deux sÃ©ries diffÃ©rentes pour pouvoir gagner.', 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `jeux_attente`
--

CREATE TABLE IF NOT EXISTS `jeux_attente` (
  `id_jeu` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visuel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `duree` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auteur` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `editeur` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `illustrateur` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auteur_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `editeur_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `illustrateur_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sortie` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `regles` text COLLATE utf8_unicode_ci NOT NULL,
  `invention` text COLLATE utf8_unicode_ci NOT NULL,
  `validation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id_jeu` (`id_jeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `jeux_attente`
--


-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prefereUn` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prefereDeux` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prefereTrois` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `email`, `mdp`, `avatar`, `prefereUn`, `prefereDeux`, `prefereTrois`, `role`) VALUES
(27, 'Caroline', 'pirlot.caroline4@gmail.com', 'tfebeta', 'antoine(1).jpg', 'Halli Galli', 'Assassin X', 'Stratego', 'administrateur'),
(28, 'Jonathan', 'jonathan@gmail.com', 'jonathan', '', 'Halli Galli', '', '', 'utilisateur'),
(30, 'Benoit', 'benoit@gmail.com', 'benoit', '', '', '', '', 'utilisateur'),
(31, 'Valentin', 'valentin@gmail.com', 'valentin', '', 'Stratego', '', '', 'utilisateur'),
(32, 'noisette', 'noisette@gmail.com', 'noisette', '', '', '', '', 'utilisateur'),
(33, 'Laura', 'laura@gmail.com', 'laura', 'Toscaaaa(1).jpg', 'Halli Galli', 'Stratego', 'Monopoly', 'utilisateur'),
(34, 'Laurent', 'laurent@gmail.com', 'laurent', '', '', '', '', 'utilisateur'),
(35, 'Adrien', 'adrien@gmail.com', 'adrien', '', '', '', '', 'utilisateur'),
(36, 'Fofie', 'anne_sophie@gmail.com', 'fofie', '', '', '', '', 'utilisateur'),
(37, 'jean', 'jean@jean.de', 'jean', '', '', '', '', 'utilisateur'),
(39, 'Pokemon', 'pokemon@gmail.com', 'pokemon', '', '', '', '', 'utilisateur'),
(40, 'bla', 'bla@bloblo.be', 'rtbf', '', '', '', '', 'utilisateur'),
(41, 'Beta', 'beta@beta.be', 'beta', '', '', '', '', 'utilisateur'),
(42, 'kooka', 'lekooka@gmail.com', 'kedis', '', '', '', '', 'utilisateur'),
(43, 'julien', 'julien@gmail.com', 'julie', '', '', '', '', 'utilisateur'),
(44, 'paulinelgg', 'paulinelagage@gmail.com', 'whouwhou', '', '', '', '', 'utilisateur'),
(45, 'tibocvl', 'thibaud.cuvelier@gmail.com', 'dwmdwm', '', '', '', '', 'utilisateur'),
(46, 'benpir', 'pirlot.benoit@hotmail.com', 'tosca1be', '', '', '', '', 'utilisateur'),
(47, 'benpir', 'pirlot.benoit@hotmail.com', 'tosca1be', '', '', '', '', 'utilisateur'),
(48, 'Amandine', 'amandine@gmail.com', 'amandine', '', '', '', '', 'utilisateur'),
(49, 'Mamboleoo', 'mamboo@live.be', 'heaj', '', '', '', '', 'utilisateur'),
(50, 'Starsam', 'cobaydyo@gmail.com', 'lolilolu', 'Capture_d___cran_2014-03-03_20.28.12(1).png', 'Djenga', 'Risk', 'Dr Maboul', 'utilisateur');
