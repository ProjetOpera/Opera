<?php

require("../_librairies/librairie.php");
require("parametres.inc.php");
require("librairies.php");

/* aide */
$tabAide=array();
$tabAide["sortie"]="Sortie du webservice (XML/JSON/CSV)(par d&eacute;faut : XML)";
$tabAide["mode"]="Mode de traitement du webservice (AIDE pour afficher cette aide/{vide}) pour afficher les donn&eacute;es)(par d&eacute;faut : {vide})";

/* parametres en entree */
$sortie=isset($_REQUEST["sortie"])?strtoupper($_REQUEST["sortie"]):"XML";
$mode=isset($_REQUEST["mode"])?strtoupper($_REQUEST["mode"]):"";


if ( $mode == "AIDE" )
{
	afficherAide(__FILE__,$tabAide);
	exit();
}



$conn = mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);

$query="select b.netbios,b.statut,b.role,b.situationsi,b.os,idb.sccm_date_reboot 
from commun.bien b left outer join inv_datacenter.biens idb on b.netbios = idb.nom_serveur and idb.date_releve  > date_add(now(), INTERVAL -1 DAY)
where b.categorie like '/UC/Serveur%'
and b.statut in ('Normal', 'En cours de mise en prod','A déclasser','A déclasser - Non facturable')
and upper(b.os)  like '%WINDOW%'
order by netbios asc";

$stmt=$conn->query($query);
$lignes=$stmt->fetchAll(PDO::FETCH_ASSOC);


switch ( $sortie )
{
	case "XML" :
				header('Content-type: text/xml');
				print array2xml($lignes,false,"serveur");
				break;
	case "CSV" :
				print array2csv($lignes);
				break;
	default : 
				echo array2json($lignes);
				break;
}
		
	



?>