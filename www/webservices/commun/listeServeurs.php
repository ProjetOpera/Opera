<?php

/************************   E N   C O U R S   A U   1 0 / 0 4 / 2 0 1 5   ************************/


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



$conn = oraconnexionTNS2($itacTNS, $itacUser,$itacPwd);

$query="select a.barcode \"barcode\" ,m.fullname \"fullname\"
from amasset a,
     ammodel m,
     amportfolio apf
where a.lmodelid = m.lmodelid
and   apf.lastid = a.lastid
and   m.fullname like '/UC/Serveur%'
and   a.status in ( 'Normal','En cours de mise en prod')
and   apf.seassignment = 0
and   a.barcode is not null
and   apf.rtesituationcomptable in ('SI-SUPPORT','SI-GESTION','SI-MI')
order by a.barcode asc";

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