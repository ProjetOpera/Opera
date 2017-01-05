<?php
//Auteur : SRX
//Date   : 17/11/2014
header("Content-type: text/csv"); 

require("librairies.php");
verification_connexion();
$query="
		SELECT  case 
			  when p.nom_programme  = 'Infrastructure et Services Partagés' then 'ISP'
			  when p.nom_programme = 'Gestion & Finances et Achats' then 'GFA'
			  when p.nom_programme = 'Gestion Finances Achats' then 'GFA'
			  when p.nom_programme = 'Outil industriel' then 'OI'
			  when p.nom_programme = 'Outils du Système Electrique' then 'OSE'
			  when p.nom_programme = 'Ressources Humaines' then 'RH'
			  when p.nom_programme like 'Clients Marché%' then 'CM'
			  else 'AUTRE'
			end as programme 
			,aa.application application
			,a.nomrte_application application_nom_long
			,a.nna_application
			,a.datedebut_application debut
			,a.datefin_application fin
	FROM 
	fm.annuaire_arte aa,
	commun.application a,
	commun.programme p
	where aa.nna = a.nna_application
	and   a.id_programme = p.id
	and	  now() between ifnull(a.datedebut_application,now()) and ifnull(a.datefin_application,now())
	order by a.nomrte_application asc";


$sql= mysql_query(utf8_decode($query)) or die("Error: " . mysql_error());

if (!$sql) {
	echo 'Impossible d\'exécuter la requête : $query => ' . mysql_error();
	exit;
}
else
{
	
	 while ( $result = mysql_fetch_array($sql))
	 {
		echo($result[0].";".$result[1].";".$result[2].";".$result[3].";".$result[4].";".$result[5].";"."\n");
	 }

}

?>