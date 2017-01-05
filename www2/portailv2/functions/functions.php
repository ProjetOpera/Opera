<?php
require_once("parametres.inc.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/librairie.inc.php");
// require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/debug.inc.php");


/* * ***************************************************************
 * ****** CONNEXION BDD PORTAIL
 * **************************************************************** */

function connexion_portail() {

    $DB_SERVER = "localhost";
    $SERVER_BASE = "portailv2";
    $SERVER_USER = "portailv2";
    $SERVER_PASSWORD = "Portailv2";

    $bdd = "mysql:host=$DB_SERVER;dbname=$SERVER_BASE;charset=UTF8";
    try {
        $connexion = new PDO($bdd, $SERVER_USER, $SERVER_PASSWORD);
    } catch (PDOException $error) {
        die("Erreur de connexion : " . $error->getMessage());
    }

    return $connexion;
}

/* * ***************************************************************
 * ****** CONNEXION BDD APPLIS
 * **************************************************************** */

function connexion_appli($id_appli, $ressourceBDD_portail) {

    $sql0 = "
			SELECT serveur_bdd, nom_bdd, user_bdd, password, type_serveur_bdd
			FROM applications
			WHERE id = '$id_appli'";

    $req0 = $ressourceBDD_portail->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_portail);
    $line = $req0->fetch(PDO::FETCH_ASSOC);
	$bdd = "";
	if ($line['type_serveur_bdd']=="SQLSERVER")
		$bdd = "sqlsrv:server={$line['serveur_bdd']}; Database={$line['nom_bdd']}";
	elseif ($line['type_serveur_bdd']=="MYSQL") 
		$bdd = "mysql:host={$line['serveur_bdd']};dbname={$line['nom_bdd']};charset=UTF8";
	
    try {
        $connexion = new PDO($bdd, $line['user_bdd'], $line['password']);
	
    } catch (PDOException $error) {
	       ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_portail);
        die("Erreur de connexion : " . $error->getMessage());
    }


    return $connexion;
}

/* * ***************************************************************
 * ****** CONNEXION BDD EXTERNE (INITIALISATION FICHIER DIFFERENT INDEX.PHP
 * **************************************************************** */

function connexion_externe($chemin_portail) {
    require_once($chemin_portail . "variables_" . $_SESSION['PORTAIL\lang'] . ".php");
    $ressourceBDD_portail = connexion_portail();
    $ressourceBDD_appli = connexion_appli($_SESSION['PORTAIL\id_appli'], $ressourceBDD_portail);
    return $ressourceBDD_appli;
}

/* * ***************************************************************
 * ****** HEADER HTML
 * **************************************************************** */

function header_top($titre) {
?>
	<!DOCTYPE html>
	<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
	<html	xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
	<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title><?php echo $titre;?></title>

	<!-- APPEL FICHIERS CSS -->
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/template.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/sliding-panel.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/jquery.fancybox-1.3.4.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/datepicker.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/tablesorter.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/administration.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/menu.css' />
	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/jquery-ui-1.8.22.custom.css' />
	<link rel='stylesheet' type='text/css' href='CSS/style.css' />



	<link rel='stylesheet' type='text/css' href='/portailv2/CSS/style.css' />

	<!-- APPEL FICHIERS JAVASCRIPT -->
	<script language='javascript' src='/portailv2/javascript/js/jquery-1.7.2.min.js' type='text/javascript'></script>
	<script language='javascript' src='/portailv2/javascript/js/jquery-ui-1.8.22.custom.min.js' type='text/javascript'></script>
	<script language='javascript' src='/portailv2/javascript/jquery.fancybox-1.3.4.pack.js' type='text/javascript'></script>
	<script language='javascript' src='/portailv2/javascript/tablesorter.js' type='text/javascript'></script>
	<script language='javascript' src='/portailv2/javascript/verif.js' type='text/javascript'></script>
	<script language='javascript' src='/portailv2/javascript/search_in_header.js' type='text/javascript'></script>


	<!--
	************************************************************************************
	***************  JQUERY ************************************************************
	-->
	<script type="text/javascript"><!--
		jQuery(document).ready(function(){
			$('.various1').fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'overlayOpacity'	:	'0.85'
			});
			$('.trigger').click(function(){
				$('.panel').toggle('fast');
				$(this).toggleClass('active');
				return false;
			});
			$('div.panel').mouseleave(function () {
				$('.panel').hide();
				$('.trigger').removeClass('active');
				return false;
			});

		})
	<!-- CONVERSION DATEPICKER FR/EN -->
<?php
	if ($_SESSION['PORTAIL\lang'] == 'FR') {
?>
		$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
		closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
		prevText: '&lt;Pr&eacute;c', prevStatus: 'Voir le mois pr&eacute;c&eacute;dent',
		nextText: 'Suiv&gt;', nextStatus: 'Voir le mois suivant',
		currentText: 'Courant', currentStatus: 'Voir le mois courant', 
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin', 'Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Jan','F&eacute;','Mar','Avr','Mai','Jun', 'Jul','Aou','Sep','Oct','Nov','D&eacute;c'],
		monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre ann&eacute;e',
		weekHeader: 'Sm', weekStatus: '',
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
		dateFormat: 'dd/mm/yy', firstDay: 0, 
		initStatus: 'Choisir la date', isRTL: false};
		$.datepicker.setDefaults($.datepicker.regional['fr']);
<?php
	}
?>
	--></script>
<?php
}

/* * ***************************************************************
 * ****** BANNIERE DECONNEXION
 * **************************************************************** */

function banniere_deconnect($titre) {
    global $bienvenue_commun;
	global $Url_Web;
?>
    <div id='banniere'>
		<div id='titre'>
			<div id='titre1'>
				<span>Opera</span>
				&nbsp;<?php echo $titre;?>
			</div>
		</div>

		<div id='session'>
			<span><?php echo "$bienvenue_commun {$_SESSION['PORTAIL\prenom']} {$_SESSION['PORTAIL\nom']}";?>&nbsp;|&nbsp;<a href='http://<?php echo $Url_Web;?>/portailv2/logout.php' title='D&eacute;connexion'>D&eacute;connexion</a></span>
	
			<!--
					Zone d'affichage de recherche diverse
					Cette zone de recherche est geree dans une fonction JAVASCRIPT decrite dans le fichier www2/portialV2/javascript/search_in_header.js
			-->
    	</div>
    </div>
	<!-- pour fenetre "Dialog" d'affichage de recherche de contact -->
    <div id="DialogAfficheContact" style="margin:auto;"></div>
<?php
}

/* * ****************************************************************
 * ******* INFO BULLE MENU
 * ***************************************************************** */

function infobulle($connexion) {
	global $Url_Web;
?>
	<div class='panel'>
		<a href='http://<?php echo $Url_Web;?>/portailv2/' title='Portail Opera'>Portail Opera</a>
<?php
    $sql1 = "
				SELECT id,nom_categorie,couleur_categorie
				FROM  categories
				ORDER BY nom_categorie";
    $result1 = $connexion->query($sql1);
        
    while ($line1 = $result1->fetch(PDO::FETCH_ASSOC)) {
        $sql2 = "
					SELECT DISTINCT id, nom_appli,url_appli, interne
					FROM applications, group_has_level_acces ghla, associations_contacts_groupes asg
					WHERE id_categories=".$line1['id']."
					AND applications.id = ghla.id_applications
					AND ghla.id_groupes = asg.id_groupes
					AND asg.id_contacts = ".$_SESSION['PORTAIL\id']."
					ORDER BY nom_appli";
        $result2 = $connexion->query($sql2);
        
        if ($result2->rowCount()>0){
?>
			<div class='categorie' style='color:#<?php echo $line1['couleur_categorie'];?>'><?php echo$line1['nom_categorie'];?></div>
<?php
			while ($line2 = $result2->fetch(PDO::FETCH_ASSOC)) {
?>
				<ul class='apps'>
<?php
				if (isset($_SESSION[$line2['url_appli'].'\level'])) {
					$lien_url = ($line2['interne']==0) ? $line2['url_appli'] : "/".$line2['url_appli'];
?>
					<li><a href='<?php echo $lien_url;?>'><?php echo $line2['nom_appli'];?></a></li>
<?php
				}
?>
				</ul>
<?php			}
		}

	}
?>
	</div>
	<div style='clear:both'></div>
	<a class='trigger' href='#'>Menu</a>
<?php
	// --> FIN INFO BULLE MENU
}

/* * ***************************************************************
 * ****** MENU DYNAMIQUE
 * **************************************************************** */

function recursive_menu_template($id_appli, $id_parent, $class_menu, &$parent, $ressourceBDD_portail, $menu_actuel) {
    //global $connexion;
    $contenu = '';
    $contenu_2 = '';
    $parent = '';
    $parent_2 = '';
    $sql0 = "
		SELECT menus.id, traduction, ordre, level, url_appli
		FROM menus, libelles_trad, applications, lookup_values, level_access
		WHERE menus.code_libelle = libelles_trad.id_libelle
		AND applications.id = " . $id_appli . "
		AND menus.id_applications = applications.id
		AND libelles_trad.id_lookup_values = lookup_values.id
		AND lookup_values.value='FR'
		AND lookup_values.type='langue'
		AND parent=$id_parent
		AND menus.id_level=level_access.id
		ORDER BY ordre";
    $req0 = $ressourceBDD_portail->query($sql0);

    if ($req0->rowCount() > 0) {
        $contenu = "<ul $class_menu>\n";
        $parent = "class='parent'";
        while ($line0 = $req0->fetch(PDO::FETCH_ASSOC)) {
        	$nom_appli=$line0['url_appli'];
            $contenu_2 = recursive_menu_template($id_appli, $line0['id'], '', $parent_2, $ressourceBDD_portail, $menu_actuel);
            
			// Affichage des menus si level autorise
            if ($line0['level']<=$_SESSION["$nom_appli\level"]) {
				
				// menu actuel => fond blanc
				$current = ($line0['id']==$menu_actuel) ? "class='current'" : ""; 
								
				$contenu .= "<li $current><a href='id_menu={$line0['id']}'><span>".htmlentities($line0['traduction'], ENT_QUOTES, "UTF-8")."</span></a>\n";
				$contenu.=$contenu_2;
            }
        }
        $contenu .= "</ul>\n";
    }
    return $contenu;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/* * ***************************************************************
 * ****** MENU
 * **************************************************************** */
function template_menu_commun($var_menu, $admin) {
    global $page;
?>
    <div id='menu'><ul>
<?php
    foreach ($var_menu as $key => $line) {

        if ($line[1] == "admin" && $admin == 1) {
            echo ($page == $key) ? "<li class='menu_on'><a href='?p=" . $key . "'>" . htmlentities($line[0], ENT_QUOTES) . "</a></li>\n" : "<li><a href='?p=" . $key . "'>" . htmlentities($line[0], ENT_QUOTES) . "</a></li>\n";
        }
		elseif ($line[1] == "") {
            echo  ($page == $key) ? "<li class='menu_on'><a href='?p=" . $key . "'>" . htmlentities($line[0], ENT_QUOTES) . "</a></li>\n" : "<li><a href='?p=" . $key . "'>" . htmlentities($line[0], ENT_QUOTES) . "</a></li>\n";
        }
    }
?>
    </ul></div>
<?php
}


/* * ***************************************************************
 * ****** HEAD
 * **************************************************************** */

function header_template_css($titre) {
?>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title><?php echo $titre;?></title>
	<link rel='stylesheet' type='text/css' href='../commun/CSS/template.css' />
	<link rel='stylesheet' type='text/css' href='../commun/CSS/sliding-panel.css' />
	<link rel='stylesheet' type='text/css' href='../commun/CSS/jquery.fancybox-1.3.4.css' />
	<link rel='stylesheet' type='text/css' href='../commun/CSS/datepicker.css' />
	<link rel='stylesheet' type='text/css' href='../commun/CSS/tablesorter.css' />
	<link rel='stylesheet' type='text/css' href='../commun/CSS/administration.css' />
<?php
}

function header_template_js($titre) {
?>
	<script language='javascript' src='../commun/javascript/jquery-1.6.4.js' type='text/javascript'></script>
	<script language='javascript' src='../commun/javascript/jquery.fancybox-1.3.4.pack.js' type='text/javascript'></script>
	<script language='javascript' src='../commun/javascript/datepicker.js' type='text/javascript'></script>
	<script language='javascript' src='../commun/javascript/tablesorter.js' type='text/javascript'></script>
<?php
	if ($_SESSION['PORTAIL\lang'] == 'FR') {
?>
		<script language='javascript'>
			jQuery(function($){
			$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
			closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
			prevText: '&lt;Pr&eacute;c', prevStatus: 'Voir le mois pr&eacute;c&eacute;dent',
			nextText: 'Suiv&gt;', nextStatus: 'Voir le mois suivant',
			currentText: 'Courant', currentStatus: 'Voir le mois courant',
			monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
			'Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
			monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
			'Jul','Aou','Sep','Oct','Nov','Déc'],
			monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre ann&eacute;e',
			weekHeader: 'Sm', weekStatus: '',
			dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
			dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
			dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
			dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
			dateFormat: 'dd/mm/yy', firstDay: 0, 
			initStatus: 'Choisir la date', isRTL: false};
			$.datepicker.setDefaults($.datepicker.regional['fr']);
			});

			$(document).ready(function() { 
				$('.trigger').click(function(){
					$('.panel').toggle('fast');
					$(this).toggleClass('active');
					return false;
				});
			});
		</script>
<?php
	}
}

/* * ***************************************************************
 * ****** BANNIERE
 * **************************************************************** */

function banniere($titre, $nom, $prenom, $deconnexion) {
    include("../portail/variables_" . $_SESSION['PORTAIL\lang'] . ".php");
    global $Web_Serveur;
?>
    <div id='banniere'>
    <div id='titre'>
    	<div id='titre1'>
    		<span>Opera</span>
    		&nbsp;<?php echo $titre;?>
    	</div>
    </div>


    <div id='session'>
		<span><?php echo "$bienvenue_commun {$_SESSION['PORTAIL\prenom']} {$_SESSION['PORTAIL\nom']}";?>&nbsp;|&nbsp;<a href='http://<?php echo $Web_Serveur;?>/portail/logout.php' title='D&eacute;connexion'>D&eacute;connexion</a></span>
    	</div>
    </div>
<?php
}

function confirm_suppr($id, $chemin, $form_demande_confirm_suppr, $form_input_id, $form_checkbox) {
	$oui = "oui";
	$non = "non";
?>
	<html><head>
		<meta charset=utf-8' />
	</head><body><div style='text-align:center'>
	<form method='POST' action='<?php echo $chemin;?>'>
	<input id='<?php echo $form_input_id;?>' name='<?php echo $form_input_id;?>' type='hidden' value='<?php echo $id;?>'/>
	<p><?php echo $form_demande_confirm_suppr;?></p>
	<p>
		<input id='<?php echo $form_checkbox?>' name='<?php echo $form_checkbox;?>' type='radio' value='1'/><?php echo $oui;?>
		<input id='<?php echo $form_checkbox?>' name='<?php echo $form_checkbox;?>' type='radio' value='0' checked='checked'/><?php echo $non;?>
	</p>
	<input type='submit'/>
	</form>
	</div></body></html>
<?php
}
/******************************************************************************************
 * Fonction : getInternalUrl (                                                            *
 *                    PDO <connexion>,                                                    *
 *                    String <NomAppli>,                                                  *
 *                    String <id_Textuel_Menu>                                            *
 *                    array <paramCompl> = null)                                          *
 *                                                                                        *
 *   Fournir l'URL d'un module sous forme de <Non Module>/id_menu=<id>[&<param>[...]]     *
 *   à partir des arguments fournis en entrée. La valeur « id_menu » est l’identifiant    *
 *   du menu qui contient <id_Textuel_Menu> fourni en entrée                              *
 *                                                                                        *
 * Argument d'entrée :                                                                    *
 *                                                                                        *
 *    - <connexion> : Objet PDO de connexion a la base de données MYSQL                   *
 *                                                                                        *
 *    - <NomAppli> : Nom de l'application à appeler                                       *
 *                     Ex : SHIVA                                                         *
 *                                                                                        *
 *    - <id_Textuel_Menu> : Identifiant textuel du menu                                   *
 *                                                                                        *
 *    - <paramCompl> : tableau contenant des paramètres complémentaire de la fonction.    *
 *                     Il est de la forme :                                               *
 *                     array (<NomParam1> => <ValeurParam1>,                              *
 *                            <NomParam2> => <ValeurParam2>,                              *
 *                            .....)                                                      *
 *                                                                                        *
 * Argument de sortie : Chaine de caractères de la forme :                                *
 *     <NomAppli>/id_menu=<id_menu>&<NomParam1>=<ValeurParam1>&NomParam2>=<ValeurParam2>  *
 *                                                                                        *
 *       exemple : SHIVA/id_menu=155&application=START                                    *
 *                                                                                        *
 *****************************************************************************************/

function getInternalUrl ($connexion, $nomAppli, $idTextuelMenu, $paramCompl=NULL) {

	$query = "
		SELECT portailV2.menus.id AS idMenu, portailV2.applications.url_appli urlAppli
		FROM portailV2.Menus
		LEFT JOIN portailV2.applications ON portailV2.applications.id = portailV2.menus.id_applications
		WHERE	portailV2.Menus.id_textuel = '$idTextuelMenu'
			AND	portailV2.applications.nom_appli = '$nomAppli'
		";
	$req = $connexion->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $connexion);

	$line = $req->fetch(PDO::FETCH_ASSOC);
	if (!$line) {
		die ('<br>Error SQL in file <B>"'.__FILE__.'"</B> on Ligne <B>'.__LINE__.'</B><BR><BR>Menu "'.$menuLabel.'" non trouve dans le module "'.$module.'<BR>Query = '.$query);
	}

	$url = rawurlencode($line['urlAppli'])."/id_menu={$line['idMenu']}";
	
	if (isset ($paramCompl)) {
		foreach ($paramCompl as $nomParam => $valParam) 
			$url .= "&$nomParam=".rawurlencode($valParam);
	}

	return $url;
}

/******************************************************************************************
 * Fonction : serviceping (  $host, $port , $timeout ) => permet de savoir si un serveur repond aux requetes LDAP AD                                                          *
 ******************************************************************************************/
function serviceping($host, $port=389, $timeout=1)
{
    $op = fsockopen($host, $port, $errno, $errstr, $timeout);
    if (!$op) 
	{
		return 0; //DC is N/A
	}
    else 
	{ 
		fclose($op); //explicitly close open socket connection
		return 1; //DC is up & running, we can safely connect with ldap_connect
    }
}

?>