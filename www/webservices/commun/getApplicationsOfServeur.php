<?php

	require("../_librairies/librairie.php");
	include("../_librairies/parametres.inc.php");
	// include("../_librairies/debug.inc.php");
	
	//aide
	$tabAide=array();
	$tabAide["netbios"]="Netbios du serveur (Obligatoire)";
	$tabAide["sortie"]="Sortie du webservice (XML/JSON)(par d&eacute;faut : JSON)";
	$tabAide["mode"]="Mode de traitement du webservice (AIDE pour afficher cette aide/{vide}) pour afficher les donn&eacute;es)(par d&eacute;faut : {vide})";
	
	// filtre
	$filtre['netbios'] = $_REQUEST['netbios'];

	if (!isset($_REQUEST['netbios'])) {
		message("Netbios non renseigné !!<br><br>","erreur");
		afficherAide(__FILE__,$tabAide);
		return;
	}

	
	$sortie=isset($filtre['sortie'])?strtoupper($filtre['sortie']):"JSON";

	if ( $filtre['mode'] == "AIDE" )
	{
		afficherAide(__FILE__,$tabAide);
		exit();
	}
	
	
	$requete = "SELECT	bav.netbios NETBIOS,
						bav.nna_application NNA_APPLICATION,
						bav.nomrte_application NOM_RTE_APPLICATION,
						bav.nom_application NOM_APPLICATION,
						bav.datedebut_application DATEDEBUT_APPLICATION,
						bav.datefin_application DATEFIN_APPLICATION,
						p.nom_programme NOM_PROGRAMME,
						p.synchro_date SYNCHRO_DATE
					FROM commun.bien_application_v bav,
						 commun.programme p
					WHERE bav.netbios='{$_REQUEST['netbios']}' AND
						  p.id = bav.id_programme
					ORDER BY bav.nomrte_application ASC
				";

	$conn = mysqlConnexion('localhost', 3306 , 'root', 'fjMk2y6L', 'commun');

	$stmt=$conn->query($requete) or ErrorPdo (__FILE__, __LINE__, $requete, $conn);
	$lignes=$stmt->fetchAll(PDO::FETCH_ASSOC);

	switch ( $sortie )
	{
		case "XML" :
					header('Content-type: text/xml');
					//echo $requete;
					print array2xml($lignes);
					break;
		default : 
					echo array2json($lignes);
					break;
	}
?>
