<?php
session_start();
require_once("../../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../../portailv2/');

// variables
$titre = "Listes des utilisateurs du groupe";
$aucun_utilisateur = "- Aucun utilisateur dans ce groupe -";

if (isset($_GET['id_menu']) && isset($_GET['id'])) {
	
	$sql = "
		SELECT nom_contact, prenom_contact 
		FROM contacts, associations_contacts_groupes acg
		WHERE id = id_contacts
		AND id_groupes = ".$_GET['id'];
	$req = $ressourceBDD_appli->query($sql);
	
	echo "<!doctype html><html><body>";
	echo "<h1>$titre</h1>";
	echo "<table align='center'><tbody>";
	
	if ($req->rowCount()==0) echo "<div style='text-align:center'>$aucun_utilisateur</div>";
	
	else {
		while($line = $req->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			echo "	<td>".$line['nom_contact']."</td><td>".$line['prenom_contact']."</td>";
			echo "</tr>";
		}
	}
	echo "</tbody></table>";
	echo "</body></html>";
	
}

?>