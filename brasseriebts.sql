-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 11 mai 2025 à 16:48
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `brasseriebts`
--

-- --------------------------------------------------------

--
-- Structure de la table `alcools`
--

DROP TABLE IF EXISTS `alcools`;
CREATE TABLE IF NOT EXISTS `alcools` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_alcool` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `alcools`
--

INSERT INTO `alcools` (`id`, `nom_alcool`) VALUES
(1, 'Whisky'),
(2, 'Vodka'),
(3, 'Rhum'),
(4, 'Tequila'),
(5, 'Gin'),
(6, 'Bière'),
(7, 'Vin Rouge'),
(8, 'Vin Blanc'),
(9, 'Cognac'),
(10, 'Absinthe');

-- --------------------------------------------------------

--
-- Structure de la table `boisson`
--

DROP TABLE IF EXISTS `boisson`;
CREATE TABLE IF NOT EXISTS `boisson` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_alcool_id` int DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_production` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B97C84DE8E51F93` (`num_alcool_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `boisson`
--

INSERT INTO `boisson` (`id`, `num_alcool_id`, `nom`, `logo`, `date_production`, `prix`) VALUES
(3, 4, 'Chimay_Bleue', 'chimay.png', '0000-00-00', 10),
(4, 4, 'Tsingtao', 'Tsingtao.png', '0000-00-00', 7),
(5, 4, 'Rochefort 8', 'Rochefort 8.png', '0000-00-00', 12),
(6, 4, 'Westmalle Tripel', 'Westmalle Tripel.png', '0000-00-00', 10),
(7, 4, 'La Chouffe', 'La Chouffe.png', '0000-00-00', 8),
(8, 4, 'Tripel Karmeliet', 'Tripel Karmeliet.png', '0000-00-00', 7),
(9, 4, 'Delirium Tremens', 'Delirium Tremens.png', '0000-00-00', 12),
(10, 4, 'Kwak', 'Kwak.png', '0000-00-00', 10),
(11, 4, 'Chateau Latour', 'Château Latour.png', '0000-00-00', 27),
(12, 4, 'Castello di Monsanto', 'Castello di Monsanto.png\r\n', '0000-00-00', 26),
(13, 4, 'Domaine Marcel Lapierre', 'Domaine Marcel Lapierre.png', '0000-00-00', 15),
(14, 4, 'Domaine Berthoumieu', 'Domaine Berthoumieu.png', '0000-00-00', 32),
(15, 4, 'Opus One', 'Opus One.png', '0000-00-00', 26),
(16, 4, 'Laphroaig 10 ans', 'Laphroaig 10 ans.png', '0000-00-00', 67),
(17, 4, 'Buffalo Trace', 'Buffalo Trace.png', '0000-00-00', 78),
(18, 4, 'Glenmorangie Original', 'Glenmorangie.png', '0000-00-00', 88),
(19, 4, 'Nikka Coffey Malt', 'Nikka Coffey Malt.png', '0000-00-00', 67),
(20, 4, 'Armagnac Delord 25 ans', 'Armagnac Delord 25 ans.png', '0000-00-00', 78),
(21, 4, 'Calvados Christian Drouin', 'Calvados Christian Drouin.png', '0000-00-00', 84),
(22, 4, 'Pastis 51', 'Pastis 51.png', '0000-00-00', 50),
(23, 4, 'Absinthe La Fée', 'Absinthe La Fée.png', '0000-00-00', 87),
(24, 4, 'Rhum Clément V.S.O.P', 'Rhum Clément.png', '0000-00-00', 74),
(25, 4, 'Rhum Damoiseau Vieux', 'Rhum Damoiseau Vieux.png', '0000-00-00', 88),
(26, 4, 'Poire Williams Massenez', 'Poire Williams Massenez.png', '0000-00-00', 79),
(27, 4, 'Chartreuse Verte', 'Chartreuse Verte.png', '0000-00-00', 51),
(28, 4, 'Génépi', 'Génépi.png', '0000-00-00', 83),
(29, 4, 'Mirabelle de Lorraine', 'Mirabelle.png', '0000-00-00', 62),
(30, 4, 'Rhum Trois Rivières', 'Rhum Trois Rivières.png', '0000-00-00', 85),
(31, 4, 'Rhum Montebello', 'Rhum Montebello.png', '0000-00-00', 45);

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_role_id` int DEFAULT NULL,
  `identifiant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5673580113003845` (`num_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `email`, `num_role_id`, `identifiant`, `mot_de_passe`, `num_tel`) VALUES
(1, 'admin@admin.com', 1, 'admin', 'admin', '12345678'),
(2, 'agogoth@gmail.com', 2, 'alice', 'yana', '0677383136'),
(3, 'khumetz@gmail.com', 2, 'aa', '456789', '78965412');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250413093341', '2025-04-13 09:33:45', 141),
('DoctrineMigrations\\Version20250413141333', '2025-04-13 14:13:53', 300),
('DoctrineMigrations\\Version20250413211917', '2025-04-13 21:19:23', 94),
('DoctrineMigrations\\Version20250413212008', '2025-04-13 21:20:11', 21),
('DoctrineMigrations\\Version20250425124221', '2025-04-25 12:42:40', 143),
('DoctrineMigrations\\Version20250425124327', '2025-04-25 12:43:33', 241),
('DoctrineMigrations\\Version20250427084929', '2025-04-27 08:49:39', 253),
('DoctrineMigrations\\Version20250428141047', '2025-04-28 14:10:58', 175);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_compte_id` int DEFAULT NULL,
  `quantitép` int NOT NULL,
  `creation_panier` date NOT NULL,
  `num_produit_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_24CC0DF2801B12FC` (`num_compte_id`),
  KEY `IDX_24CC0DF280233E70` (`num_produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `num_compte_id`, `quantitép`, `creation_panier`, `num_produit_id`) VALUES
(15, 1, 4, '2025-05-06', 15),
(16, 1, 10, '2025-05-08', 3),
(17, 1, 1, '2025-05-08', 3),
(18, 1, 1, '2025-05-08', 25),
(19, 1, 1, '2025-05-08', 24),
(20, 1, 1, '2025-05-08', 24),
(21, 1, 1, '2025-05-08', 24),
(22, 1, 1, '2025-05-11', 3),
(23, 1, 1, '2025-05-11', 3),
(24, 1, 1, '2025-05-11', 3),
(25, 3, 1, '2025-05-11', 4),
(26, 3, 1, '2025-05-11', 4),
(27, 1, 4, '2025-05-11', 5),
(28, 3, 3, '2025-05-11', 5);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_boisson_id` int DEFAULT NULL,
  `quantité` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_56F79805FC5CC002` (`num_boisson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `num_boisson_id`, `quantité`) VALUES
(3, 3, 13),
(4, 4, 15),
(5, 5, 12),
(6, 6, 8),
(7, 7, 20),
(8, 8, 14),
(9, 9, 18),
(10, 10, 5),
(11, 11, 9),
(12, 12, 16),
(13, 13, 13),
(14, 14, 7),
(15, 15, 11),
(16, 16, 6),
(17, 17, 4),
(18, 18, 17),
(19, 19, 3),
(20, 20, 19),
(21, 21, 2),
(22, 22, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `boisson`
--
ALTER TABLE `boisson`
  ADD CONSTRAINT `FK_8B97C84DE8E51F93` FOREIGN KEY (`num_alcool_id`) REFERENCES `alcools` (`id`);

--
-- Contraintes pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD CONSTRAINT `FK_5673580113003845` FOREIGN KEY (`num_role_id`) REFERENCES `role` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF2801B12FC` FOREIGN KEY (`num_compte_id`) REFERENCES `comptes` (`id`),
  ADD CONSTRAINT `FK_24CC0DF280233E70` FOREIGN KEY (`num_produit_id`) REFERENCES `boisson` (`id`);

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `FK_56F79805FC5CC002` FOREIGN KEY (`num_boisson_id`) REFERENCES `boisson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
