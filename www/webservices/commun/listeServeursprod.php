<META HTTP-EQUIV="expires" CONTENT="0">

<?php

require("librairies.php");
verification_connexion();

$query="SELECT 
		netbios,
		situationsi,
		statut,
		categorie,
		role,
		ifnull(ipadresse1,'') as ip ,
		ifnull(ipadmin,'') as ipadmin  
	FROM `bien` 
	WHERE `statut` in ( 'Normal','En cours de mise en prod') 
	AND `situationsi` in ('SI-SUPPORT', 'SI-GESTION') 
	and categorie like '/UC/Serveur%'
order by netbios asc";
$sql= mysql_query($query) or die("Error: " . mysql_error());

if (!$sql) {
	echo 'Impossible d\'exécuter la requête : $query => ' . mysql_error();
	exit;
}
else
{
	$fic='serveurs.csv';
	$f=fopen($fic,"w");
	fwrite($f,"netbios;situation si;statut;categorie;role;ip;");
	fwrite($f,"\n");

	while ( $result = mysql_fetch_array($sql))
	 {

		fwrite($f,$result[0]);
		fwrite($f,";");
		fwrite($f,$result[1]);
		fwrite($f,";");
		fwrite($f,$result[2]);
		fwrite($f,";");
		fwrite($f,$result[3]);
		fwrite($f,";");
		fwrite($f,$result[4]);	
		fwrite($f,";");
		fwrite($f,$result[5]);
		fwrite($f,";");
		fwrite($f,"\n");

	}

	
	fclose($f);
	echo "<a href='$fic?time=".mktime()."'>Fichier $fic</a>";
}

?>