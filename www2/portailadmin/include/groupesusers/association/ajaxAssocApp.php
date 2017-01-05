<?php

session_start();
require_once("../../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../../portailv2/');


if (isset($_POST['id'])) {
		
	// DECOCHE TOUS LES GROUPES DE L'UTILISATEUR
	$req_groupe0 = "select id from groupes";
	$result_req_groupe0 = $ressourceBDD_appli->query($req_groupe0);
	while ($line0 = $result_req_groupe0->fetch(PDO::FETCH_ASSOC)) {
		$groupe0 = $line0['id'];
		echo "document.getElementById('groupe_$groupe0').checked=0;";	
	}
	
	// COCHE lES GROUPES DE L'UTILISATEUR
	$id_contact = $_POST['id'];
	$req_groupe = "select id_groupes from associations_contacts_groupes where id_contacts =$id_contact";
	$result_req_groupe = $ressourceBDD_appli->query($req_groupe);
	while ($line = $result_req_groupe->fetch(PDO::FETCH_ASSOC)) {
		$groupe = $line['id_groupes'];
		echo "document.getElementById('groupe_$groupe').checked='checked';";	
	}
	
}


elseif (isset($_POST['id_contact']) && isset($_POST['checke']) && isset($_POST['id_groupe'])) {
	
	$id_contact = $_POST['id_contact'];
	$id_groupe = $_POST['id_groupe'];
	
	if ($_POST['checke'] == 'false') {
		// 1. suppression dans la table d'association associations_contacts_groupes 
	  $req_supp = "delete from associations_contacts_groupes WHERE id_contacts=$id_contact AND id_groupes=$id_groupe";
	  $ressourceBDD_appli->query($req_supp);
	  echo "delete OK";
	}
	else {
		$req_ass = "insert into associations_contacts_groupes (id_contacts, id_groupes) values ($id_contact, $id_groupe)";
		$ressourceBDD_appli->query($req_ass);
		echo "insert OK";
	}
}



?>