<?php

//include
include_once("parametres.inc.php");
include_once("fonctions.php");
require_once("../../_librairies/librairie.php");


//connexion à la base de données 
$connexion=mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname);

//parametres
$nbcarmin=3;

// première étape : désactiver le cache lors de la phase de test
//ini_set("soap.wsdl_cache_enabled", "0");
 
// on indique au serveur à quel fichier de description il est lié
$serveurSOAP = new SoapServer('../wsdl/contacts.wsdl');

// publication des fonctions 
$serveurSOAP->addFunction('getContactsPortailAvecEmail');
$serveurSOAP->addFunction('getContactsDynamiques');

// lancer le serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST')

{
	$serveurSOAP->handle();
}
else
{
	echo 'D&eacute;sol&eacute;, je ne comprends pas les requ&ecirc;tes GET, veuillez seulement utiliser POST';
}

function getContactsPortailAvecEmail($sortie="XML")
{
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
	$sql="SELECT 	nom_contact,
		prenom_contact,
		email_contact,
		type_contact,
		tel_contact,
		nom_equipe,
		nom_societe,
		nom_contact_parent,
		prenom_contact_parent
		FROM 	commun.contact_infos_v
		where 	email_contact REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$'
		order by nom_contact asc , prenom_contact asc
		  ";
			
	global $connexion;
		
		

	$stmt = $connexion->prepare($sql);
	
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


function getContactsDynamiques($lot,$module,$listeEquipementsSource,$listeServicesSource,$listeEquipementsImpact,$listeServicesImpact,$sortie="XML")
{
	
	
	$datas=array("execution"=> array("statut"=>-1,"message"=>""), "datas" => array());
	
	//tableau qui contient les NNA et NNB pour lesquels il faut passer par l'ARFSI
	$nnbnnbARFSI=array("9059","9076","9181","9180","9074"); //SRB, RIN/RET, LAN SITE crit et Std , WI-FI 
	
	
	$emails = array();
	global $connexion;
	
	    
    $sqlARTE = "select adressemailArte(?) as emails";
	$stmtARTE= $connexion->prepare($sqlARTE);
	
	$sqlARFSI = "select adressemailArfsi(?) as emails";
	$stmtARFSI = $connexion->prepare($sqlARFSI);
	
	$listeNNANNB = array();
	$listeNNANNB_SOURCE = array();
	$listeNNANNB_IMPACT = array();
	
	$listeEQUIPEMENTS = array();
	$listeEQUIPEMENTS_SOURCE = array();
	$listeEQUIPEMENTS_IMPACT = array();
	
	$tabRecherches = array();
	
	
	// ===================    NNA et NNB ============================== 
	if ( ! empty($listeServicesSource) )
	{
		//pour chacun des NNB/NNA (separés par des ,) on récupere les contacts, on éclate les adresses mails et on stocke les adresses emails unique.
		$listeNNANNB_SOURCE= explode(",",str_replace(" ","",$listeServicesSource));
	}
	
	if ( ! empty($listeServicesImpact) )
	{
		//pour chacun des NNB/NNA (separés par des ,) on récupere les contacts, on éclate les adresses mails et on stocke les adresses emails unique.
		$listeNNANNB_IMPACT= explode(",",str_replace(" ","",$listeServicesImpact));
	}
	
	//consolidation des 2 tableaux
	$listeNNANNB = array_unique ( array_merge($listeNNANNB_SOURCE,$listeNNANNB_IMPACT));
	
	
	
	// ===================    EQUIPEMENTS ============================== 
	if ( ! empty($listeEquipementsSource) )
	{
		$listeEQUIPEMENTS_SOURCE= explode(",",str_replace(" ","",$listeEquipementsSource));
	}
	
	if ( ! empty($listeEquipementsImpact) )
	{
		$listeEQUIPEMENTS_IMPACT= explode(",",str_replace(" ","",$listeEquipementsImpact));
	}
	
	//consolidation des 2 tableaux
	$listeEQUIPEMENTS = array_unique ( array_merge($listeEQUIPEMENTS_SOURCE,$listeEQUIPEMENTS_IMPACT));
	
	
	foreach($listeNNANNB as $nnannb)
	{
		if ( !empty($nnannb)) 
		{
			$recherche="";
			$lignes=array();

			//cas des services qui doivent s'appuyer sur l'ARFSI
			if ( in_array($nnannb,$nnbnnbARFSI) )
			{
				$stmt = $stmtARFSI;

				//codes site des équipements associés à ces NNA et NNB
				$recherche = "?????";
				
				//on recupere les biens associés à ce NNA/NNB
				$clientSOAP = new SoapClient('http://localhost/webservices/commun/wsdl/rattachementCI.wsdl');
				
				$cis = json_decode($clientSOAP->getCiFromLotModule(
										$nnannb, 
										null, 
										null, 
										"SERVICE",
										"OUI",
										"JSON"),true);
				
				//on compare avec la liste des équipements du FM
				//si le bien du FM est dans la liste des biens du NNA/NNB traité alors on prend les 5 premiers caractères pour trouver le contact arfsi
				
				$date = date('l jS \of F Y H:i:s');
				
				foreach ($cis['datas'] as $un_cis) {
				
					$equipement= trim($un_cis["equipement"]);
					if ( in_array($equipement, $listeEQUIPEMENTS)  )
					{
						//on recupere le code site attaché au bien (données issues de ITAC ( rtecodesite)) depuis la table bien commun.
						$codesite=$un_cis["codesite"];
						
						//si le codesite est vide ou non renseigné alors on prend les 5 premiers caractères du bin
						if ( empty($codesite) && strlen($equipement) >= 5)
						{
							$codesite = substr($equipement,0,5);
						}
						
						
						//si le codesite n'est pas vide est de longueur 5
						//on recupere la liste des 
						if ( ! empty($codesite) && strlen($codesite) == 5 )
						{
							$recherche = $codesite;
						}
						$tabRecherches[] = array($recherche,$stmtARFSI);
					}
					
				}
			}
			
			//traitement @RTE
			$tabRecherches[] = array($nnannb,$stmtARTE);
		}
	}		
			
	foreach ($tabRecherches as $uneRecherche)
	{
		$recherche = $uneRecherche[0];
		$stmt = $uneRecherche[1];
		$stmt->bindParam(1,$recherche,PDO::PARAM_STR);
		$lignes=array();
		
		if ( $stmt->execute())
		{
			$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
			$listeEmails = $ligne["emails"];
			//on decoupe sur le ;
			$listeEmailsArray = explode(";",str_replace(",",";",$listeEmails));
			foreach ($listeEmailsArray as $listEmails)
			{
				$email = strtolower($listEmails);
				if ( !empty($email) && ! in_array($email, $emails))
				{
					$emails[]=$email;
				}
			}
		}
		$stmt = null;
	}
	
	//tri du tableau de emails par ordre alpha
	$emails = array_unique($emails);
	sort($emails);

	

	
	$datas["execution"]["statut"]=0;
	$datas["execution"]["message"]="";
	$datas["datas"] = $emails;
		
	$retour = "";
	switch ($sortie)
	{
		case "XML" : 
					$retour=array2xml($datas, false, "contact");
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
