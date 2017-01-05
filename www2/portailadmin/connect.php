<?php
/****************************
*** CONNEXION A LA BASE 
***     MYSQL - PDO
*****************************/

define ('DB_SERVER', 'localhost');
define ('SERVER_USER', 'portailv2');
define ('SERVER_PASSWORD', 'port_taille_v2');
define ('DB_DATABASE', 'portailv2');

/*
$db = mysql_connect(DB_SERVER, SERVER_USER, SERVER_PASSWORD);
$connexion = mysql_select_db(DB_DATABASE,$db) or die('Connexion a la base MYSQL impossible');
*/


	$bdd = 'mysql:host='.DB_SERVER.';dbname='.DB_DATABASE.';charset=UTF8';
	try {
		$connexion = new PDO($bdd, SERVER_USER, SERVER_PASSWORD);
	}
	catch (PDOException $error) {
		die("Erreur de connexion : " . $error->getMessage() );
	}




?>