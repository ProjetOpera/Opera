<?php
	require("../_librairies/librairie.php");
	include("../_librairies/parametres.inc.php");
	
	//aide
	$tabAide=array();
	$tabAide["sortie"]="Sortie du webservice (XML/JSON)(par d&eacute;faut : JSON)";
	$tabAide["mode"]="Mode de traitement du webservice (AIDE pour afficher cette aide/{vide}) pour afficher les donn&eacute;es)(par d&eacute;faut : {vide})";
	
	$sortie=isset($_REQUEST['sortie'])?strtoupper($_REQUEST['sortie']):"JSON";
	
	if ( $_REQUEST['mode'] == "AIDE" )
	{
		afficherAide(__FILE__,$tabAide);
		exit();
	}
	
	$requete = "SELECT DISTINCT unite,personne,personne_email FROM commun.annuaire_arfsi WHERE fonction = 'ARSI' OR fonction = 'ARSI / CSSI'";
				
	$conn = mysqlConnexion('localhost', 3306 , 'commun', 'commun', 'commun');

	$stmt=$conn->query($requete) or ErrorPdo (__FILE__, __LINE__, $requete, $conn);
	$lignes=$stmt->fetchAll(PDO::FETCH_ASSOC);

	switch ( $sortie )
	{
		case "XML" :
					header('Content-type: text/xml');
					print array2xml($lignes);
					break;
		default : 
					echo array2json($lignes);
					break;
	}			

?>