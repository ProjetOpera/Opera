<?php

/****************************************************************************
*   Fonction : Afficher une erreur SQL avec la connexion Mysql ou Mysqli    *
*****************************************************************************
*  Format d'appel : ErrorMysql (__FILE__, __LINE__, $query, $linkMysql)
*/
function ErrorMysql ($fileName, $noLine, $query, $linkMysql) {
	die ('<br>Error SQL in file <B>"'.$fileName.'"</B> on Ligne <B>'.$noLine.'</B><BR><BR>Query = '.$query.'<br><br>'.$linkMysql->error);
}

/****************************************************************
*   Fonction : Afficher une erreur SQL avec la connexion PDO    *
*****************************************************************
*  Format d'appel : ErrorPdo (__FILE__, __LINE__, $query, $linkPdo, $soap)
*
*  L'argument facultatif $soap, s'il existe, represente un object du serveur SAOP
*/
function ErrorPdo ($fileName, $noLine, $query, $linkPdo, $soap=null) {
	$err = $linkPdo->errorInfo ();
	$query = print_r($query, true);
	$msg = "<br/>Error SQL in file <b>\"$fileName\"</b> on Ligne <b>$noLine</b><br/><br/>Query = $query<br/><br/>$err[2]<br/>";
	// $msg = "Error SQL in file \"$fileName\" on Ligne $noLineQuery = $query ".$err[2];
	if ($soap) {
		$soap->fault (500, $msg);
		return;
	}
	die ($msg);
}

/**********************************************************
*   Fonction : Afficher sous format HTML des erreurs SOAP *
***********************************************************
*  Format d'appel : AfficheSoapFault ($err)
*/
function AfficheSoapFault ($fault) {
	echo $fault->faultstring;
	trigger_error("SOAP Fault: (faultcode: {$fault->faultcode})", E_USER_ERROR);
}

/****************************************************************
*   Fonction : Connexion a une BDD en PDO                       *
*****************************************************************
*  Format d'appel : mysqlConnexion (HostName de la BDD, No Port, User, Pwd, nom de BDD)
*/
 function mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname) {
 	
	$conn = null;
	try
	{
		$conn = new PDO("mysql:host=".$dbhost.";dbport=".$dbport.";dbname=".$dbname,$dbuser,$dbpass);
		$conn-> exec('SET NAMES utf8');
	}
	catch(PDOException $e)
	{
		echo ($e->getMessage());
	}
	return $conn;
	
 }
 
?>