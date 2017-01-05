<?php

//include
include_once("parametres.inc.php");
require_once("../../_librairies/librairie.php");


//connexion à la base de données 
$connexion=mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);

//parametres


// première étape : désactiver le cache lors de la phase de test
//ini_set("soap.wsdl_cache_enabled", "0");
 
// on indique au serveur à quel fichier de description il est lié
$serveurSOAP = new SoapServer('../wsdl/equipes.wsdl');

// publication des fonctions 
$serveurSOAP->addFunction('getCollaborateursEquipe');
// lancer le serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST')

{
	$serveurSOAP->handle();
}
else
{
	echo 'D&eacute;sol&eacute;, je ne comprends pas les requ&ecirc;tes GET, veuillez seulement utiliser POST';
}

function getCollaborateursEquipe($equipe,$sortie="XML")
{
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
	$sql="SELECT * FROM commun.contact_infos_v where nom_equipe = ?";
			
	global $connexion;
		
		

	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(1,$equipe,PDO::PARAM_STR);
	$lignes=array();
	if ( $stmt->execute())
	{
		$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt = null;
	
	$datas["execution"]["statut"]=0;
	$datas["execution"]["message"]="";
	$datas["datas"] = $lignes;
		

	
	
	
	$retour = "";
	switch ($sortie)
	{
		case "XML" : 
					$retour=array2xml($datas, false, "collaborateur");
					break;
		case "JSON" :
					$retour=array2json($datas);
					break;
		default :
					break;
	}				
	
	return $retour;
	
}



?>
