<?php
if (!isset($_GET['a']) && empty($_GET['a']) && empty($_POST)) {
session_start();
//header('Expires: Sun, 19 Nov 1978 05:00:00 GMT');
//header('Cache-Control: no-store, no-cache, must-revalidate');
//header('Pragma: no-cache');
require_once("connect.php");
require_once("functions/functions.php");
$lang = (isset($_GET['l']) && $_GET['l']=="EN") ? "EN" : "FR";
require_once("variables_$lang.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>ATOS | Portail Opera</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<html lang="fr" xml:lang="fr" />
	<link rel="stylesheet" href="CSS/template.css" type="text/css" />
	<link rel="stylesheet" href="CSS/authentication.css" type="text/css" />
	<script language="javascript" src="javascript/verif.js" type="text/javascript"></script>

	<script>
	function setfocus() {	
		document.getElementById("login").focus();
	}
	</script>
</head>
<body onload="setfocus();">

<div id="corps">

<!-- DETECTION JAVASCRIPT -->
<noscript>
	<div style="font-size:16px; text-align:center;color:#bb0000"><strong><u>ATTENTION :</u><br />Le javascript n'est actuellement pas activ&eacute; sur votre navigateur !<br />
	Merci de l'activer afin de pouvoir acc&eacute;der aux applications</strong></div>
</noscript> 


<div id="authentication">
	<div id="entete">
		<div id="flag">
			<a href="authentication.php" title="Français"><img src="images/flag_FR.jpg" /></a>
			<a href="authentication.php?l=EN" title="English"><img src="images/flag_EN.jpg" /></a>
		</div>
	</div>
	<div id="corps_auth">
		<div id="title"><?php echo $bienvenue; ?></div>
		
		<form name="authentication" method="post" action="?a=1" onsubmit="javascript:return verif_auth(document.forms['authentication'])">
		<input type="hidden" name="lang" value="<?php echo $lang; ?>" />
		<table align="center" cellspacing="" cellpadding="" border="0"><tbody>
			<tr>
				<td colspan="2"><div id="info" style="padding:3px"></div></td>
			<tr>
				<td style="text-align:right"><?php echo $login; ?></td>
				<td><input class="input" type="text" name="login" id="login" style="width:150px" value="" /></td>
			</tr>
			<tr>
				<td style="text-align:right"><?php echo $pass; ?></td>
				<td><input class="input" type="password" name="password" style="width:150px" value="" /></td>
			</tr>
			<tr>
				<td colspan="2"><br />
					<input id="valid" type="submit" value="<?php echo $connect_button; ?>" />
				</td>
		</tbody></table>
		</form>
	</div>
</div>

</body>
</head>
</html>

<?php
}




/******************************************************************
****  VERIFICATION DROITS D'ACCES
*******************************************************************/
elseif (isset($_GET['a']) && $_GET['a']==1 && !empty($_POST['login']) && !empty($_POST['password'])) {
	session_start();
	header('Expires: Sun, 19 Nov 2022 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');
	require_once("connect.php");
	require_once("functions/parametres.inc.php");
	require_once ("librairie.php");
	
	$ldapbind = FALSE;
	$message = "";
	
	// Lecture des parametres transmis
	if (isset($_GET['Disconnect'])) {
		foreach ($_SESSION as $i => $value) {
			unset($_SESSION[$i]);
		}
	}
	else {
/**/
		$login = (isset($_POST['login'])?$_POST['login']:"");
		$password = (isset($_POST['password'])?$_POST['password']:"");
/**/	}
	// Connection ?a base mySQL
	//$link = myConnexion();

	
	//recherche d'un DC
	/*
	$dclist = gethostbynamel($Conf_LDAP_Domain);
	foreach ($dclist as $k => $dc) if (serviceping($dc) == true) break; else $dc = 0;


	if ( $dc )
	{
		echo "Connexion au LDAP $dc";
	}
	else
	{
		echo "Aucun DC n'est accessible";
	}
	*/

	if ($login<>"" && $password<>"") {
		// Authentification LDAP
		$loginAD=$Conf_Def_Dom."\\".$login;

		// Connexion au serveur LDAP (Active Directory)

		
		


			
		$ldap_server = "ldap://".$Conf_LDAP_Server;
		$ldapconn = ldap_connect($ldap_server);
	
		if ($ldapconn) {
			// Active directory requirement settings
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
			//ldap_set_option($ldapconn, LDAP_SCOPE_ONELEVEL, 0);
				
			// Verification de la validit couple login/password
			//$ldapbind = ldap_bind($ldapconn, $loginAD, $password); // Prod seulement
			$ldapbind = true; // Pour developpement
	
			//validite OK
			if ($ldapbind) {
				ldap_close($ldapconn);
				
				$sql1 = "
					SELECT C.id, prenom_contact, nom_contact
					FROM contacts C, associations_contacts_groupes acg
					WHERE login_contact = '$login'
					AND C.id = id_contacts";
				$result1 = $connexion->query($sql1);
					
				if ($result1->rowCount() > 0) {
					$line = $result1->fetch(PDO::FETCH_ASSOC);
					$_SESSION['PORTAIL\id'] = $line['id'];
					$_SESSION['PORTAIL\prenom'] = $line['prenom_contact'];
					$_SESSION['PORTAIL\nom'] = $line['nom_contact'];
					$_SESSION['PORTAIL\lang'] = $_POST['lang'];
					$_SESSION['PORTAIL\id_appli'] = -1;
					$_SESSION['portailv2\level'] = 100;

					// var_dump($_SESSION);
					 
					//1. reqête du (des) groupes du contact
          $req_groupes = "select distinct id_applications, level, url_appli 
	          from associations_contacts_groupes acg, group_has_level_acces ghla, level_access la, applications
	          where id_contacts =". $_SESSION['PORTAIL\id']."
	          and acg.id_groupes=ghla.id_groupes
	          and ghla.id_level_access=la.id
	          and ghla.id_applications=applications.id
	          order by id_applications, level desc";
          $result3 = $connexion->query($req_groupes);
          $id_previous=0;
          while ($line=$result3->fetch(PDO::FETCH_ASSOC)){
	          if ($line['id_applications']!=$id_previous) {
		          $nom_appli= $line['url_appli'];
		          $_SESSION["$nom_appli\level"]=$line['level'];
		          $id_previous=$line['id_applications'];
	          }
          }

					header("location: /portailv2/");
					exit;					
				}
				else echo "
					<html><head><meta http-equiv='Refresh' content='4; URL=../portailv2/'></head><body>
						<h3 style='text-align:center'><br />Votre identifiant n'est pas reconnu dans la base commune</h3>
						<h4 style='text-align:center'>redirection automatique...</h4>
						</body></html>";
			}
			else echo "
				<html><head><meta http-equiv='Refresh' content='4; URL=../portailv2/'></head><body>
						<h3 style='text-align:center'><br />Mot de passe associ&eacute; au login invalide</h3>
						<h4 style='text-align:center'>redirection automatique...</h4>
						</body></html>";
		}
		else echo "
			<html><head><meta http-equiv='Refresh' content='4; URL=../portailv2/'></head><body>
						<h3 style='text-align:center'><br />Impossible de se connecter &agrave; l'annuaire LDAP</h3>
						<h4 style='text-align:center'>redirection automatique...</h4>
						</body></html>";
	}
	else echo "
		<html><head></head><body>champs vides</body></html>";	
}
else echo "renseigner les champs login/password !<br /><a href='authentication.php'>Retour</a>";

?>