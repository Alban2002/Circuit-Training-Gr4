-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 23 juin 2023 à 14:59
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
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
