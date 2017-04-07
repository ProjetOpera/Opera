-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 31 Mars 2017 à 10:00
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
(0, 'TSM', '2017-03-31', 'Ampère', 2, '52', '68', '254', '26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-03-31', 'Ampère', 3, '56', '78', '256', '89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0, 'TSM', '2017-03-31', 'Ampère', 4, '56', '78', '256', '89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `vueglobale`
--
ALTER TABLE `vueglobale`
  ADD PRIMARY KEY (`id_reference`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `vueglobale`
--
ALTER TABLE `vueglobale`
  MODIFY `id_reference` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
