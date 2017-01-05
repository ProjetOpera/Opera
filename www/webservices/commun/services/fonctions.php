<?php

function getDomaineFromModule($module)
{
	$retour="";
	switch ($module)
	{
		case "INFRASTRUCTURE_COEUR" 	: $retour = "Infrastructure coeur"; break;
		case "INFRASTRUCTURE" 			: $retour = "Infrastructure"; break;
		case "APPLICATION" 				: $retour = "Application"; break;
		case "RESEAU" 					: $retour = "Réseau"; break;
		case "TECHNIQUE" 				: $retour = "Technique"; break;
		case "SECURITE" 				: $retour = "Sécurité"; break; //MODIF LLE 13/12/2016
		default 						: $retour = ""; break;
	}
	return $retour;
}

function  getNumeroLotFromLot($lot)
{
	$retour="";
	switch ( $lot )
	{
		case "LOT_B1" : $retour="%1";break;
		case "LOT_B2" : $retour="%2";break;
		default : break;
	}
	return $retour;
}


function getModuleFromDomaine($domaine)
{
	$retour="";
	switch ( $domaine )
	{
		case "Infrastructure coeur" 	: $retour = "INFRASTRUCTURE_COEUR"; break;
		case "Infrastructure"			: $retour = "INFRASTRUCTURE"; break;
		case "Application"				: $retour = "APPLICATION"; break;
		case "Réseau"					: $retour = "RESEAU"; break;
		case "Technique"				: $retour = "TECHNIQUE"; break;
		case "Sécurité"					: $retour = "SECURITE"; break;	//MODIF LLE 13/12/2016
		default 						: $retour = ""; break;
	}
	return $retour;
}

function getLotFromEquipeExploitation($equipe)
{
	$retour="";
	
	if ( empty($equipe) ) { return $retour; }
	
	$derniereLettre = substr($equipe, -1);
	switch ($derniereLettre)
	{
		case "1" : $retour = "LOT_B1"; break;
		case "2" : $retour = "LOT_B2"; break;
		default  : $retour = $equipe; break;
	}
	return $retour;
}

function getLotFromCrb($crb)
{
	$retour="";
	switch ( $crb )
	{
		case "AEA - Module C1" : $retour="LOT1"; break;
		case "AEA - Module D1" : $retour="LOT1"; break;
		case "AEA - Module D2" : $retour="LOT2"; break;
		case "CPA - Module C1" : $retour="LOT1"; break;
		case "CPA - Module C2" : $retour="LOT2"; break;
		case "E2S - Module C1" : $retour="LOT1"; break;
		case "E2S - Module S1" : $retour="LOT1"; break;
		case "EID - Module C1" : $retour="LOT1"; break;
		case "EID - Module C2" : $retour="LOT2"; break;
		case "SIR - Module C1" : $retour="LOT1"; break;
		case "WIL - Module C1" : $retour="LOT1"; break;
		case "WIL - Module R1" : $retour="LOT1"; break;
		case "WIL - Module R2" : $retour="LOT2"; break;
		default : break;
	}
	return $retour;
}
		
function getModuleFromCrb($crb)
{
	$retour="";
	switch ( $crb )
	{
		case "AEA - Module C1" : $retour="INFRASTRUCTURE_AEA"; break;
		case "AEA - Module D1" : $retour="APPLICATIONS"; break;
		case "AEA - Module D2" : $retour="APPLICATIONS"; break;
		case "CPA - Module C1" : $retour="INFRASTRUCTURE_CPA"; break;
		case "CPA - Module C2" : $retour="INFRASTRUCTURE_CPA"; break;
		case "E2S - Module C1" : $retour="INFRASTRUCTURE_SECURITE"; break;
		case "E2S - Module S1" : $retour="SECURITE"; break;
		case "EID - Module C1" : $retour="INFRASTRUCTURE"; break;
		case "EID - Module C2" : $retour="INFRASTRUCTURE"; break;
		case "SIR - Module C1" : $retour="BUREAUTIQUE"; break;
		case "WIL - Module C1" : $retour="INFRASTRUCTURE_RESEAU"; break;
		case "WIL - Module R1" : $retour="RESEAU"; break;
		case "WIL - Module R2" : $retour="RESEAU"; break;
		default : break;
	}
	return $retour;
}


function getCrbFromLotModule($lot,$module)
{
	$retour="";
	if ( empty($lot) || empty($module) ) return $retour;
	
	switch ( $module )
	{
		case "INFRASTRUCTURE_AEA" 		: $retour="AEA - Module C"; break;
		case "APPLICATIONS" 			: $retour="AEA - Module D"; break;
		case "INFRASTRUCTURE_CPA" 		: $retour="CPA - Module C"; break;
		case "INFRASTRUCTURE_SECURITE" 	: $retour="E2S - Module C"; break;
		case "SECURITE" 				: $retour="E2S - Module S"; break;
		case "INFRASTRUCTURE" 			: $retour="EID - Module C"; break;
		case "BUREAUTIQUE" 				: $retour="SIR - Module C"; break;
		case "INFRASTRUCTURE_RESEAU" 	: $retour="WIL - Module C"; break;
		case "RESEAU" 					: $retour="WIL - Module R"; break;
		default : break;
	}
	
	//si on trouve un module, on ajoute le lot
	if ( !empty($retour))
	{
		switch ( $lot )
		{
			case "LOT1" : $retour=$retour."1";break;
			case "LOT2" : $retour=$retour."2";break;
			default : break;
		}
	}
	
	return $retour;
}

		
?>