-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 28 juin 2023 à 11:35
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

--
-- Déchargement des données de la table `attribution_groupe`
--

INSERT INTO `attribution_groupe` (`ID_groupe`, `ID_athlete`) VALUES
(123, 1);

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
  `statut_seance` enum('a faire','fait','non fait') NOT NULL,
  `ID_attribution_seance` int NOT NULL,
  `RessentitSeance` int NOT NULL,
  PRIMARY KEY (`ID_attribution_seance`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `attribution_seance`
--

INSERT INTO `attribution_seance` (`ID_seance`, `ID_user`, `ID_groupe`, `date`, `ID_coach`, `statut_seance`, `ID_attribution_seance`, `RessentitSeance`) VALUES
(123183, 1, 123, '2023-06-30', 2, 'fait', 1, 4),
(12318366, 1, 123, '2023-06-27', 2, 'fait', 2, 1),
(1231836, 1, 123, '2023-06-30', 2, 'non fait', 3, 3);

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
(123183, 1, 1, 15, 0),
(123183, 4, 2, 0, 28),
(123183, 1, 3, 15, 0),
(12318366, 4, 1, 28, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`nom`, `ID_exo`, `description`, `media`, `ID_coach`, `configurateur`) VALUES
('abdo', 1, 'description abdo', 'media abdo', 12, 'duree'),
('pompe', 4, 'descriptions pompe', 'media pompe', 12, 'quantite'),
('pause', 5, 'pause de x sec', 'Attend juste', 12, 'duree');

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
  `nom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` enum('cardio','renforcement','endurance') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `duree` int NOT NULL,
  `difficulte` enum('débutant','intermédiaire','confirmé') NOT NULL,
  PRIMARY KEY (`ID_seance`)
) ENGINE=MyISAM AUTO_INCREMENT=12318367 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`ID_seance`, `nom`, `type`, `description`, `duree`, `difficulte`) VALUES
(123183, 'Noms1', 'renforcement', 'Teste pour les devs', 15, 'intermédiaire'),
(12318366, 'NomS2', 'renforcement', 'Teste pour les devs', 15, 'intermédiaire');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pseudo`, `password`, `ID_user`, `role`) VALUES
('athtest1', '0000', 1, 'athlète'),
('coache1', '0000', 2, 'coach'),
('mat', 'mad', 3, 'athlète'),
('matC', 'mad', 4, 'coach');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
