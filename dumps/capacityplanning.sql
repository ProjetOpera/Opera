-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 20 Avril 2017 à 10:46
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `capacityplanning`
--
CREATE DATABASE IF NOT EXISTS `capacityplanning` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `capacityplanning`;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

DROP TABLE IF EXISTS `parametres`;
CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `Module_concerne` varchar(50) NOT NULL,
  `Seuil` int(11) NOT NULL,
  `Alerte` int(11) NOT NULL,
  `Label` varchar(250) NOT NULL,
  `Pourcentage` tinyint(1) NOT NULL,
  `Site` varchar(100) DEFAULT NULL,
  `Custom1` varchar(100) DEFAULT NULL,
  `Custom2` varchar(100) DEFAULT NULL,
  `Custom3` varchar(100) DEFAULT NULL,
  `Custom4` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `parametres`
--

INSERT INTO `parametres` (`id`, `Module_concerne`, `Seuil`, `Alerte`, `Label`, `Pourcentage`, `Site`, `Custom1`, `Custom2`, `Custom3`, `Custom4`) VALUES
(2, 'TSM', 40, 30, 'BD', 0, 'AMPERE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vueglobale`
--

DROP TABLE IF EXISTS `vueglobale`;
CREATE TABLE `vueglobale` (
  `Prevision` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = n''est pas une prévision / 1 = prévision',
  `Environnement` varchar(50) NOT NULL,
  `Date_Releve` date NOT NULL,
  `Site` varchar(50) NOT NULL,
  `id_reference` int(11) NOT NULL,
  `Custom1` varchar(100) DEFAULT NULL,
  `Custom2` varchar(100) DEFAULT NULL,
  `Custom3` varchar(100) DEFAULT NULL,
  `Custom4` varchar(100) DEFAULT NULL,
  `Custom5` varchar(100) DEFAULT NULL,
  `Custom6` varchar(100) DEFAULT NULL,
  `Custom7` varchar(100) DEFAULT NULL,
  `Custom8` varchar(100) DEFAULT NULL,
  `Custom9` varchar(100) DEFAULT NULL,
  `Custom10` varchar(100) DEFAULT NULL,
  `Custom11` varchar(100) DEFAULT NULL,
  `Custom12` varchar(100) DEFAULT NULL,
  `Custom13` varchar(100) DEFAULT NULL,
  `Custom14` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `vueglobale`
--

INSERT INTO `vueglobale` (`Prevision`, `Environnement`, `Date_Releve`, `Site`, `id_reference`, `Custom1`, `Custom2`, `Custom3`, `Custom4`, `Custom5`, `Custom6`, `Custom7`, `Custom8`, `Custom9`, `Custom10`, `Custom11`, `Custom12`, `Custom13`, `Custom14`) VALUES
(0, 'TSM', '2017-02-13', 'AMPERE', 248, '146', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-13', 'AMPERE', 247, '146', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-12', 'AMPERE', 246, '147', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-12', 'AMPERE', 245, '147', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-11', 'AMPERE', 244, '143', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-11', 'AMPERE', 243, '143', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-10', 'AMPERE', 242, '144', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-10', 'AMPERE', 241, '144', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-09', 'AMPERE', 240, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-09', 'AMPERE', 239, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-08', 'AMPERE', 238, '127', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-08', 'AMPERE', 237, '127', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-07', 'AMPERE', 236, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-07', 'AMPERE', 235, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-06', 'AMPERE', 234, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-06', 'AMPERE', 233, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-05', 'AMPERE', 232, '130', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-05', 'AMPERE', 231, '130', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-04', 'AMPERE', 230, '128', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-04', 'AMPERE', 229, '128', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-03', 'AMPERE', 228, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-03', 'AMPERE', 227, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 226, '121', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 225, '121', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 224, '120', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 223, '120', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-13', 'AMPERE', 222, '146', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-13', 'AMPERE', 221, '146', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-12', 'AMPERE', 220, '147', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-12', 'AMPERE', 219, '147', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-11', 'AMPERE', 218, '143', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-11', 'AMPERE', 217, '143', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-10', 'AMPERE', 216, '144', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-10', 'AMPERE', 215, '144', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-09', 'AMPERE', 214, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-09', 'AMPERE', 213, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-08', 'AMPERE', 212, '127', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-08', 'AMPERE', 211, '127', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-07', 'AMPERE', 210, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-07', 'AMPERE', 209, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-06', 'AMPERE', 208, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-06', 'AMPERE', 207, '129', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-05', 'AMPERE', 206, '130', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-05', 'AMPERE', 205, '130', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-04', 'AMPERE', 204, '128', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-04', 'AMPERE', 203, '128', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-03', 'AMPERE', 202, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-03', 'AMPERE', 201, '126', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 200, '121', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 199, '121', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 198, '120', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-02-02', 'AMPERE', 197, '120', '26', '97', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vueglobale`
--
ALTER TABLE `vueglobale`
  ADD PRIMARY KEY (`id_reference`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `vueglobale`
--
ALTER TABLE `vueglobale`
  MODIFY `id_reference` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
