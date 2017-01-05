<?php

//connexion base
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');
$equipe = $_REQUEST['term'];
$req_equipe = "SELECT 	id_equipe as id, 
						nom_equipe
				FROM 	commun.equipe 
				WHERE 	nom_equipe LIKE :equipe
				order by nom_equipe asc";
$result_equipe= $ressourceBDD_appli->prepare($req_equipe);
$result_equipe->execute(array(":equipe" => "%".$equipe."%"));
$equipes = array();
$i = count($equipes);
while ($r = $result_equipe->fetch(PDO::FETCH_ASSOC))
{
	$equipes[$i]['id'] = $r['id'];
	$equipes[$i]['nom_equipe'] = $r['nom_equipe'];
	$i++;
}

$tableau_json = array();
foreach ($equipes as $equipe) 
{
	$tableau_json[] = array(
		'value' => stripslashes($equipe['nom_equipe']),
		'id' => $equipe['id']);
}
echo json_encode($tableau_json);


?>