<?php
session_start();

	//************************************************************************************
	//*************** REDIRECTION PORTAIL AUTHENTIFICATION *******************************
	//************************************************************************************
	if (empty($_SESSION['PORTAIL\id'])) {
		header('Expires: Sun, 19 Nov 1978 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');

		header("location: /portailv2/authentication.php");
		return;
	}


	//************************************************************************************
	//**************** UTILISATEUR CONNECTE **********************************************
	//************************************************************************************
	require_once("variables_".$_SESSION['PORTAIL\lang'].".php");
	require_once("functions/functions.php");
		
	// Connexion a la base PORTAIL
	$ressourceBDD_portail=connexion_portail();  
	
	/******************************************************************
	******** AFFICHAGE DES MODULES
	*******************************************************************/
	$nom_appli = (isset($_GET['nom_appli'])) ? $_GET['nom_appli'] : "portailv2";

	// REQUETE : PAGE NON PAR DEFAUT (id_menu != NULL)
	if( isset($_GET['id_menu'])) {
		$sql1 = "
			SELECT app.id AS AppId, menus.id AS MenusId, url, nom_appli, url_appli
			FROM applications app, menus
			WHERE url_appli = '".$nom_appli."'
			AND menus.id = ".$_GET['id_menu']."
			AND app.id = id_applications";
	}
	
	// REQUETE : PAGE PAR DEFAUT
	else {
		$sql1 = "
			SELECT app.id AS AppId, menus.id AS MenusId, url, nom_appli,url_appli
			FROM applications app, menus
			WHERE url_appli = '".$nom_appli."'
			AND app.id = id_applications
			AND defaut = 1";	
	}
  
  //echo $sql1;
  
	$req_tum = $ressourceBDD_portail->query($sql1);
	$line_tum = $req_tum->fetch(PDO::FETCH_ASSOC);

	// initialisation variables (a reutiliser dans les modules !!!)
	// ********************************************************************
	// Traiter l'URL avec des arguments URL=module?arg1&arg2&...
	list ($url, $arg) = explode ("?", $line_tum['url']);
	//Parser les arguements
	if ($arg) {
		parse_str($arg, $argArray);
		//Concatainer les arguments avec $_GET
		$_GET += $argArray;
	}
	
	$__commun_id_appli= $line_tum['AppId'];
	$__commun_id_menu= $line_tum['MenusId'];
	
	if($nom_appli!="portailv2") {
		if (!isset($_SESSION["$nom_appli\level"])) {
			header('Location:/portailv2');
			exit;
		}
		$ressourceBDD_appli = connexion_appli ($__commun_id_appli,$ressourceBDD_portail);
		$_SESSION['PORTAIL\id_appli'] = $__commun_id_appli;
	}
	
	// TITRE DU MODULE
	$sql_titre = "SELECT nom_appli FROM applications WHERE url_appli='".$_GET['nom_appli']."'";
	$req_titre = $ressourceBDD_portail->query($sql_titre);
	$titre = ($req_titre->rowCount() == 0) ? "Portail" : $req_titre->fetch(PDO::FETCH_COLUMN,0);

	ob_start();
	
	// INCLUSION DU .PHP DU MENU
	if ($url) include("../".$line_tum['url_appli']."/include/".$url);	
	$html = ob_get_contents();
	ob_end_clean ();
	
	
	
	//header('Expires: Sun, 19 Nov 1978 05:00:00 GMT');
	//header('Cache-Control: no-store, no-cache, must-revalidate');
	//header('Pragma: no-cache');
	

	//appel ENTETE
	header_top($titre);
?>
	</head>
	<body>
<?php
	// appel BANNIERE DE DECONNEXION
	banniere_deconnect($titre);
		
	
	// INFO BULLE MENU
	infobulle($ressourceBDD_portail);
	
	// CONSTRUCTION DU MENU
	// *************************************
	$parent = '';
	$current = "class='menu_on'";
?>
	<div id='menu'>
	<?php echo recursive_menu_template($__commun_id_appli,-1,"class='menu'",$parent,$ressourceBDD_portail, $__commun_id_menu);?>
	</div>
	
	
	<!-- CORPS DE PAGE
		 ************************************* -->
	<div id='corps'>
	<?php echo $html;?>
	</div>
	</BODY>
	</HTML>
