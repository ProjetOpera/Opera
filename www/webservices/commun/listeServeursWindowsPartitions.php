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

$query="select 
	b.nom_serveur,
	b.os,
cv.volume,
cv.capacite_go,
cv.disponible_go,
cv.espace_libre_pourcent,
b.date_releve
from
    inv_datacenter.biens b,
    inv_datacenter.ctrl_volumes cv,
	(select b1.nom_serveur, max(b1.date_releve) as date_releve from inv_datacenter.biens b1 group by b1.nom_serveur) maxreleve
where cv.id_bien = b.id
and  ( maxreleve.nom_serveur = b.nom_serveur and maxreleve.date_releve = b.date_releve)
and  b.type like '/UC/Serveur%'
and  cv.volume not like '%Volume{%'
and  cv.volume != ''
and b.statut in ('Normal' , 'En cours de mise en prod',
        'A déclasser',
        'A déclasser - Non facturable')
and upper(b.os) like '%WINDOW%' 
order by nom_serveur,cv.volume asc";

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