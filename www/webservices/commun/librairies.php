<?php
function verification_connexion()
	{
		include("parametres.inc.php");
		if ( !isset($_SESSION["CONNEXION"]) || $_SESSION["CONNEXION"] == "" )
		{
			$connexion = mysql_connect($dbhost,$dbuser,$dbpass);
			if ( ! $connexion )
	 		{
	 			die("ERROR_CONNEXION_MYSQL_SERVEUR");
	 		}
			mysql_select_db($dbname,$connexion) or die(mysql_error());
			$_SESSION["CONNEXION"]=$connexion;
		}
	}

?>