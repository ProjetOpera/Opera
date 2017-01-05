<html>
<head>
<META HTTP-EQUIV="expires" CONTENT="0">
<style>
	body,td{
		font : 11px verdana;
	}
	.tr0 { background-color : #AAAAAA;}
	.tr1 { background-color : #DDDDDD;}
	th { font : 14px arial;}
	.tdc { text-align : center;}
</style>
</head>
<body>
<?php

require("librairies.php");

$filtre = isset($_GET["serveur"])?$_GET["serveur"]:"";
$filtre = trim($filtre);

verification_connexion();
$query="select b.netbios,
	   b.statut,
	   b.categorie,
	   b.os,
	   b.role,
	   app.nna_application,
	   app.nom_application,
	   b.attribute1_texte as crb,
	   m.nom_modele
from bien b left outer join 
	( select nna_application,nom_application,lba.id_bien 
	  from  lien_bien_application lba,
			application a 
	  where a.id = lba.id_application
	  and curdate() between lba.datedebut and ifnull(datefin,curdate())
	 ) app on b.id = app.id_bien,
	 modele m
where m.id = b.id_modele
and b.statut in ('Normal', 'En cours de mise en prod','A déclasser')
/*and b.categorie like '/UC/Serveur%'*/
and b.netbios like '".$filtre."%'
order by b.netbios asc, app.nom_application asc";

$sql= mysql_query($query) or die("Error: " . mysql_error());

if (!$sql) {
	echo 'Impossible d\'exécuter la requête : $query => ' . mysql_error();
	exit;
}
else
{
	echo "<table border=1 cellspacing=0 cellpadding=5>";
	echo "<thead>";
	echo "	<th>CI bien</th>";
	echo "	<th>Etat</th>";
	echo "	<th>OS</th>";
	echo "	<th>Rôle</th>";
	echo "	<th>NNA/NNB</th>";
	echo "	<th>Application</th>";
	echo "	<th>CRB</th>";
	echo "	<th>Categorie</th>";
	echo "	<th>Modèle</th>";
	echo "</thead>";
	
	$cptligne=1;
	while ( $ligne = mysql_fetch_assoc($sql) )
	 {
		
		echo "<tr class='tr".($cptligne%2)."'>";
		echo "<td>".$ligne["netbios"]."</td>";
		echo "<td class='tdc'>".$ligne["statut"]."</td>";
		echo "<td>".$ligne["os"]."</td>";
		echo "<td class='tdc'>".$ligne["role"]."</td>";
		echo "<td class='tdc'>".$ligne["nna_application"]."</td>";
		echo "<td>".$ligne["nom_application"]."</td>";
		echo "<td>".$ligne["crb"]."</td>";
		echo "<td>".$ligne["categorie"]."</td>";
		echo "<td>".$ligne["nom_modele"]."</td>";
		echo "</tr>";
		$cptligne++;
	}
	echo "</table>";
}
?>
</body>
</html>