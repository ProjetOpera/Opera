<?php

//include
include_once("parametres.inc.php");
require_once("../../_librairies/librairie.php");


//connexion à la base de données 
$connexion=mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);

// première étape : désactiver le cache lors de la phase de test
//ini_set("soap.wsdl_cache_enabled", "0");
 
// on indique au serveur à quel fichier de description il est lié
$serveurSOAP = new SoapServer('../wsdl/cis.wsdl');

// ajouter la fonction getHello au serveur
$serveurSOAP->addFunction('getCIInformations');
$serveurSOAP->addFunction('getCriticite');
$serveurSOAP->addFunction('getSupervision');
// lancer le serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST')

{
	$serveurSOAP->handle();
}
else
{
	echo 'D&eacute;sol&eacute;, je ne comprends pas les requ&ecirc;tes GET, veuillez seulement utiliser POST';
}




function getCriticite($listeEquipementsSource,$listeServicesSource,$listeEquipementsImpact,$listeServicesImpact)
{
	$retour = 
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	$retour = "";
	$data=array();
	
	$criticitesReferences = array();
	$criticitesReferences["IS LOTB1"]=1;
	$criticitesReferences["IC LOTB1"]=2;
	$criticitesReferences["ICP LOTB1"]=3;
	$criticitesReferences["IS LOTB2"]=1;
	$criticitesReferences["IC LOTB2"]=2;
	$criticitesReferences["ICP LOTB2"]=3;
	
	$criticiteLaPlusHaute = 0;
	$criticiteReference = "CRITICITE NON TROUVEE";
	
	//dans le cas de RTE, on ne prend que la supervision de l'application source
	//decoupage de la liste par ,
	$services=explode(",",$listeServicesSource);
	$data ="vide";
	//on recherche la criticité pour chacun des services
	for ($i=0; $i < count($services); $i++)
	{
		$service = $services[$i];
		$data = getServiceFromName($service);
		if ( count($data) == 1 )
		{
			$criticite=$data[0]["criticite"];
			if ( isset($criticitesReferences[$criticite]) && $criticitesReferences[$criticite] > $criticiteLaPlusHaute)
			{
				$criticiteLaPlusHaute = $criticitesReferences[$criticite];
				$criticiteReference = $criticite;
			}
		}
	}
	return $criticiteReference;
}

function getSupervision($listeEquipementsSource,$listeServicesSource,$listeEquipementsImpact,$listeServicesImpact)
{
		$retour = 
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	$retour = "";
	$data=array();
	
	$supervisionsReferences = array();
	$supervisionsReferences["H Standard (7h-20h)"]=1;
	$supervisionsReferences["H Permanent (24/7)"]=2;
	
	$supervisionLaPlusHaute = 0;
	$supervisionReference = "SUPERVISION NON TROUVEE";
	
	//dans le cas de RTE, on ne prend que la supervision de l'application source
	//decoupage de la liste par ,
	$services=explode(",",$listeServicesSource);
	$data ="vide";
	//on recherche la criticité pour chacun des services
	for ($i=0; $i < count($services); $i++)
	{
		$service = $services[$i];
		$data = getServiceFromName($service);
		if ( count($data) == 1 )
		{
			$supervision=$data[0]["supervision"];
			if ( isset($supervisionsReferences[$supervision]) && $supervisionsReferences[$supervision] > $supervisionLaPlusHaute)
			{
				$supervisionLaPlusHaute = $supervisionsReferences[$supervision];
				$supervisionReference = $supervision;
			}
		}
	}
	return $supervisionReference;
}

//récuperation de l'équipement
function getEquipementFromName($name)
{
	$datas=array();
	if ( empty($name)) { return $datas;}
	
	$sql="select  	b.netbios equipement,
						b.statut statut,
						b.criticite criticite,
						b.supervision supervision,
						l.adresse adresse,
						l.codepostal cp,
						l.ville	ville,
						l.localisation localisation
				from 	commun.bien b,
						commun.localisation l
				where 	b.id_localisation = l.id
				and		b.netbios = upper(?) 
			  ";
	
	global $connexion;
	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(1,$name,PDO::PARAM_STR);
	if ( $stmt->execute())
	{
		$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt = null;
	return $datas;
	
}

//récuperation du service à partir du nom_court ou le NNA/NNB 
function getServiceFromName($name)
{
	$datas=array();
	if ( empty($name)) { return $datas;}
	
	$sql="select  a.nna_application code_application,
		a.nomrte_application nom_court_application,
		a.nom_application nom_long_application,
		a.criticite criticite,
		a.supervision supervision,
		p.nom_programme programme
from application a,
	 programme p
where a.id_programme = p.id
and   ( a.nna_application = ? or a.nomrte_application = ?)
			  ";
	
	global $connexion;
	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(1,$name,PDO::PARAM_STR);
	$stmt->bindParam(2,$name,PDO::PARAM_STR);
	if ( $stmt->execute())
	{
		$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt = null;
	return $datas;
}


function getCIInformations($recherche,$rechercheType,$sortie="XML")
{
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
	if ( 
			empty($recherche)
		) 
	{ 
		$datas["execution"]["statut"] = 1; 
		$datas["execution"]["message"] = "Le nom de l'équipement ou de du service doit être renseigné"; 
	}
	
	if ( 	
			empty($rechercheType) 
			|| 
			(
				$rechercheType != 'EQUIPEMENT' 
				&&  
				$rechercheType != 'SERVICE' 
			)
		) 
	{ 	
		$datas["execution"]["statut"] = 2; 
		$datas["execution"]["message"] = "Le type de recherche doit etre EQUIPEMENT / SERVICE "; 
	}
	$lignes = array($datas["execution"]["statut"]);
	if ( $datas["execution"]["statut"] == -1 )
	{
		
		switch ( $rechercheType )
		{
			case "EQUIPEMENT" :
								$tabEquipements = getEquipementFromName($recherche);
								$lignes = $tabEquipements;
								break;
			case "SERVICE" :
								$tabServices = getServiceFromName($recherche);
								$lignes = $tabServices;
								break;
			default :
								break;
		}
		//$lignes = array(1);
		$datas["execution"]["statut"]=0;
		$datas["execution"]["message"]="";
		$datas["datas"] = $lignes;
		
	}
	
	$retour = "";
	switch ($sortie)
	{
		case "XML" : 
					$retour=array2xml($datas, false, "ci");
					break;
		case "JSON" :
					$retour=array2json($datas);
					break;
		case "ARRAY" :
					$retour=$datas;
					break;
		default :
					break;
	}				
	
	return $retour;
	
}




?>
