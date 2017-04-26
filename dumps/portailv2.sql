-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 26 Avril 2017 à 20:25
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `portailv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `nom_appli` varchar(255) COLLATE utf8_bin NOT NULL,
  `url_appli` varchar(255) COLLATE utf8_bin NOT NULL,
  `interne` tinyint(1) NOT NULL,
  `serveur_bdd` varchar(255) COLLATE utf8_bin NOT NULL,
  `type_serveur_bdd` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'MYSQL',
  `nom_bdd` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_bdd` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_categories` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `applications`
--

INSERT INTO `applications` (`id`, `nom_appli`, `url_appli`, `interne`, `serveur_bdd`, `type_serveur_bdd`, `nom_bdd`, `user_bdd`, `password`, `id_categories`) VALUES
(1, 'Administration Portail', 'portailadmin', 1, 'localhost', 'MYSQL', 'portailv2', 'portailv2', 'Portailv2', 1),
(15, 'Portail', 'portailv2', 1, '', 'MYSQL', '', '', '', 0),
(16, 'Capacity Planning', 'capacityplanning', 1, 'localhost', 'MYSQL', 'capacityplanning', 'capacityplanning', 'Capacityplanning', 2);

-- --------------------------------------------------------

--
-- Structure de la table `associations_contacts_groupes`
--

CREATE TABLE `associations_contacts_groupes` (
  `id_groupes` int(11) NOT NULL,
  `id_contacts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `associations_contacts_groupes`
--

INSERT INTO `associations_contacts_groupes` (`id_groupes`, `id_contacts`) VALUES
(33, 1);

-- --------------------------------------------------------

--
-- Structure de la table `associations_groupes`
--

CREATE TABLE `associations_groupes` (
  `id_groupe_parent` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom_categorie` varchar(255) COLLATE utf8_bin NOT NULL,
  `couleur_categorie` varchar(6) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `nom_categorie`, `couleur_categorie`) VALUES
(1, 'Administration', '0099FF'),
(2, 'Outils', '00cc00'),
(3, 'Météo du matin', 'EA2F00'),
(10, 'Supervision', 'F07800'),
(11, 'Organisation', '6B40A4'),
(12, 'Applications en BETA', 'FF0000');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `contacts`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `contacts` (
`id` bigint(20)
,`login_contact` varchar(255)
,`prenom_contact` varchar(255)
,`nom_contact` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupes`
--

INSERT INTO `groupes` (`id`, `nom`, `description`) VALUES
(33, 'Admin full', 'administrateurs OPERA'),
(35, 'Users full applis', 'acces a toutes les applis en lecture'),
(73, 'Admin Portail', 'Administrateur du portail');

-- --------------------------------------------------------

--
-- Structure de la table `group_has_level_acces`
--

CREATE TABLE `group_has_level_acces` (
  `id_groupes` int(11) NOT NULL,
  `id_level_access` int(11) NOT NULL,
  `id_applications` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `group_has_level_acces`
--

INSERT INTO `group_has_level_acces` (`id_groupes`, `id_level_access`, `id_applications`) VALUES
(33, 22, 1),
(33, 22, 16);

-- --------------------------------------------------------

--
-- Structure de la table `level_access`
--

CREATE TABLE `level_access` (
  `id` int(11) NOT NULL,
  `level` int(3) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `level_access`
--

INSERT INTO `level_access` (`id`, `level`, `description`) VALUES
(1, 100, '100% des fonctions'),
(2, 50, '50% des fonctions'),
(22, 200, 'Pour les tests'),
(23, 10, 'peu de fonctions'),
(24, 75, '75% des fonctions');

-- --------------------------------------------------------

--
-- Structure de la table `libelles`
--

CREATE TABLE `libelles` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `libelles`
--

INSERT INTO `libelles` (`id`, `code`, `description`) VALUES
(1, 'menu_application', 'menu Application'),
(2, 'menu_libelles', 'menu Libelles'),
(3, 'menu_application_menu', 'menu Application->menu'),
(4, 'menu_application_menu_ajout', 'menu Application->menu->ajout'),
(5, 'menu_categories', 'menu Categories'),
(9, 'menu_application_gestion', 'menu Application->gestion'),
(11, 'menu_bonsoir', 'test'),
(12, 'menu_groupeusers', 'menu GroupesUtilisateur'),
(14, 'menu_groupeusers_association', 'assication'),
(16, 'menu_association_user', '(portails admn) association utilisateurs/groupes'),
(17, 'menu_association_appli', '(portail admn) associations applications/groupes'),
(18, 'menu_parametres', 'Menu Paramètres'),
(19, 'menu_AFFAIRE', 'RFC'),
(20, 'menu_DT', ''),
(21, 'menu_EXPLOITATION', ''),
(22, 'menu_PLANNING', ''),
(23, 'menu_Journalier', 'Journalier'),
(24, 'menu_HEBDOMADAIRE', ''),
(25, 'menu_uc1', ''),
(26, 'menu_cnes4', ''),
(27, 'menu_cnes7', ''),
(28, 'menu_recherche', ''),
(31, 'menu_ecart', ''),
(33, 'menu_accueil', 'accueil'),
(34, 'menu_historique', 'Historique'),
(35, 'menu_statistiques', 'Statistiques'),
(36, 'menus_infos', 'Infos'),
(37, 'menu_intervention_en_cours', 'Interventions en cours'),
(39, 'menu_Gestion_des_exclusions', 'gestion des exclusions'),
(40, 'menu_Liste_des_serveurs', 'liste des serveurs'),
(41, 'menu_tableau_de_bord', 'Tableau de bord'),
(42, 'menu_chargement', 'Chargement'),
(43, 'menu_synthese', 'Synthèse'),
(44, 'menu_administration', 'Administration'),
(45, 'menu_aide', 'Aide'),
(47, 'menu_types _de_sauvegardes', 'Types de sauvegardes'),
(48, 'menu_associations_biens_types_de_sauvegardes', 'Associations Biens/Types de sauvegardes'),
(49, 'menu_parametrage_des_durees', 'Paramétrage des durées'),
(50, 'menu_parametrage_du_multiping', 'paramétrage du multiping'),
(51, 'menu_parametrage_duree', 'paramétrage des durées'),
(52, 'menu_point_acces', 'point d\'accÃ¨s'),
(53, 'menu_TSMEXT', ''),
(54, 'menu_ecart_itac/production', 'sous menu Ecart de Blade'),
(55, 'menu_ecart_versions_firmwares', 'sous menu Ecart de Blade'),
(58, 'menu_telechargement', 'Téléchargement'),
(77, 'menu_ajout_netbios', 'lala'),
(78, 'menu_gestion_utilisateurs', 'RNB Gestion des utilisateurs'),
(79, 'menu_saisie', '(météo) saisie données WIFI'),
(80, 'menu_meteo', '(météo) météo du jour'),
(82, 'menu_contact', ''),
(86, 'menu_gestion_bandes_neuves', '(tom)'),
(87, 'menu_gestion_bandes_avec_donnees', '(tom)'),
(88, 'menu_gestion_bandes_vierges', '(tom)'),
(89, 'menu_gestion_des_zones', '(tom) sous menu Administration'),
(90, 'menu_gestion_des_robots', '(tom) sous menu Administration'),
(91, 'menu_gestion_des_coffres', '(tom) sous menu Administration'),
(92, 'menu_gestion_des_utilisateurs', '(tom) sous menu Administration'),
(93, 'menu_affecter_robot_zone', '(tom) sous menu Administration'),
(94, 'menu_affecter_coffre_robot', '(tom) sous menu Administration'),
(95, 'menu_test', 'onglet invisible (level 200)'),
(96, 'menu_ticket', '(nexus) Administration-pour la creation de ticket permanent'),
(99, 'menu_SAINT DENIS-PRA', '(meteo) affichage biens'),
(100, 'menu_informations', '(meteo) Informations'),
(101, 'menu_eligibilite', '(emma) Eligibilité'),
(102, 'menu_eligibilite_gestion_materiels', '(emma) gestion des matériels'),
(103, 'menu_eligibilite_gestion_applications', '(emma) gestion des applications'),
(104, 'menu_mvt_bandes', 'mouvement bandes'),
(105, 'menu_eligibilite_gestion_poste', '(emma) Eligibilité des postes'),
(106, 'menus_rapports_elias', 'Rapports ELIAS'),
(107, 'menu_maj_firmwares', '(BLADE) suivi des MAJ de firmwares'),
(108, 'menu_maj_firmwares_suivi_par_salle', '(BLADE) suivi MAJ firmwares par salle'),
(109, 'menu_suivi_maj_firmwares_general', '(BLADE) suivi MAJ firmwares générale'),
(110, 'menu_eligibilite_consultation', '(emma) consultation'),
(111, 'menu_planification', '(ELIAS) Planification'),
(112, 'menu_synthese_checklist', '(checklist) synthese'),
(113, 'menu_rapport_pop_up_checklist', '(checklist) rapport pop-up'),
(114, 'menu_syntheseS_checklist', '(checklist) syntheseS'),
(115, 'menu_syntheseJ_checklist', '(checklist) syntheseJ'),
(116, 'menu_checklist', '(checklist) Accueil'),
(117, 'menu_ajout_dt_checklist', '(checklist) ajouter dt'),
(118, 'menu_ajout_dt_ponct_checklist', '(checklist) ajouter dt ponct'),
(119, 'menu_ajout_dt_perma_checklist', '(checklist) ajouter dt perma'),
(120, 'menu_recherche_checklist', '(checklist) recherche'),
(121, 'menu_administration_checklist', '(checklist) administration'),
(122, 'menu_aide_checklist', '(checklist) aide'),
(123, 'menu_mainteneur', 'Mainteneur'),
(125, 'menu_biens_sans_type_sauvegarde', 'Biens sans type de sauvegarde'),
(126, 'menu_inventaire_blades', '(blade) sous menu Téléchargement'),
(127, 'menu_import_donnees_prod', '(blade) sous menu Téléchargement'),
(129, 'menu_tblord_Synthese', 'Rapport des sauvegardes KO'),
(130, 'menu_AMPERE_SNP1', ''),
(131, 'menu_FRANKLIN_SNP2', ''),
(132, 'menu_FRANKLIN SNP2', '(meteo) affichage biens'),
(133, 'menu_constantes_elias', 'Constantes pour Elias'),
(134, 'menu_calendrier_site', 'Calendrier des sites dans Elias'),
(135, 'menu_eligibilite_edition', 'Menu  pour forcer un poste à être migrable'),
(136, 'menu_nexus_ecran_erreurs', 'Ecran des erreurs'),
(137, 'menu_nexus_sauvegardes_non_realisees', ''),
(138, 'menu_nexus_sauvegarde_veille', 'Sauvegardes de la veille'),
(139, 'menu_Liste_équipements', 'Liste des équipements'),
(140, 'menu_destinataires', ''),
(141, 'menu_programmation_jour', '(ELIAS) Programmations jour'),
(142, 'menu_reboots_statistiques', 'Statistiques'),
(143, 'menu_reboots_suivi', 'Anomalies'),
(144, 'menu_reboots_verif_dex', 'Vérification des reboots'),
(145, 'menu_suivi_reboot2', 'Suivi des reboots V2'),
(146, 'menu_liste_serveurs_reboot', 'Liste des serveurs avec reboots trop éloignées'),
(147, 'menu_shiva_erreurs', 'Affichage des dernières erreurs SHIVA'),
(148, 'menu_rapport_journalier', '(iris) rapport journalier'),
(149, 'menu_rapport_hebdo', '(iris) rapport hebdo'),
(150, 'menu_Mensuel', 'Mensuel'),
(151, 'menu_DNP_SIMI', 'menu météo'),
(152, 'menu_DNR_SIMI', 'menu météo'),
(153, 'menu_localisation', 'Définir la localisation des matériels'),
(154, 'menu_automatisation_listeTache', 'Liste des tâches'),
(155, 'menu_commun', 'Commun'),
(156, 'menu_commun_equipes', 'Equipes ATOS'),
(157, 'menu_commun_nna_equipes', 'Relation NNA/NNB equipes'),
(158, 'menu_commun_utilisateur', 'Utilisateurs'),
(159, 'menu_gestion_site_unite', 'Gestion des Régions/Sites et des unités'),
(160, 'menus_automation_attente', ''),
(161, 'menu_automatisation_groupe_tache', 'Groupe de tâches'),
(162, 'menu_changement', 'Changement'),
(163, 'menu_changement_application', 'Changement par application'),
(164, 'menu_changement_detail', 'Detail d un changement'),
(165, 'menu_Reporting', 'Reporting'),
(166, 'menu_ericaV2_admin', 'Administration Erica'),
(167, 'menu_ericaV2_admin_lots', 'Gestion des lots'),
(168, 'menu_ericaV2_admin_module', 'Gestion des modules'),
(169, 'menu_consultation', 'Consultation'),
(170, 'menu_collecteDonneesMeteo', 'Collecter les donnees pour Météo du matin'),
(171, 'menu_gestion_meteo', 'Gestion des items de méto du matin'),
(172, 'menu_gestion_seuil', 'Gestion des seuils'),
(173, 'menu_gestion_codeTechnique', 'Gestion des codes tecniques'),
(174, 'menu_gestion_ListeDistribution_mail', 'Gestion des listes de distribution des mails'),
(175, 'menu_niveau_1', ''),
(176, 'menu_niveau_2', ''),
(177, 'menu_niveau_3', ''),
(178, 'menu_lov', 'Listes de valeurs'),
(179, 'menu_lov_values', 'Valeurs'),
(180, 'menu_lov_types', 'Types'),
(181, 'menu_ERICAV2_ACCUEIL', 'Accueil'),
(182, 'menu_ERICAV2_ADMINISTRATION', 'Administration'),
(183, 'menu_ERICAV2_LOTS', 'Lots'),
(184, 'menu_ERICAV2_MODULES', 'Modules'),
(185, 'menu_ERICAV2_LISTE_DIFFUSION', 'Listes de diffusion'),
(186, 'menu_ERICAV2_FM', 'Faits marquants'),
(187, 'menu_ERICAV2_FM_CREATION', 'Création'),
(188, 'menu_ERICAV2_MODIFICATION', 'Modification'),
(189, 'menu_ERICAV2_CONSULTATION', 'Consultation'),
(191, 'menu_ERICAV2_AIDE', 'Aide'),
(192, 'menu_techno_plugin', 'Menu de saisie de plugin pour une technologie'),
(193, 'menu_getion_menu_accueil', 'Gestion des onglets et des catégories'),
(194, 'menu_anomalies', 'Anomalies'),
(195, 'menu_gestion_netbios_riades', 'Gestion des netbios RIADES'),
(196, 'menu_gestion_groupe_et_ss_groupe', 'Gestion des groupes et des sous groupes'),
(197, 'menu_PEPITES_administration', 'Administration PEPITES'),
(198, 'menu_PEPITES_administration_mapping_appli_package', 'Mapping des applications ITAC et des packages SCCM'),
(199, 'menu_afficher_graphe', 'Affichage des graphes'),
(200, 'menu_module_et_groupe_support', 'Gestion des Modules et des groupes de support'),
(201, 'menu_duree_historisation', 'Durée Historisation'),
(202, 'menu_couleur_etat', 'Definition des couleurs de états des activités'),
(203, 'menu_checklist_1', 'Checklist SEA B1'),
(204, 'menu_checklist_2', 'Checklist Vue Ecran'),
(205, 'menu_codesite', 'Codes Sites'),
(206, 'menu_geste_complementaire', 'Geste complementaire'),
(207, 'menu_dsbca_manuel', 'DSBCA Manuel'),
(208, 'menu_gestion_dsbca', 'Gestion DSBCA'),
(209, 'menu_dsbca_non_termine', 'DSBCA non terminé'),
(210, 'menu_groupes_support_sm93', 'Groupes de support SM93'),
(211, 'menu_gestion_manuelle', 'gestion manuelle automatisation'),
(214, 'menu_automation_customfields', 'Gestion des champs personnalisés des tâches'),
(215, 'menu_creation_manuelle', 'creation manuelle automatisation'),
(216, 'menu_automation_demandesgroupees', 'Menu de gestion des demandes groupées'),
(217, 'menu_accueil_recette', 'Recette menu accueil'),
(218, 'menu_module', 'Module'),
(219, 'menu_groupe_support', 'Groupes de support'),
(220, 'menu_ERICAV2_ANNULATION', 'Annulation'),
(221, 'menus_shiva_beta', 'shiva_beta'),
(222, 'menu_afficher_IM5', 'Affichier indicateur IM5'),
(223, 'menu_afficher_IM9', 'Afficher indicateur IM9'),
(224, 'menu_etat_elias', 'bouton ON/OFF'),
(225, 'menu_global', 'paramètres globaux'),
(226, 'menu_suivi', 'Suivi'),
(227, 'menu_extract_manuel', 'Extraction manuelle des indicateurs'),
(228, 'menu_reseau', 'Gestion site réseau'),
(229, 'menu_exclusion', 'Gestion des exclusions'),
(230, 'menu_region_atos', 'paramétrage des régions ATOS Elias'),
(231, 'menu_lien_plaque_unite', ''),
(232, 'menu_pilotage', 'Menu pilotage application ELIAS'),
(233, 'menu_migrabilite_elias', 'Menu de migrabilité application ELIAS'),
(234, 'menu_elias_forcer', 'menu Elias pour focer invitation/planification'),
(235, 'menu_elias_planification', 'Menu de planification Elias'),
(236, 'menu_elias_invitation', 'Menu invitation Elias'),
(237, 'menu_consolidation_codesite', 'Consolidation du code site pour Elias'),
(238, 'menu_rapport_etat_migrabilite', 'Elias V3 '),
(239, 'menu_annuler_planification', 'Annuler planification Elias V3'),
(240, 'menu_capacityplanning_SAN', 'capacityplanning SAN'),
(241, 'menu_capacityplanning_Stockage', 'capacityplanning stockage'),
(242, 'Seuils / Alertes', 'Page de parametre capacityplanning'),
(243, 'menu_capacityplanning_seuil_alerte', 'Gestion des seuils / alertes'),
(244, 'menu_capacityplanning_sauvegarde', 'Sauvegarde'),
(245, 'menu_capacityplanning_veeam', 'Veeam'),
(246, 'menu_capacityplanning_virtualisation', 'Virtualisation'),
(247, 'menu_capacityplanning_SI', 'SI'),
(248, 'menu_capacityplanning_DataCenter', 'DataCenter'),
(249, 'menu_capacityplanning_DataCenter_Ampere', 'DataCenter Ampere'),
(250, 'menu_capacityplanning_DataCenter_Franklin', 'DataCenter Franklin'),
(251, 'menu_capacityplanning_equipements', 'Equipements');

-- --------------------------------------------------------

--
-- Structure de la table `libelles_trad`
--

CREATE TABLE `libelles_trad` (
  `id` int(11) NOT NULL,
  `id_libelle` int(11) NOT NULL,
  `traduction` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_lookup_values` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `libelles_trad`
--

INSERT INTO `libelles_trad` (`id`, `id_libelle`, `traduction`, `id_lookup_values`) VALUES
(1, 1, 'Applications', 1),
(2, 1, 'Applications', 2),
(3, 2, 'Titles', 1),
(4, 2, 'Libelles', 2),
(5, 3, 'Menu', 1),
(6, 3, 'Menu', 2),
(7, 4, 'Add', 1),
(8, 4, 'Ajout', 2),
(9, 5, 'Categories', 1),
(10, 5, 'Catégories', 2),
(15, 9, 'Manage', 1),
(16, 9, 'Gestion', 2),
(19, 11, 'good evening !', 1),
(20, 11, 'Bonsoir !', 2),
(21, 12, 'Users Groups', 1),
(22, 12, 'Groupes utilisateurs', 2),
(25, 14, 'Association', 1),
(26, 14, 'Association', 2),
(29, 16, 'Users/Groups', 1),
(30, 16, 'Utilisateurs/Groupes', 2),
(31, 17, 'Applications/Groups', 1),
(32, 17, 'Applications/Groupes ', 2),
(33, 18, 'Parameters', 1),
(34, 18, 'Paramètres', 2),
(35, 19, 'RFC', 1),
(36, 19, 'Affaire', 2),
(37, 20, 'Work ....', 1),
(38, 20, 'DT', 2),
(39, 21, 'Exploitation', 1),
(40, 21, 'Exploitation', 2),
(41, 22, 'Planning', 1),
(42, 22, 'Planning', 2),
(43, 23, 'Daily', 1),
(44, 23, 'Journalier', 2),
(45, 24, 'HBDOMADAIRE', 1),
(46, 24, 'Hebdomadaire', 2),
(47, 25, 'UC1-RTE', 1),
(48, 25, 'UC1-RTE', 2),
(49, 26, 'CNES-INFO4', 1),
(50, 26, 'CNES-INFO4', 2),
(51, 27, 'CNES-INFO7', 1),
(52, 27, 'CNES-INFO7', 2),
(53, 28, 'Search', 1),
(54, 28, 'Recherche', 2),
(59, 31, '', 1),
(60, 31, 'Ecart', 2),
(63, 33, 'Home', 1),
(64, 33, 'Accueil', 2),
(65, 34, '', 1),
(66, 34, 'Historique', 2),
(67, 35, '', 1),
(68, 35, 'Statistiques', 2),
(69, 36, '', 1),
(70, 36, '', 2),
(71, 37, '', 1),
(72, 37, 'Interventions en cours', 2),
(75, 39, '', 1),
(76, 39, 'Gestion des exclusions', 2),
(77, 40, '', 1),
(78, 40, 'Liste des serveurs', 2),
(79, 41, 'Panel', 1),
(80, 41, 'Tableau de bord                            ', 2),
(81, 42, 'Loading', 1),
(82, 42, 'Chargement', 2),
(83, 43, 'Summary', 1),
(84, 43, 'Synthèse', 2),
(85, 44, 'Administration', 1),
(86, 44, 'Administration', 2),
(87, 45, 'Help', 1),
(88, 45, 'Aide', 2),
(91, 47, '', 1),
(92, 47, 'Types de sauvegardes', 2),
(93, 48, '', 1),
(94, 48, 'Association Biens/Types de sauvegardes', 2),
(95, 49, '', 1),
(96, 49, '', 2),
(97, 50, '', 1),
(98, 50, 'Paramétrage du multiping', 2),
(99, 51, '', 1),
(100, 51, 'Paramétrage des durées', 2),
(101, 52, '', 1),
(102, 52, 'Point d\'accès', 2),
(103, 53, '', 1),
(104, 53, 'TSMEXT', 2),
(105, 54, '', 1),
(106, 54, 'ITAC/Prod', 2),
(107, 55, '', 1),
(108, 55, 'Versions firmware', 2),
(113, 58, 'Download', 1),
(114, 58, 'Téléchargement', 2),
(145, 0, 'Add Netbios', 1),
(146, 0, 'Ajout Netbios', 2),
(163, 77, 'Add Netbios', 1),
(164, 77, 'Ajout Netbios', 2),
(165, 78, '', 1),
(166, 78, 'Gestion utilisateurs', 2),
(167, 79, '', 1),
(168, 79, 'Saisie des données', 2),
(169, 80, '', 1),
(170, 80, 'Météo du jour', 2),
(173, 82, '', 1),
(174, 82, 'Contact', 2),
(182, 86, 'Gestion bandes neuves', 2),
(184, 87, 'Gestion bandes avec données', 2),
(186, 88, 'Gestion bandes vierges', 2),
(188, 89, 'Gestions des zones', 2),
(190, 90, 'Gestion des robots', 2),
(192, 91, 'Gestion des coffres', 2),
(194, 92, 'Gestion des utilisateurs', 2),
(196, 93, 'Affecter Robot/Zone', 2),
(198, 94, 'Affecter Coffre/Robot', 2),
(199, 95, 'Test', 1),
(200, 95, 'Test', 2),
(201, 96, '', 1),
(202, 96, 'Tickets permanents', 2),
(205, 99, 'SAINT DENIS-PRA', 2),
(206, 100, 'Informations', 1),
(207, 100, 'Informations', 2),
(208, 101, '', 1),
(209, 101, 'Eligibilité', 2),
(210, 102, '', 1),
(211, 102, 'Gestion des matériels', 2),
(212, 103, '', 1),
(213, 103, 'Gestion des applications', 2),
(214, 104, 'Tape movement', 1),
(215, 104, 'Mouvement de bandes', 2),
(216, 105, '', 1),
(217, 105, 'Gestion des postes', 2),
(218, 106, 'Reports', 1),
(219, 106, 'Rapports', 2),
(220, 107, '', 1),
(221, 107, 'MAJ Firmwares', 2),
(222, 108, '', 1),
(223, 108, 'Suivi par salle', 2),
(224, 109, '', 1),
(225, 109, 'Suivi général', 2),
(226, 110, '', 1),
(227, 110, 'Consultation', 2),
(228, 111, '', 1),
(229, 111, 'Planification', 2),
(230, 112, 'Summary', 1),
(231, 112, 'Synthèse', 2),
(232, 113, 'Pop-Up report', 1),
(233, 113, 'Rapport Pop-Up', 2),
(234, 114, 'Week summary', 1),
(235, 114, 'Synthèse Semaine', 2),
(236, 115, 'Day summary', 1),
(237, 115, 'Synthèse Jour', 2),
(238, 116, 'Checklist', 1),
(239, 116, 'Checklist', 2),
(240, 117, 'Add DT', 1),
(241, 117, 'Add DT', 2),
(242, 118, 'Add punctual DT', 1),
(243, 118, 'Ajouter DT ponctuelle', 2),
(244, 119, 'Add permanent DT', 1),
(245, 119, 'Ajouter DT permanente', 2),
(246, 120, 'Search', 1),
(247, 120, 'Recherche', 2),
(248, 121, 'Administration', 1),
(249, 121, 'Administration', 2),
(250, 122, 'Help', 1),
(251, 122, 'Aide', 2),
(252, 123, '', 1),
(253, 123, 'Mainteneur', 2),
(256, 125, 'Assets without backup type', 1),
(257, 125, 'Biens sans type de sauvegarde', 2),
(258, 126, '', 1),
(259, 126, 'Inventaire Blades', 2),
(260, 127, '', 1),
(261, 127, 'Import données châssis', 2),
(264, 129, 'Rapport des sauvegardes KO', 1),
(265, 129, 'Rapport des sauvegardes KO', 2),
(266, 130, 'AMPERE SNP1', 1),
(267, 130, 'Périmètre lot 1 - AMPERE', 2),
(268, 131, 'FRANKLIN SNP2', 1),
(269, 131, 'Périmètre lot 1 - FRANKLIN', 2),
(270, 132, '', 1),
(271, 132, 'FRANKLIN SNP2', 2),
(272, 133, 'Constants', 1),
(273, 133, 'Constantes', 2),
(274, 134, 'Calendar Site', 1),
(275, 134, 'Calendrier de site', 2),
(276, 135, 'Éligibilité', 1),
(277, 135, 'Éligibilité', 2),
(278, 136, '', 1),
(279, 136, 'Sauvegardes en erreurs', 2),
(280, 137, '', 1),
(281, 137, 'Sauvegardes non réalisées', 2),
(282, 138, '', 1),
(283, 138, 'Sauvegardes de la veille', 2),
(284, 139, 'Equipment list', 1),
(285, 139, 'Liste des équipements', 2),
(286, 140, 'Recipients', 1),
(287, 140, 'Destinataires', 2),
(288, 141, 'Programmations of the day', 1),
(289, 141, 'Programmations du jour', 2),
(290, 142, 'Statistic', 1),
(291, 142, 'Statistiques', 2),
(292, 143, 'Errors', 1),
(293, 143, 'Anomalies', 2),
(294, 144, '', 1),
(295, 144, 'Vérification des DEX', 2),
(296, 145, 'Suivi des reboots V2', 1),
(297, 145, 'Suivi des reboots V2', 2),
(298, 146, 'Liste des serveurs à traiter', 1),
(299, 146, 'Liste des serveurs à traiter', 2),
(300, 147, 'Errors', 1),
(301, 147, 'Erreurs', 2),
(302, 148, 'Daily report', 1),
(303, 148, 'Rapport journalier', 2),
(304, 149, 'Weekly report', 1),
(305, 149, 'Rapport hebdomadaire', 2),
(306, 150, 'Monthly', 1),
(307, 150, 'Mensuel', 2),
(309, 151, 'DNP SIMI', 1),
(310, 151, 'Périmètre lot B2 - DNP', 2),
(311, 152, 'DNR SIMI', 1),
(312, 152, 'Périmètre lot B2 - DNR', 2),
(313, 153, 'Localisation', 1),
(314, 153, 'Localisation', 2),
(315, 154, 'Tasks List', 1),
(316, 154, 'Liste des tâches', 2),
(317, 155, 'Common', 1),
(318, 155, 'Commun', 2),
(319, 156, 'Teams', 1),
(320, 156, 'Equipes', 2),
(321, 157, 'NNA/NNB and Teams', 1),
(322, 157, 'NNA/NNB et Equipes', 2),
(323, 158, 'Users', 1),
(324, 158, 'Utilisateurs', 2),
(325, 159, 'Sites and Unites Management', 1),
(326, 159, 'Gestion Sites et Unités', 2),
(327, 160, 'Waiting', 1),
(328, 160, 'Demandes en attente', 2),
(329, 161, 'Tasks groups', 1),
(330, 161, 'Groupes de tâches', 2),
(331, 162, 'Change', 1),
(332, 162, 'Changement', 2),
(333, 163, 'Change by application', 1),
(334, 163, 'Changement par application', 2),
(335, 164, 'Change - Detail', 1),
(336, 164, 'Changement - Détail', 2),
(337, 165, 'Reporting', 1),
(338, 165, 'Reporting', 2),
(339, 166, 'Administration', 1),
(340, 166, 'Administration', 2),
(341, 167, 'Gestion des lots', 1),
(342, 167, 'Gestion des lots', 2),
(343, 168, 'Modules Management', 1),
(344, 168, 'Gestion des modules', 2),
(345, 169, 'Consultation', 1),
(346, 169, 'Consultation', 2),
(347, 170, 'Data Reading ', 1),
(348, 170, 'Collecte Données', 2),
(349, 171, 'Modules and Items', 1),
(350, 171, 'Modules et Items', 2),
(351, 172, 'Limits', 1),
(352, 172, 'Seuils', 2),
(353, 173, 'Technical codes', 1),
(354, 173, 'Codes Techniques', 2),
(355, 174, 'Distribution List', 1),
(356, 174, 'Liste de distribution', 2),
(357, 175, 'Level 1', 1),
(358, 175, 'Niveau 1', 2),
(359, 176, 'Level 2', 1),
(360, 176, 'Niveau 2', 2),
(361, 177, 'Level 3', 1),
(362, 177, 'Niveau 3', 2),
(363, 178, 'Lists of values', 1),
(364, 178, 'Listes de valeurs', 2),
(365, 179, 'Values', 1),
(366, 179, 'Valeurs', 2),
(367, 180, 'Types', 1),
(368, 180, 'Types', 2),
(369, 181, 'Accueil', 1),
(370, 181, 'Accueil', 2),
(371, 182, 'Administration', 1),
(372, 182, 'Administration', 2),
(373, 183, 'Lots', 1),
(374, 183, 'Lots', 2),
(375, 184, 'Modules', 1),
(376, 184, 'Modules', 2),
(377, 185, 'Listes de diffusion', 1),
(378, 185, 'Listes de diffusion', 2),
(379, 186, 'Faits marquants', 1),
(380, 186, 'Faits marquants', 2),
(381, 187, 'Creation', 1),
(382, 187, 'Création', 2),
(383, 188, 'Update', 1),
(384, 188, 'Modification', 2),
(385, 189, 'Consultation', 1),
(386, 189, 'Consultation', 2),
(389, 191, 'Help', 1),
(390, 191, 'Aide', 2),
(393, 192, 'Technology', 1),
(394, 192, 'Technologie', 2),
(395, 193, 'Welcome menu', 1),
(396, 193, 'Menu Accueil', 2),
(397, 194, 'Errors', 1),
(398, 194, 'Anomalies', 2),
(399, 195, 'Netbios RIADES', 1),
(400, 195, 'Netbios RIADES', 2),
(401, 196, 'Groups and Sous-groups', 1),
(402, 196, 'Groupes / Sous-Groupes', 2),
(403, 197, 'Administration', 1),
(404, 197, 'Administration', 2),
(405, 198, 'Mapping Applis/Packages', 1),
(406, 198, 'Mapping Applis/Packages', 2),
(407, 199, 'Display graph', 1),
(408, 199, 'Afficher Graphe', 2),
(409, 200, 'Module & Support groupe', 1),
(410, 200, 'Module / Groupe support', 2),
(415, 201, 'Record duration', 1),
(416, 201, 'Durée Historisation', 2),
(417, 202, 'State Color', 1),
(418, 202, 'Couleurs etats', 2),
(419, 203, 'SEA B1 Checklist ', 1),
(420, 203, 'Checklist SEA B1', 2),
(421, 204, 'Screen View Checklist ', 1),
(422, 204, 'Checklist Vue Ecran', 2),
(423, 205, 'Site Codes', 1),
(424, 205, 'Codes Sites', 2),
(425, 206, 'Complementary action', 1),
(426, 206, 'Geste complémentaire', 2),
(427, 207, 'Manual DSBCA', 1),
(428, 207, 'DSBCA Manuel', 2),
(429, 208, 'DSBCA Mangement', 1),
(430, 208, 'Gestion DSBCA', 2),
(431, 209, 'DSBCA non terminé', 1),
(432, 209, 'DSBCA non terminé', 2),
(433, 210, 'Support group SM93', 1),
(434, 210, 'Groupes support SM93', 2),
(435, 211, 'Manage custom tasks', 1),
(436, 211, 'Gestion tâches personnalisées', 2),
(441, 214, 'Tasks Custom fields', 1),
(442, 214, 'Champs personnalisés des tâches', 2),
(443, 215, 'Create/Close custom tasks', 1),
(444, 215, 'Création/Clôture tâches personnalisées', 2),
(445, 216, 'Multiple task management', 1),
(446, 216, 'Création/Clôture demandes groupées', 2),
(447, 217, 'Home_test', 1),
(448, 217, 'Accueil_test', 2),
(449, 218, 'Module', 1),
(450, 218, 'Module', 2),
(451, 219, 'Support groupe', 1),
(452, 219, 'Groupe support', 2),
(453, 220, 'Annulation', 1),
(454, 220, 'Delete', 2),
(455, 221, 'shiva_beta', 1),
(456, 221, 'shiva_beta', 2),
(457, 222, 'Display IM5', 1),
(458, 222, 'Afficher IM5', 2),
(459, 223, 'Display IM9', 1),
(460, 223, 'Afficher IM9', 2),
(461, 224, 'Application state', 1),
(462, 224, 'Etat application', 2),
(463, 225, 'Global', 1),
(464, 225, 'Globaux', 2),
(465, 226, 'Follow-up', 1),
(466, 226, 'Suivi', 2),
(467, 227, 'Manual Extraction', 1),
(468, 227, 'Extraction manuelle', 2),
(469, 228, 'Network', 1),
(470, 228, 'Réseau', 2),
(471, 229, 'Exclusions', 1),
(472, 229, 'Exclusions', 2),
(473, 230, 'Régions ATOS/Sites', 1),
(474, 230, 'Régions ATOS/Sites', 2),
(475, 231, 'Unit/Region Link', 1),
(476, 231, 'Lien Plaque ITAC/Unité ARFSI', 2),
(477, 232, 'Manage', 1),
(478, 232, 'Pilotage', 2),
(479, 233, 'Migrability', 1),
(480, 233, 'Migrabilité', 2),
(481, 234, 'Force', 1),
(482, 234, 'Forcer', 2),
(483, 235, 'Planification', 1),
(484, 235, 'Planification', 2),
(485, 236, 'Invitation', 1),
(486, 236, 'Invitation', 2),
(487, 237, 'Site code consolidation', 1),
(488, 237, 'Consolidation localisation poste', 2),
(489, 238, 'State report', 1),
(490, 238, 'Suivi du déploiement', 2),
(491, 239, 'Cancel planification', 1),
(492, 239, 'Annuler planification', 2),
(493, 240, 'SAN', 1),
(494, 240, 'SAN', 2),
(495, 241, 'Storage', 1),
(496, 241, 'Stockage', 2),
(497, 242, 'Seuils / Alertes', 1),
(498, 242, 'Seuils / Alertes', 2),
(499, 243, 'Seuils / Alertes', 1),
(500, 243, 'Seuils / Alertes', 2),
(501, 244, 'Save', 1),
(502, 244, 'Sauvegarde', 2),
(503, 245, 'Veeam', 1),
(504, 245, 'Veeam', 2),
(505, 246, 'Virtualisation', 1),
(506, 246, 'Virtualisation', 2),
(507, 247, 'SI', 1),
(508, 247, 'SI', 2),
(509, 248, 'DataCenter', 1),
(510, 248, 'DataCenter', 2),
(511, 249, 'Ampere', 1),
(512, 249, 'Ampere', 2),
(513, 250, 'Franklin', 1),
(514, 250, 'Franklin', 2),
(515, 251, 'Equipements', 1),
(516, 251, 'Equipements', 2);

-- --------------------------------------------------------

--
-- Structure de la table `lookup_values`
--

CREATE TABLE `lookup_values` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `lookup_values`
--

INSERT INTO `lookup_values` (`id`, `type`, `value`) VALUES
(1, 'langue', 'EN'),
(2, 'langue', 'FR');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `Id_Textuel` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lien` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `code_libelle` int(11) NOT NULL,
  `ordre` int(11) NOT NULL,
  `defaut` tinyint(11) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL,
  `id_applications` int(11) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `menus`
--

INSERT INTO `menus` (`id`, `Id_Textuel`, `url`, `lien`, `code_libelle`, `ordre`, `defaut`, `parent`, `id_applications`, `id_level`) VALUES
(1, '', '', NULL, 1, 0, 0, -1, 1, 22),
(2, 'ADMINISTRATION_PORTAIL_LIBELLES', 'libelles/libelles.php', NULL, 2, 3, 0, -1, 1, 22),
(3, 'ADMINISTRATION_PORTAIL_MENU', 'applications/menus.php', NULL, 3, 1, 1, 1, 1, 22),
(5, 'ADMINISTRATION_PORTAIL_CATEGORIES', 'categories/categories.php', NULL, 5, 2, 0, -1, 1, 22),
(6, 'ADMINISTRATION_PORTAIL_GESTION', 'applications/Gestion.php', NULL, 9, 0, 0, 1, 1, 22),
(13, 'ADMINISTRATION_PORTAIL_GROUPES_UTILS', '', NULL, 12, 1, 0, -1, 1, 1),
(14, 'ADMINISTRATION_PORTAIL_GESTION_GRP', 'groupesusers/Gestion.php', NULL, 9, 0, 0, 13, 1, 22),
(25, 'ADMINISTRATION_PORTAIL_ASSOC_APP_GRP', 'groupesusers/association/Association_App.php', NULL, 17, 1, 0, 27, 1, 22),
(26, 'ADMINISTRATION_PORTAIL_ASSOC_UTIL_GRP', 'groupesusers/association/Association_User.php', NULL, 16, 2, 0, 27, 1, 1),
(27, 'ADMINISTRATION_PORTAIL_ASSOCIATION', 'groupesusers/association/Association_User.php', NULL, 14, 1, 0, 13, 1, 1),
(28, 'ADMINISTRATION_PORTAIL_PARAMETRES', 'applications/parametres.php', NULL, 18, 2, 0, 1, 1, 22),
(105, 'NULL105', 'accueil.php', NULL, 33, 1, 1, -1, 15, 2),
(199, 'ADMINISTRATION_PORTAIL_COMMUN', 'commun/equipes.php', NULL, 155, 4, 0, -1, 1, 1),
(201, 'ADMINISTRATION_PORTAIL_EQUIPES', 'commun/equipes.php', NULL, 156, 2, 0, 199, 1, 1),
(202, 'ADMINISTRATION_PORTAIL_NNANNB_EQUIPES', 'commun/nnannb_equipes.php', NULL, 157, 3, 0, 199, 1, 1),
(203, 'ADMINISTRATION_PORTAIL_CONTACTS', 'commun/contacts.php', NULL, 158, 1, 0, 199, 1, 1),
(226, 'ADMINISTRATION_PORTAIL_LOV', 'typesvaleurs/typesvaleurs.inc.php', NULL, 178, 4, 0, 199, 1, 1),
(229, 'MENU_CAPACITYPLANNING_SEUILS_ALERTES', 'seuils_alertes/seuils_alertes.php', NULL, 243, 4, 0, -1, 16, 2),
(234, 'MENU_CAPACITYPLANNING_SI', 'si/si.php', NULL, 247, 1, 0, -1, 16, 2),
(235, 'MENU_CAPACITYPLANNING_DATACENTER', 'datacenter/datacenter.php', NULL, 248, 2, 0, -1, 16, 2),
(236, 'MENU_CAPACITYPLANNING_AMPERE', 'datacenter/ampere.php', NULL, 249, 1, 0, 235, 16, 2),
(237, 'MENU_CAPACITYPLANNING_FRANKLIN', 'datacenter/franklin.php', NULL, 250, 2, 0, 235, 16, 2),
(238, 'MENU_CAPACITYPLANNING_EQUIPEMENTS', 'equipements/equipements.php', NULL, 251, 3, 1, -1, 16, 2),
(239, 'MENU_CAPACITYPLANNING_VIRTUALISATION', 'equipements/virtualisation.php', NULL, 246, 1, 0, 238, 16, 2),
(240, 'MENU_CAPACITYPLANNING_VEEAM', 'equipements/veeam.php', NULL, 245, 2, 0, 238, 16, 2),
(241, 'MENU_CAPACITYPLANNING_STOCKAGE', 'equipements/stockage.php', NULL, 241, 3, 0, 238, 16, 2),
(243, 'MENU_CAPACITYPLANNING_SAUVEGARDE', 'equipements/sauvegarde.php', NULL, 244, 4, 0, 238, 16, 2);

-- --------------------------------------------------------

--
-- Structure de la table `param_appli`
--

CREATE TABLE `param_appli` (
  `id` int(11) NOT NULL,
  `code_param` varchar(255) COLLATE utf8_bin NOT NULL,
  `type_param` varchar(1) COLLATE utf8_bin NOT NULL,
  `valeur_param_int` int(11) DEFAULT NULL,
  `valeur_param_varchar` varchar(255) COLLATE utf8_bin NOT NULL,
  `valeur_param_date` timestamp NULL DEFAULT NULL,
  `id_applications` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `param_appli`
--

INSERT INTO `param_appli` (`id`, `code_param`, `type_param`, `valeur_param_int`, `valeur_param_varchar`, `valeur_param_date`, `id_applications`) VALUES
(1, 'test1', 'i', 123, '', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `typevaleur`
--

CREATE TABLE `typevaleur` (
  `id_typevaleur` bigint(20) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(1000) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='listes de valeurs';

--
-- Contenu de la table `typevaleur`
--

INSERT INTO `typevaleur` (`id_typevaleur`, `code`, `description`) VALUES
(2, 'IMPACT_METIER', 'Impacts possibles pour le métier'),
(4, 'RC_CAPACITY', 'Root cause capacity'),
(5, 'CATEGORIE', 'Catégories d\'incidents'),
(6, 'YES_NO', 'Oui ou Non'),
(7, 'PORTEUR_RC', 'Porteur de la recherche de la root cause');

-- --------------------------------------------------------

--
-- Structure de la table `typevaleur_items`
--

CREATE TABLE `typevaleur_items` (
  `id` bigint(20) NOT NULL,
  `id_typevaleur` bigint(20) NOT NULL DEFAULT '0',
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `lib_fr` varchar(256) COLLATE utf8_bin NOT NULL,
  `lib_en` varchar(256) COLLATE utf8_bin NOT NULL,
  `defaut` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'valeur par defaut'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `typevaleur_items`
--

INSERT INTO `typevaleur_items` (`id`, `id_typevaleur`, `code`, `lib_fr`, `lib_en`, `defaut`) VALUES
(16, 5, 'CATEGORIE_ROUTEUR', 'Routeur', 'Routeur', 0),
(19, 2, 'IMPACT_METIER_A_DEFINIR_1', 'A définir 1', 'To define 1', 1),
(20, 2, 'IMPACT_METIER_A_DEFINIR_2', 'A définir 2', 'To define 2', 0),
(21, 4, 'RC_CAPACITY_OUI', 'Oui', 'Yes', 0),
(22, 4, 'RC_CAPACITY_NON', 'Non', 'No', 1),
(27, 6, 'N', 'Non', 'No', 1),
(28, 6, 'Y', 'Oui', 'Yes', 0),
(29, 7, 'INFOGERANT', 'Infogérant', 'Infogerant', 0),
(30, 7, 'CLIENT', 'Client', 'Customer', 0);

-- --------------------------------------------------------

--
-- Structure de la vue `contacts`
--
DROP TABLE IF EXISTS `contacts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contacts`  AS  select `commun`.`contact`.`id` AS `id`,`commun`.`contact`.`login_contact` AS `login_contact`,`commun`.`contact`.`prenom_contact` AS `prenom_contact`,`commun`.`contact`.`nom_contact` AS `nom_contact` from `commun`.`contact` ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `associations_contacts_groupes`
--
ALTER TABLE `associations_contacts_groupes`
  ADD PRIMARY KEY (`id_groupes`,`id_contacts`);

--
-- Index pour la table `associations_groupes`
--
ALTER TABLE `associations_groupes`
  ADD PRIMARY KEY (`id_groupe_parent`,`id_groupe`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_has_level_acces`
--
ALTER TABLE `group_has_level_acces`
  ADD PRIMARY KEY (`id_groupes`,`id_level_access`,`id_applications`);

--
-- Index pour la table `level_access`
--
ALTER TABLE `level_access`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `libelles`
--
ALTER TABLE `libelles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `libelles_trad`
--
ALTER TABLE `libelles_trad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_libelle` (`id_libelle`,`id_lookup_values`);

--
-- Index pour la table `lookup_values`
--
ALTER TABLE `lookup_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`,`value`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id_Texuel_et_Id_Appli` (`Id_Textuel`,`id_applications`),
  ADD KEY `index_parent_codelibelle` (`parent`,`code_libelle`);

--
-- Index pour la table `param_appli`
--
ALTER TABLE `param_appli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_param` (`code_param`,`id_applications`);

--
-- Index pour la table `typevaleur`
--
ALTER TABLE `typevaleur`
  ADD PRIMARY KEY (`id_typevaleur`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `typevaleur_items`
--
ALTER TABLE `typevaleur_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `id_typevaleur` (`id_typevaleur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT pour la table `level_access`
--
ALTER TABLE `level_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `libelles`
--
ALTER TABLE `libelles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;
--
-- AUTO_INCREMENT pour la table `libelles_trad`
--
ALTER TABLE `libelles_trad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=517;
--
-- AUTO_INCREMENT pour la table `lookup_values`
--
ALTER TABLE `lookup_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;
--
-- AUTO_INCREMENT pour la table `param_appli`
--
ALTER TABLE `param_appli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `typevaleur`
--
ALTER TABLE `typevaleur`
  MODIFY `id_typevaleur` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `typevaleur_items`
--
ALTER TABLE `typevaleur_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
