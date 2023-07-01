-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 30 juin 2023 à 08:36
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
                                                                 (1, 3),
                                                                 (2, 1),
                                                                 (2, 3),
                                                                 (3, 3);

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
                                                    `statut_seance` enum('a faire','fait','non fait') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'a faire',
    `ID_attribution_seance` int NOT NULL AUTO_INCREMENT,
    `RessentitSeance` int DEFAULT '0',
    PRIMARY KEY (`ID_attribution_seance`)
    ) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `attribution_seance`
--

INSERT INTO `attribution_seance` (`ID_seance`, `ID_user`, `ID_groupe`, `date`, `ID_coach`, `statut_seance`, `ID_attribution_seance`, `RessentitSeance`) VALUES
                                                                                                                                                            (12318378, 0, 2, '2023-02-09', 0, 'fait', 8, 1),
                                                                                                                                                            (12318377, 0, 2, '2023-01-21', 0, 'fait', 7, 2),
                                                                                                                                                            (12318377, 0, 2, '2023-01-19', 0, 'non fait', 6, 4),
                                                                                                                                                            (12318378, 0, 2, '2023-03-15', 0, 'fait', 9, 5),
                                                                                                                                                            (12318377, 0, 2, '2023-03-25', 0, 'fait', 10, 0),
                                                                                                                                                            (12318377, 0, 2, '2023-04-12', 0, 'fait', 11, 2),
                                                                                                                                                            (12318377, 0, 2, '2023-05-23', 0, 'fait', 12, 0),
                                                                                                                                                            (12318378, 0, 2, '2023-05-19', 0, 'fait', 13, 5),
                                                                                                                                                            (12318378, 0, 2, '2023-06-14', 0, 'fait', 14, 3),
                                                                                                                                                            (12318378, 0, 2, '2023-06-18', 0, 'non fait', 15, 0),
                                                                                                                                                            (12318377, 0, 2, '2023-06-27', 0, 'fait', 16, 4),
                                                                                                                                                            (12318377, 0, 2, '2023-07-11', 0, 'a faire', 17, 0),
                                                                                                                                                            (12318378, 0, 2, '2023-06-14', 0, 'fait', 18, 3),
                                                                                                                                                            (12318380, 0, 3, '2023-06-01', 0, 'fait', 19, 5);

-- --------------------------------------------------------

--
-- Structure de la table `contenu_seance`
--

DROP TABLE IF EXISTS `contenu_seance`;
CREATE TABLE IF NOT EXISTS `contenu_seance` (
                                                `ID_seance` int NOT NULL,
                                                `ID_exo` int NOT NULL,
                                                `rang_exo` int NOT NULL,
                                                `duree` int DEFAULT NULL,
                                                `quantite` int DEFAULT NULL,
                                                UNIQUE KEY `rel_seance_exo` (`ID_seance`,`rang_exo`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenu_seance`
--

INSERT INTO `contenu_seance` (`ID_seance`, `ID_exo`, `rang_exo`, `duree`, `quantite`) VALUES
                                                                                          (12318380, 8, 2, 5, NULL),
                                                                                          (12318380, 9, 1, 3, NULL),
                                                                                          (12318379, 6, 3, NULL, 10),
                                                                                          (12318379, 8, 2, 25, NULL),
                                                                                          (12318379, 6, 1, NULL, 25),
                                                                                          (12318378, 6, 3, NULL, 100),
                                                                                          (12318378, 8, 2, 5, NULL),
                                                                                          (12318378, 7, 1, NULL, 150),
                                                                                          (12318377, 6, 3, NULL, 30),
                                                                                          (12318377, 8, 2, 5, NULL),
                                                                                          (12318377, 7, 1, NULL, 25),
                                                                                          (12318380, 6, 3, NULL, 25);

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
    ) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`nom`, `ID_exo`, `description`, `media`, `ID_coach`, `configurateur`) VALUES
                                                                                                   ('gainage', 9, 'gainage', 'uploads/4a41d.jpg', 7, 'duree'),
                                                                                                   ('pompe classique', 6, 'pompe classique, écartement des mains un peu plus large que les épaules', 'uploads/OIP.jpeg', 4, 'quantite'),
                                                                                                   ('abdo classique', 7, 'abdo classique, sur le dos, pied au sol, se relever', 'uploads/OIP (1).jpeg', 4, 'quantite'),
                                                                                                   ('pause', 8, 'Repos', 'uploads/OIP (2).jpeg', 4, 'duree');

--
-- Déclencheurs `exercices`
--
DROP TRIGGER IF EXISTS `suppression_exercice`;
DELIMITER $$
CREATE TRIGGER `suppression_exercice` AFTER DELETE ON `exercices` FOR EACH ROW BEGIN
    DELETE FROM contenu_seance WHERE ID_exo = OLD.ID_exo;
END
    $$
DELIMITER ;

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
    ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`ID_groupe`, `ID_coach`, `description`) VALUES
                                                                   (1, 2, 'Coach Lily groupe'),
                                                                   (2, 4, 'Coach Hervé groupe'),
                                                                   (3, 7, 'coach test');

--
-- Déclencheurs `groupes`
--
DROP TRIGGER IF EXISTS `suppression_groupe`;
DELIMITER $$
CREATE TRIGGER `suppression_groupe` AFTER DELETE ON `groupes` FOR EACH ROW BEGIN
    DELETE FROM attribution_groupe WHERE ID_groupe = OLD.ID_groupe;
END
    $$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
                                        `ID_seance` int NOT NULL AUTO_INCREMENT,
                                        `ID_coach` int NOT NULL,
                                        `nom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                                        `type` enum('cardio','renforcement','endurance') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `description` text NOT NULL,
    `duree` int NOT NULL,
    `difficulte` enum('débutant','intermédiaire','confirmé') NOT NULL,
    PRIMARY KEY (`ID_seance`)
    ) ENGINE=MyISAM AUTO_INCREMENT=12318381 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`ID_seance`, `ID_coach`, `nom`, `type`, `description`, `duree`, `difficulte`) VALUES
                                                                                                        (12318380, 7, 'test', 'cardio', 'huj', 25, 'intermédiaire'),
                                                                                                        (12318379, 4, 'séance3', 'renforcement', 'description', 25, ''),
                                                                                                        (12318378, 4, 'séance2', 'endurance', 'Deuxième séance', 30, ''),
                                                                                                        (12318377, 4, 'séance1', 'cardio', 'première séance', 20, 'intermédiaire');

--
-- Déclencheurs `seance`
--
DROP TRIGGER IF EXISTS `suppression_seance`;
DELIMITER $$
CREATE TRIGGER `suppression_seance` AFTER DELETE ON `seance` FOR EACH ROW BEGIN
    DELETE FROM contenu_seance WHERE ID_seance = OLD.ID_seance;
    DELETE FROM attribution_seance WHERE ID_seance = OLD.ID_seance;
END
    $$
DELIMITER ;

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
    ) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pseudo`, `password`, `ID_user`, `role`) VALUES
                                                                  ('athtest1', '0000', 1, 'athlète'),
                                                                  ('coach1', '0000', 2, 'coach'),
                                                                  ('mat', 'mad', 3, 'athlète'),
                                                                  ('matC', 'mad', 4, 'coach'),
                                                                  ('matC2', 'mad', 5, 'coach'),
                                                                  ('MatA', 'mad', 6, 'athlète'),
                                                                  ('matC3', 'mad', 7, 'coach');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 30 juin 2023 à 08:36
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
                                                                 (1, 3),
                                                                 (2, 1),
                                                                 (2, 3),
                                                                 (3, 3);

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
                                                    `statut_seance` enum('a faire','fait','non fait') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'a faire',
    `ID_attribution_seance` int NOT NULL AUTO_INCREMENT,
    `RessentitSeance` int DEFAULT '0',
    PRIMARY KEY (`ID_attribution_seance`)
    ) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `attribution_seance`
--

INSERT INTO `attribution_seance` (`ID_seance`, `ID_user`, `ID_groupe`, `date`, `ID_coach`, `statut_seance`, `ID_attribution_seance`, `RessentitSeance`) VALUES
                                                                                                                                                            (12318378, 0, 2, '2023-02-09', 0, 'fait', 8, 1),
                                                                                                                                                            (12318377, 0, 2, '2023-01-21', 0, 'fait', 7, 2),
                                                                                                                                                            (12318377, 0, 2, '2023-01-19', 0, 'non fait', 6, 4),
                                                                                                                                                            (12318378, 0, 2, '2023-03-15', 0, 'fait', 9, 5),
                                                                                                                                                            (12318377, 0, 2, '2023-03-25', 0, 'fait', 10, 0),
                                                                                                                                                            (12318377, 0, 2, '2023-04-12', 0, 'fait', 11, 2),
                                                                                                                                                            (12318377, 0, 2, '2023-05-23', 0, 'fait', 12, 0),
                                                                                                                                                            (12318378, 0, 2, '2023-05-19', 0, 'fait', 13, 5),
                                                                                                                                                            (12318378, 0, 2, '2023-06-14', 0, 'fait', 14, 3),
                                                                                                                                                            (12318378, 0, 2, '2023-06-18', 0, 'non fait', 15, 0),
                                                                                                                                                            (12318377, 0, 2, '2023-06-27', 0, 'fait', 16, 4),
                                                                                                                                                            (12318377, 0, 2, '2023-07-11', 0, 'a faire', 17, 0),
                                                                                                                                                            (12318378, 0, 2, '2023-07-14', 0, 'fait', 18, 3),
                                                                                                                                                            (12318380, 0, 3, '2023-07-01', 0, 'fait', 19, 5);

-- --------------------------------------------------------

--
-- Structure de la table `contenu_seance`
--

DROP TABLE IF EXISTS `contenu_seance`;
CREATE TABLE IF NOT EXISTS `contenu_seance` (
                                                `ID_seance` int NOT NULL,
                                                `ID_exo` int NOT NULL,
                                                `rang_exo` int NOT NULL,
                                                `duree` int DEFAULT NULL,
                                                `quantite` int DEFAULT NULL,
                                                UNIQUE KEY `rel_seance_exo` (`ID_seance`,`rang_exo`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenu_seance`
--

INSERT INTO `contenu_seance` (`ID_seance`, `ID_exo`, `rang_exo`, `duree`, `quantite`) VALUES
                                                                                          (12318380, 8, 2, 5, NULL),
                                                                                          (12318380, 9, 1, 3, NULL),
                                                                                          (12318379, 6, 3, NULL, 10),
                                                                                          (12318379, 8, 2, 25, NULL),
                                                                                          (12318379, 6, 1, NULL, 25),
                                                                                          (12318378, 6, 3, NULL, 100),
                                                                                          (12318378, 8, 2, 5, NULL),
                                                                                          (12318378, 7, 1, NULL, 150),
                                                                                          (12318377, 6, 3, NULL, 30),
                                                                                          (12318377, 8, 2, 5, NULL),
                                                                                          (12318377, 7, 1, NULL, 25),
                                                                                          (12318380, 6, 3, NULL, 25);

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
    ) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`nom`, `ID_exo`, `description`, `media`, `ID_coach`, `configurateur`) VALUES
                                                                                                   ('gainage', 9, 'gainage', 'uploads/4a41d.jpg', 7, 'duree'),
                                                                                                   ('pompe classique', 6, 'pompe classique, écartement des mains un peu plus large que les épaules', 'uploads/OIP.jpeg', 4, 'quantite'),
                                                                                                   ('abdo classique', 7, 'abdo classique, sur le dos, pied au sol, se relever', 'uploads/OIP (1).jpeg', 4, 'quantite'),
                                                                                                   ('pause', 8, 'Repos', 'uploads/OIP (2).jpeg', 4, 'duree');

--
-- Déclencheurs `exercices`
--
DROP TRIGGER IF EXISTS `suppression_exercice`;
DELIMITER $$
CREATE TRIGGER `suppression_exercice` AFTER DELETE ON `exercices` FOR EACH ROW BEGIN
    DELETE FROM contenu_seance WHERE ID_exo = OLD.ID_exo;
END
    $$
DELIMITER ;

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
    ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`ID_groupe`, `ID_coach`, `description`) VALUES
                                                                   (1, 2, 'Coach Lily groupe'),
                                                                   (2, 4, 'Coach Hervé groupe'),
                                                                   (3, 7, 'coach test');

--
-- Déclencheurs `groupes`
--
DROP TRIGGER IF EXISTS `suppression_groupe`;
DELIMITER $$
CREATE TRIGGER `suppression_groupe` AFTER DELETE ON `groupes` FOR EACH ROW BEGIN
    DELETE FROM attribution_groupe WHERE ID_groupe = OLD.ID_groupe;
END
    $$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

DROP TABLE IF EXISTS `seance`;
CREATE TABLE IF NOT EXISTS `seance` (
                                        `ID_seance` int NOT NULL AUTO_INCREMENT,
                                        `ID_coach` int NOT NULL,
                                        `nom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                                        `type` enum('cardio','renforcement','endurance') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `description` text NOT NULL,
    `duree` int NOT NULL,
    `difficulte` enum('débutant','intermédiaire','confirmé') NOT NULL,
    PRIMARY KEY (`ID_seance`)
    ) ENGINE=MyISAM AUTO_INCREMENT=12318381 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`ID_seance`, `ID_coach`, `nom`, `type`, `description`, `duree`, `difficulte`) VALUES
                                                                                                        (12318380, 7, 'test', 'cardio', 'huj', 25, 'intermédiaire'),
                                                                                                        (12318379, 4, 'séance3', 'renforcement', 'description', 25, ''),
                                                                                                        (12318378, 4, 'séance2', 'endurance', 'Deuxième séance', 30, ''),
                                                                                                        (12318377, 4, 'séance1', 'cardio', 'première séance', 20, 'intermédiaire');

--
-- Déclencheurs `seance`
--
DROP TRIGGER IF EXISTS `suppression_seance`;
DELIMITER $$
CREATE TRIGGER `suppression_seance` AFTER DELETE ON `seance` FOR EACH ROW BEGIN
    DELETE FROM contenu_seance WHERE ID_seance = OLD.ID_seance;
    DELETE FROM attribution_seance WHERE ID_seance = OLD.ID_seance;
END
    $$
DELIMITER ;

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
    ) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pseudo`, `password`, `ID_user`, `role`) VALUES
                                                                  ('athtest1', '0000', 1, 'athlète'),
                                                                  ('coach1', '0000', 2, 'coach'),
                                                                  ('mat', 'mad', 3, 'athlète'),
                                                                  ('matC', 'mad', 4, 'coach'),
                                                                  ('matC2', 'mad', 5, 'coach'),
                                                                  ('MatA', 'mad', 6, 'athlète'),
                                                                  ('matC3', 'mad', 7, 'coach');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
