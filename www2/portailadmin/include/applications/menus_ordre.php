<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

if(isset($_GET['id']) && isset($_GET['id_menu']) && isset($_GET['ordre']) && isset($_GET['p'])) {
	$id = intval($_GET['id']);
	$id_menu = intval($_GET['id_menu']);
	$appli = intval($_GET['appli']);
	$ordre = intval($_GET['ordre']);
	$parent = intval($_GET['p']);
	$sens = intval($_GET['sens']);
	
	try {
		
		//$ressourceBDD_appli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$ressourceBDD_appli->beginTransaction();
		
		// selection + MAJ du menu implique par la modification
		$sql0 = "SELECT id FROM menus WHERE id_applications=$appli AND parent=$parent AND ordre = $ordre";
		$req0 = $ressourceBDD_appli->query($sql0);
		
		//$sql1 = "UPDATE menus SET ordre=".($ordre+$sens)." WHERE id=".$req0->fetch(PDO::FETCH_COLUMN,0);
		$sql1 = "
			UPDATE menus 
			SET ordre=".($ordre+$sens)." 
			WHERE id=".$req0->fetch(PDO::FETCH_COLUMN,0);
		$req1 = $ressourceBDD_appli->exec($sql1);	
			
		// MAJ menu actuel
		$sql2 = "UPDATE menus SET ordre = $ordre WHERE id = $id";
		$req2 = $ressourceBDD_appli->exec($sql2);
		
		
		
		// incrementation +1 de chaque menu
		
		while ($line = $req0->fetch(PDO::FETCH_ASSOC)) {
			$ressourceBDD_appli->exec("UPDATE menus SET ordre=ordre+1 WHERE id=".$line['id']);
			//echo "UPDATE menus SET ordre=ordre+1 WHERE id=".$line['id']."<br />";
		}
		
		
		
		//if ($req0 && $req1 && $req2) $ressourceBDD_appli->commit();
		//else $ressourceBDD_appli->rollback();
		
		
		$ressourceBDD_appli->commit();
		
		header("location: ../../id_menu=$id_menu&appli=$appli");
	}
	
	catch (Exception $e) {
		$ressourceBDD_appli->rollBack();
	  echo "Failed: " . $e->getMessage();
	}
}
?>