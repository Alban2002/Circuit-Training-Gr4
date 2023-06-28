-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 28 juin 2023 à 09:23
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
