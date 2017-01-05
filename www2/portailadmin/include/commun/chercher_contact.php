<?php

//connexion base
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');
$contact = $_REQUEST['term'];
$req_contact = "SELECT 	id	as id, 
						concat(prenom_contact,' ',nom_contact) nom_contact
				FROM 	commun.contact 
				WHERE 	concat(prenom_contact,' ',nom_contact) LIKE :contact
				order by concat(prenom_contact,' ',nom_contact) asc";
$result_contact= $ressourceBDD_appli->prepare($req_contact);
$result_contact->execute(array(":contact" => "%".$contact."%"));
$contacts = array();
$i = count($contacts);
while ($r = $result_contact->fetch(PDO::FETCH_ASSOC))
{
	$contacts[$i]['id'] = $r['id'];
	$contacts[$i]['nom_contact'] = $r['nom_contact'];
	$i++;
}

$tableau_json = array();
foreach ($contacts as $contact) 
{
	$tableau_json[] = array(
		'value' => stripslashes($contact['nom_contact']),
		'id' => $contact['id']);
}
echo json_encode($tableau_json);


?>