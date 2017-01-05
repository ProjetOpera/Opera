<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

if(isset($_GET['id']) && isset($_GET['id_menu']) && isset($_GET['appli'])) {
	$id = intval($_GET['id']);
	$id_menu = intval($_GET['id_menu']);
	$appli = intval($_GET['appli']);
		
	try {
					
		$ressourceBDD_appli->beginTransaction();
		
		// Remise a 0 par defaut
		$sql0 = "UPDATE menus SET defaut = 0 WHERE id_applications=$appli AND defaut=1";
		$req0 = $ressourceBDD_appli->exec($sql0);
		
		//Mise a 1 par defaut
		$sql1 = "UPDATE menus SET defaut = 1 WHERE id_applications=$appli AND id=$id";
		$req1 = $ressourceBDD_appli->exec($sql1);
				
		$ressourceBDD_appli->commit();
		
		header("location: ../../id_menu=$id_menu&appli=$appli");
	}
	
	catch (Exception $e) {
		$ressourceBDD_appli->rollBack();
	  echo "Failed: " . $e->getMessage();
	}
}
?>