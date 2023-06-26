-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 26 juin 2023 à 07:21
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `grp4_circuit_training`
--

-- --------------------------------------------------------

--
-- Structure de la table `attribution_groupe`
--

DROP TABLE IF EXISTS `attribution_groupe`;
CREATE TABLE IF NOT EXISTS `attribution_groupe` (
  `ID_groupe` int NOT NULL,
  `ID_athlete` int NOT NULL,
  UNIQUE KEY `ID_groupe` (`ID_groupe`,`ID_athlete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `attribution_seance`
--

DROP TABLE IF EXISTS `attribution_seance`;
CREATE TABLE IF NOT EXISTS `attribution_seance` (
  `ID_seance` int NOT NULL,
  `ID_user` int NOT NULL,
  `ID_groupe` int NOT NULL,
  `date` date DEFAULT NULL,
  `ID_coach` int NOT NULL,
  `statut_seance` enum('a faire','fait','non fait') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `attribution_seance`
--

INSERT INTO `attribution_seance` (`ID_seance`, `ID_user`, `ID_groupe`, `date`, `ID_coach`, `statut_seance`) VALUES
(1, 2, 0, '2023-06-24', 2, 'a faire');

-- --------------------------------------------------------

--
-- Structure de la table `contenu_seance`
--

DROP TABLE IF EXISTS `contenu_seance`;
CREATE TABLE IF NOT EXISTS `contenu_seance` (
  `ID_seance` int NOT NULL,
  `ID_exo` int NOT NULL,
  `rang_exo` int NOT NULL,
  `duree` int NOT NULL,
  `quantite` int NOT NULL,
  UNIQUE KEY `rel_seance_exo` (`ID_seance`,`rang_exo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenu_seance`
--

INSERT INTO `contenu_seance` (`ID_seance`, `ID_exo`, `rang_exo`, `duree`, `quantite`) VALUES
(1, 1, 1, 0, 5),
(1, 1, 2, 0, 10),
(1, 1, 3, 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

DROP TABLE IF EXISTS `exercices`;
CREATE TABLE IF NOT EXISTS `exercices` (
  `nom` text NOT NULL,
  `ID_exo` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `media` text NOT NULL,
  `ID_coach` int NOT NULL,
  `configurateur` enum('duree','quantite') NOT NULL,
  PRIMARY KEY (`ID_exo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`nom`, `ID_exo`, `description`, `media`, `ID_coach`, `configurateur`) VALUES
('push-up', 1, 'pompe classique', '', 0, 'quantite');

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

DROP TABLE IF EXISTS `groupes`;
CREATE TABLE IF NOT EXISTS `groupes` (
  `ID_groupe` int NOT NULL AUTO_INCREMENT,
  `ID_coach` int NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`ID_groupe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
  `ID_seance` int NOT NULL AUTO_INCREMENT,
  `type` enum('cardio','renforcement','endurance') NOT NULL,
  `description` text NOT NULL,
  `duree` int NOT NULL,
  `difficulte` enum('débutant','intermédiaire','confirmé') NOT NULL,
  PRIMARY KEY (`ID_seance`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`ID_seance`, `type`, `description`, `duree`, `difficulte`) VALUES
(1, 'renforcement', 'full pompe', 5, 'débutant');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pseudo` text NOT NULL,
  `password` text NOT NULL,
  `ID_user` int NOT NULL AUTO_INCREMENT,
  `role` enum('athlète','coach','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_user`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pseudo`, `password`, `ID_user`, `role`) VALUES
('matthieuA', 'madelaine', 2, 'athlète'),
('matthieuC', 'madelaine', 3, 'coach');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_seance_detaillee`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_seance_detaillee`;
CREATE TABLE IF NOT EXISTS `vue_seance_detaillee` (
`ID_exo` int
,`nom` text
,`description` text
,`media` text
,`ID_coach` int
,`configurateur` enum('duree','quantite')
,`ID_seance` int
,`rang_exo` int
,`duree` int
,`quantite` int
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_seance_detaillee`
--
DROP TABLE IF EXISTS `vue_seance_detaillee`;

DROP VIEW IF EXISTS `vue_seance_detaillee`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_seance_detaillee`  AS SELECT `ex`.`ID_exo` AS `ID_exo`, `ex`.`nom` AS `nom`, `ex`.`description` AS `description`, `ex`.`media` AS `media`, `ex`.`ID_coach` AS `ID_coach`, `ex`.`configurateur` AS `configurateur`, `cs`.`ID_seance` AS `ID_seance`, `cs`.`rang_exo` AS `rang_exo`, `cs`.`duree` AS `duree`, `cs`.`quantite` AS `quantite` FROM (`exercices` `ex` join `contenu_seance` `cs` on((`ex`.`ID_exo` = `cs`.`ID_exo`)))  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
