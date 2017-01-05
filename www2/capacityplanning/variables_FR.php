<?php
/*************************
* DATE : avril 2012
* AUTEUR : Kevin TONG
*************************/



/*****************************
****** VARIABLES FR **********
******************************/

$label_nom="Nom";
$label_prenom="Pr&eacute;nom";
$label_groupe="Groupe";
$label_level_acces = "Niveau d'accès";
$label_aucuneApplication = "Aucune application n'appartient au groupe";

// MENU
///////

$var_menu=array();
$var_menu[1][0] = "Applications";
$var_menu[2][0] = "Groupes Utilisateurs";
$var_menu[3][0] = "Catégories";
$var_menu[4][0] = "Libellés";

$var_menu[1][1] = "";
$var_menu[2][1] = "";
$var_menu[3][1] = "";
$var_menu[4][1] = "";

// SOUS MENU APPLICATIONS
$var_smenu1[1][0] = "Gestion";
$var_smenu1[2][0] = "Menu";
$var_smenu1[3][0] = "Parametres";

$var_smenu1[1][1] = "";
$var_smenu1[2][1] = "";
$var_smenu1[2][1] = "";

// APPLICATIONS
$libelle_nna_application="NNA/NNB";
$libelle_nom_application="Application";
$libelle_nom_programme="Programme";
$libelle_MAJ="Action";

// CONTACTS
$search_title_contact="Utilisateur";
$search_button="Rechercher";
$nouveau_contact_button="Nouvel utilisateur";
$detruire_contact_button="Supprimer l'utilisateur";
$tous_les_contacts_button="Tous les utilisateurs";
$message_erreur_login_existant="Un utilisateur avec ce login '%login_contact%' existe déjà !!!";
$message_info_manquantes="Tous les champs précédés d'un * doivent être renseignés et les adresses email dans un format valide !!!";
$message_contact_maj="L'utilisateur a été mis à jour";
$message_contact_creer="L'utilisateur a été créé";
$message_contact_supprimer="L'utilisateur a été supprimé !!!";
$libelle_maj_contact="Mettre à jour";
$libelle_creer_contact="Créer";
$libelle_nom_contact="Nom";
$libelle_prenom_contact="Prénom";
$libelle_type_contact="Fonction";
$libelle_email_contact="Email";
$libelle_tel_contact="Tél";
$libelle_ronde_contact="Ronde";
$libelle_nom_societe="Société";
$libelle_nom_equipe="Equipe";


//EQUIPES
$search_title_equipe="Equipe";
$search_button="Rechercher";
$nouveau_equipe_button="Nouvelle équipe";
$detruire_equipe_button="Supprimer l'équipe";
$tous_les_equipes_button="Toutes les équipes";
$message_erreur_equipe_existant="Une équipe avec ce login '%login_equipe%' existe déjà !!!";
$message_info_manquantes="Tous les champs précédés d'un * doivent être renseignés et les adresses email dans un format valide !!!";
$message_equipe_maj="L'équipe a été mis à jour";
$message_equipe_creer="L'équipe a été créée";
$message_equipe_supprimer="L'équipe a été supprimée !!!";
$libelle_maj_equipe="Mettre à jour";
$libelle_creer_equipe="Créer";
$libelle_nom_equipe="Nom";
$libelle_bal_equipe="Bal";

// TYPES VALEURS

define("LANG_GESTION_TYPES","Gestion des Types");
define("LANG_GESTION_VALEURS","Gestion des Valeurs");
define("LANG_NOUVEAU","Nouveau");
define ("LANG_EDIT","Edit.");
define ("LANG_SUPPR","Suppr.");
define ("LANG_EXIT","Fermer");
define ("LANG_SUBMIT","Enregistrer");
define ("LANG_CODE","Code");
define("LANG_DEFAULT","Defaut");
define("LANG_DESCRIPTION","Description");
define("LANG_CONFIRM_SUPPRR","Souhaitez vous supprimer");
define("LANG_ACTIVE","Activé");
define("LANG_LIB_FR",'Traduction FR');
define("LANG_LIB_EN",'Traduction EN');
define("LANG_DEFAUT","Défaut");
//ERROR
define('LANG_WS_SOAP_ERROR','Erreur WS SAOP');
define("MSG_100","Ce code existe déjà");
define("MSG_102","");
define("MSG_103","");
define("MSG_105","Caractères non autorisés");
define("MSG_120","");
define("MSG_121","");
define("MSG_122","");
define("MSG_123","");
define("MSG_140","Ce code existe déjà");
define("MSG_141","Caractères non autorisés");
define("MSG_143","");
define("MSG_146","desactivation");
define("MSG_147","Ce mail est déjà utilisé");
define("MSG_180","");
define("MSG_200","Tous les champs marqués d’un * doivent être  renseignés.");
define("MSG_201","Le numéro de fiche £NUMFICHE£ n’existe pas dans Service Manager");
define("MSG_220","Une valeur existe déjà avec le code £CODE£ pour le type £TYPE£");

// SUCCESS
define("MSG_101","");
define("MSG_104","");
define("MSG_124","");
define("MSG_142","");
define("MSG_144","");
define("MSG_145","activation");

?>