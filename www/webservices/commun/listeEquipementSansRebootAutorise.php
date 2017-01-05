<?php

require("../_librairies/librairie.php");
require("parametres.inc.php");
require("librairies.php");

/* aide */
$tabAide=array();
$tabAide["sortie"]="Sortie du webservice (XML/JSON/CSV)(par d&eacute;faut : XML)";
$tabAide["lot"]="B1 ou B2 (par d&eacute;faut : B1)";
$tabAide["type"]="SERVEURS ou POSTES (par d&eacute;faut : SERVEURS)";
$tabAide["mode"]="Mode de traitement du webservice (AIDE pour afficher cette aide/{vide}) pour afficher les donn&eacute;es)(par d&eacute;faut : {vide})";

/* parametres en entree */
$sortie=isset($_REQUEST["sortie"])?strtoupper($_REQUEST["sortie"]):"XML";
$lot=isset($_REQUEST["lot"])?strtoupper($_REQUEST["lot"]):"B1";			
$mode=isset($_REQUEST["mode"])?strtoupper($_REQUEST["mode"]):"";
$type=isset($_REQUEST["type"])?strtoupper($_REQUEST["type"]):"SERVEURS";


				
if ( $mode == "AIDE")
{
	afficherAide(__FILE__,$tabAide);
	exit();
}

$lignes=null;
switch ( $type )
{
	case "SERVEURS" :
					
					//pour la requete SQL on recupere la derniere lettre du lot	
					$lot = substr(trim($lot),-1);	
					$conn = mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);
					$query = "select b.netbios,b.statut,b.role,b.situationsi,b.os
					from commun.bien b, reboots.exclusionreboot er
					where b.netbios = er.serveur
					and b.categorie like '/UC/Serveur%'
					and b.statut in ('Normal', 'En cours de mise en prod')
					and b.attribute1_texte like '%".$lot."'
					order by netbios asc";
					$stmt=$conn->query($query);
					$lignes=$stmt->fetchAll(PDO::FETCH_ASSOC);
					
					break;
	case "POSTES" :
					//rien à exclure
					$lignes=null;
					break;
	default :
					//rien à exclure
					$lignes=null;
					break;
}


switch ( $sortie )
{
	case "CSV" :
				print array2csv($lignes);
				break;
	case "JSON" :
				echo array2json($lignes);
				break;
	default : 
				header('Content-type: text/xml');
				print array2xml($lignes,false,"equipement");
				break;
}
		
	



?>