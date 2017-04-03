-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 29 Mars 2017 à 10:08
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
  `Label` varchar(50) NOT NULL,
  `Valeur` varchar(250) DEFAULT NULL,
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
  MODIFY `id_reference` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
