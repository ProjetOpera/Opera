<?php

//include
include_once("parametres.inc.php");
require_once("../../_librairies/librairie.php");
include_once("fonctions.php");

//connexion à la base de données 
$connexion=mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);

//parametres
$nbcarmin=3;

// première étape : désactiver le cache lors de la phase de test
//ini_set("soap.wsdl_cache_enabled", "0");
 
// on indique au serveur à quel fichier de description il est lié
$serveurSOAP = new SoapServer('../wsdl/rattachementCI.wsdl');

// ajouter les methodes proposees au serveur
$serveurSOAP->addFunction('getCiFromOther');
$serveurSOAP->addFunction('getCiFromLotModule');

// lancer le serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST')

{
	$serveurSOAP->handle();
}
else
{
	echo 'D&eacute;sol&eacute;, je ne comprends pas les requ&ecirc;tes GET, veuillez seulement utiliser POST';
}



function getCIDatasFromLotEtModule($p_recherche,$p_lot,$p_module,$p_rechercheExacte,$p_type_recherche = "EQUIPEMENT")
{
	$datas=array();
	
	$where_recherche="";
	$champOrder="";
	$champWhereSupp="";
	$where_domaine_application="";
	$where_equipe_exploitation_application="";
	
	$tabQuestions=array();
	
	if ( $p_type_recherche == "EQUIPEMENT" ) 
	{
		$champSelect = "bav.netbios";
		$champOrder = " order by bav.netbios asc";
		$champWhereSupp = " and ( bav.netbios != '' and bav.netbios is not null)";
		
		if ( ! empty($p_recherche))
		{
			$where_recherche = " and ".$champSelect." ".(($p_rechercheExacte == "OUI")?"=":" like ")." ? ";
			$tabQuestions[count($tabQuestions)] = (($p_rechercheExacte == "OUI")? $p_recherche :"%".$p_recherche."%");
		}
		
		
	}
	else //SERVICE
	{
		$champSelect1 = "bav.nomrte_application";
		$champSelect2 = "bav.nna_application";
		$champOrder = " order by bav.nomrte_application asc";
		
		if ( ! empty($p_recherche))
		{
			$where_recherche = " and ( ";
			$where_recherche .= $champSelect1." ".(($p_rechercheExacte == "OUI")?"=":" like ")." ? ";
			$where_recherche .= " or ";
			$where_recherche .= $champSelect2." ".(($p_rechercheExacte == "OUI")?"=":" like ")." ? ";
			$where_recherche .=")";
			$tabQuestions[count($tabQuestions)] = (($p_rechercheExacte == "OUI")? $p_recherche :"%".$p_recherche."%");
			$tabQuestions[count($tabQuestions)] = (($p_rechercheExacte == "OUI")? $p_recherche :"%".$p_recherche."%");
		}
		
		
	}
	
	
		
	if ( ! empty($p_module) ) 
	{ 
		$domaine = getDomaineFromModule($p_module);
		$where_domaine_application = " and bav.domaine_application = ? ";
		$tabQuestions[count($tabQuestions)] = $domaine;
	}
		
	if ( ! empty($p_lot))
	{
		$equipeexploitation_application= getNumeroLotFromLot($p_lot);
		$where_equipe_exploitation_application =" and equipeexploitation_application like ?";
		$tabQuestions[count($tabQuestions)] = $equipeexploitation_application;
	}
	
	$sql = "select  
					 bav.nomrte_application service_nom_court,
					 bav.nom_application service_nom_long,
					 bav.nna_application service_identifiant,
					 bav.netbios equipement,
					 '".$p_type_recherche."' type_ci,
					 bav.role role,
					 bav.statut statut,
					 bav.attribute1_texte crb,
					 bav.attribute2_texte codesite,
					 bav.domaine_application domaine,
					 bav.equipeexploitation_application equipeexploitation
			from	bien_application_mv bav
			where	1=1
			and     bav.nomrte_application is not null
			and		bav.netbios is not null
			$champWhereSupp
			$where_recherche
			$where_domaine_application
			$where_equipe_exploitation_application
			$champOrder 
		  ";
	
	
	
	
	
	
	

	
	
	
	
	
		
			
	global $connexion;
	$stmt = $connexion->prepare($sql);
	
	for ( $i=0; $i< count($tabQuestions) ; $i++)
	{
		$stmt->bindParam(($i+1),$tabQuestions[$i],PDO::PARAM_STR);
	
	}
	
	if ( $stmt->execute())
	{
		$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	
	
	//on ajoute les informations de domaine et de lot en fonction des données issues de ITAC
	for ( $i=0; $i<count($datas) ; $i++)
	{
		$datas[$i]["lot"]=getLotFromEquipeExploitation($datas[$i]["equipeexploitation"]);
		$datas[$i]["module"]=getModuleFromDomaine($datas[$i]["domaine"]);
	}

	
	
	$stmt = null;		
	
		
	return $datas;
}


function getEquipementsFromCrb($crb)
{
	$datas=array();
	if ( empty($crb)) { return $datas;}
	
	$sql = "select 	b.netbios ci,
						'EQUIPEMENT' type_ci,
						b.role    info1,
						b.statut  info2
				from 	bien b
				where 	b.statut in ('En cours de mise en prod','Normal')
				and	  	b.attribute1_texte = ?
				";
	
	global $connexion;
	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(1,$crb,PDO::PARAM_STR);
	if ( $stmt->execute())
	{
		$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt = null;
	return $datas;
	
}

//liste des applications ayant au moins un bien sur le CRB
function getServicesFromCrb($crb)
{
	$datas=array();
	if ( empty($crb)) { return $datas;}

	$sql = "select 	bav.nomrte_application ci,
						'SERVICE' type_ci,
						bav.nom_application info1,
						bav.nna_application info2
				from 	bien_application_v bav
				where 	bav.nna_application is not null
				and   	bav.statut in ('En cours de mise en prod','Normal')
				and 	bav.attribute1_texte = ?
				";
	global $connexion;
	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(1,$crb,PDO::PARAM_STR);
	if ( $stmt->execute())
	{
		$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	$stmt = null;
	return $datas;
}


function getCiFromLotModule($recherche,$lot,$module,$rechercheType="EQUIPEMENT",$rechercheExacte="OUI",$sortie="XML")
{
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
		
	$tabEquipements=array();
	$tabServices=array();

	switch ( $rechercheType )
	{
		case "EQUIPEMENT" 	:
								$tabEquipements = getCIDatasFromLotEtModule($recherche,$lot,$module,$rechercheExacte,"EQUIPEMENT");
								break;
		case "SERVICE" 		:
								$tabServices 	= getCIDatasFromLotEtModule($recherche,$lot,$module,$rechercheExacte,"SERVICE");
								break;
		case "INDIFFERENT" 	:	
								$tabEquipements = getCIDatasFromLotEtModule($recherche,$lot,$module,$rechercheExacte,"EQUIPEMENT");
								$tabServices 	= getCIDatasFromLotEtModule($recherche,$lot,$module,$rechercheExacte,"SERVICE");
								break;
		default 			:
								break;	
	}
	
		
	//fusion des 2 tableaux
	$lignes=array_merge($tabEquipements,$tabServices);
	
	$datas["execution"]["statut"]=0;
	$datas["execution"]["message"]=count($tabEquipements);
	$datas["datas"] = $lignes;

	
	
	
	$retour = "";
	switch ($sortie)
	{
		case "XML" : 
					$retour=array2xml($datas, false, "ci");
					break;
		case "JSON" :
					$retour=array2json($datas);
					break;
		default :
					break;
	}				
	
	return $retour;

}


function getCiFromOther($recherche,$rechercheType="EQUIPEMENT",$rechercheExacte="OUI",$sortie="XML")
{
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
	$op="=";
	$where="and ";
	$params="";
	
	if ( $rechercheExacte == "NON")
	{
		$recherche = "%".$recherche."%";
		$op = " like ";
	}
	else
	{
		$recherche = $recherche ;
		$op = "=";
	}
	
	switch ( $rechercheType )
	{
		case "EQUIPEMENT" 	:
							$where .= " bav.netbios $op ? ";
							$params=array($recherche);
							break;
		case "SERVICE" 		:
							$where .= " ( bav.nomrte_application $op ? or bav.nna_application $op ? ) ";
							$params=array($recherche,$recherche);
							break;
		case "INDIFFERENT" 		:	
							$where .= " ( bav.netbios $op ? or bav.nomrte_application $op ? or bav.nna_application $op ? ) ";
							$params=array($recherche,$recherche,$recherche);
							break;
		default 			:
							$where .= " bav.netbios $op ? ";
							$params=array($recherche);
							break;	
	}
	
	if ( empty($recherche) || strlen($recherche) < $nbcarmin ) 
	{ 
		$datas["execution"]["statut"]=1;
		$datas["execution"]["message"]="L'element de recherche (avec $nbcarmin caractère(s) minimum) doit être renseigné !!!";
	}
		
	else
	{
		
	
		$sql="select 
					 bav.nomrte_application service_nom_court,
					 bav.nom_application service_nom_long,
					 bav.nna_application service_identifiant,
					 bav.netbios equipement,
					 bav.role role,
					 bav.statut statut,
					 bav.attribute1_texte crb,
					 bav.domaine_application domaine,
					 bav.equipeexploitation_application equipeexploitation
			  from 	bien_application_v bav
			  where 1 = 1
			  $where
			  and   bav.nna_application is not null
			  and	bav.statut not in ('Plus dans ITAC','Stock')
			  and 	bav.attribute1_texte like '%- Module %'
			  ";
				
		global $connexion;
		
		
		
		

		$stmt = $connexion->prepare($sql);
		
		$lignes=array();
		for ( $i=0;$i < count($params); $i++)
		{
			$stmt->bindParam(($i+1),$params[$i],PDO::PARAM_STR);
		}
		
		if ( $stmt->execute())
		{
			$lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			//on teste le CRB pour donner le domaine et le lot
			for ( $i=0; $i < count($lignes); $i++)
			{
				$lignes[$i]["module"]=getModuleFromDomaine($lignes[$i]["domaine"]);
				$lignes[$i]["lot"]=getLotFromEquipeExploitation($lignes[$i]["equipeexploitation"]);
				unset($lignes[$i]["crb"]);

			}
		}
		$stmt = null;
		
		$datas["execution"]["statut"]=0;
		$datas["execution"]["message"]=$sql;
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
		default :
					break;
	}				
	
	return $retour;
	
}



?>
