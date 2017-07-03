-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 07 Juin 2017 à 18:14
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
-- Structure de la table `parametres`
--

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
(2, 'TSM', 70, 80, 'BD', 1, 'AMPERE', NULL, NULL, NULL, NULL),
(10, 'TSM', 60, 30, 'Bandes', 0, 'AMPERE', NULL, NULL, NULL, NULL),
(4, 'TSM', 85, 95, 'Lib_util', 1, 'AMPERE', NULL, NULL, NULL, NULL),
(5, 'TSM', 70, 50, 'Stock_vierges', 0, 'AMPERE', NULL, NULL, NULL, NULL),
(6, 'TSM', 70, 80, 'BD', 1, 'FRANKLIN', NULL, NULL, NULL, NULL),
(7, 'TSM', 60, 30, 'Bandes', 0, 'FRANKLIN', NULL, NULL, NULL, NULL),
(8, 'TSM', 85, 95, 'Lib_util', 1, 'FRANKLIN', NULL, NULL, NULL, NULL),
(9, 'TSM', 70, 50, 'Stock_vierges', 0, 'FRANKLIN', NULL, NULL, NULL, NULL),
(11, 'VEEAM', 80, 90, 'Volumétrie (%)', 0, 'AMPERE', NULL, NULL, NULL, NULL),
(12, 'VEEAM', 20, 20, 'Licences dispo', 0, 'AMPERE', NULL, NULL, NULL, NULL),
(13, 'VEEAM', 80, 90, 'Volumétrie (%)', 0, 'FRANKLIN', NULL, NULL, NULL, NULL),
(14, 'VEEAM', 20, 20, 'Licences dispo', 0, 'FRANKLIN', NULL, NULL, NULL, NULL),
(15, 'Stockage', 80, 90, 'Taux util', 0, 'AMPERE', NULL, NULL, NULL, NULL),
(16, 'Stockage', 80, 90, 'Taux util', 0, 'FRANKLIN', NULL, NULL, NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
