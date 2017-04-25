-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 25 Avril 2017 à 21:22
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

DROP TABLE IF EXISTS `modules`;

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `label` varchar(50) NOT NULL,
  `site` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `module`, `label`, `site`) VALUES
(1, 'TSM', 'BD', 'AMPERE'),
(2, 'TSM', 'Bandes', 'AMPERE'),
(3, 'TSM', 'Lib_util', 'AMPERE'),
(4, 'TSM', 'Stock_vierges', 'AMPERE'),
(5, 'TSM', 'BD', 'FRANKLIN'),
(6, 'TSM', 'Bandes', 'FRANKLIN'),
(7, 'TSM', 'Lib_util', 'FRANKLIN'),
(8, 'TSM', 'Stock_vierges', 'FRANKLIN');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
