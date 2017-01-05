<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/librairie.inc.php");


$id = intval($_POST['id']);
$libelle = $ressourceBDD_appli->quote($_POST['libelle']);
$id_textuel = $ressourceBDD_appli->quote($_POST['id_textuel']);
$url = (isset($_POST['url'])) ?  $ressourceBDD_appli->quote($_POST['url']) : 'null';
$appli = intval($_POST['appli']);
$parent = intval($_POST['parent']);
$id_menu = intval($_POST['id_menu']);
$level = intval($_POST['level']);

// PRESENCE POST FORMULAIRE
if (isset($_POST['bdd']) && !empty($_POST['libelle']) && !empty($_POST['appli'])) {
	
	// AJOUT *************************************************************************
	if($_POST['bdd']=="ajout") {
		
		$sql = " SELECT MAX(ordre) FROM menus WHERE id_applications = $appli AND parent = $parent ";
		$req = $ressourceBDD_appli->query($sql);
		
		$sql0 = "
			INSERT INTO menus (code_libelle, id_textuel, url, ordre, parent, id_applications, id_level)
			VALUES ($libelle, $id_textuel, $url,".($req->fetch(PDO::FETCH_COLUMN,0)+1).",$parent,$appli, $level)
		";
		$ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);
		header("location: id_menu=$id_menu&appli=$appli");
	}


	// MODIFICATION *************************************************************************
	if($_POST['bdd']=="modif" && !empty($_POST['id'])) {
		$sql_test = "SELECT parent FROM menus WHERE id=$id";
		$req_test = $ressourceBDD_appli->query($sql_test);

		// LE PARENT RESTE LE MEME ***************
		if ($req_test->fetch(PDO::FETCH_COLUMN,0)==$parent) {
			$sql0 = "
				UPDATE menus
				SET code_libelle = $libelle, id_textuel = $id_textuel, url = $url, parent= $parent, id_level = $level
				WHERE id = $id
			";
			$ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);
		}

		// LE PARENT CHANGE **********************
		else {
			// recuperation menus avec ordre superieur a celui modifie
			$sql = " 
				SELECT id
				FROM menus 
				WHERE id_applications = $appli 
				AND parent = (SELECT parent FROM menus WHERE id=$id)
				AND ordre > (SELECT ordre FROM menus WHERE id=$id)";
			$req = $ressourceBDD_appli->query($sql) or ErrorPdo (__FILE__, __LINE__, $sql1, $ressourceBDD_appli);		

			if ($req->rowCount()>0) {
				while ($line = $req->fetch(PDO::FETCH_ASSOC)) {
					$query = "UPDATE menus set ordre=ordre-1 WHERE id={$line['id']}";
					$ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
				}
			}

			$sql_max = "SELECT MAX(ordre) FROM menus WHERE parent = $parent";
			$req_max = $ressourceBDD_appli->query($sql_max) or ErrorPdo (__FILE__, __LINE__, $sql_max, $ressourceBDD_appli);
			$sql0 = "
				UPDATE menus 
				SET code_libelle = $libelle, url = $url, ordre = ".($req_max->fetch(PDO::FETCH_COLUMN,0)+1).", parent= $parent
				WHERE id = $id
			";
			$ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);
		}
		header("location: id_menu=$id_menu&appli=$appli");
	}
}


// SUPPRESSION *************************************************************************
elseif (isset($_POST['id']) && isset($_POST['appli']) && isset($_POST['checkbox']) && $_POST['checkbox']==1) {
			
	// recuperation menus avec ordre superieur a celui supprime
	$sql = " 
		SELECT id
		FROM menus 
		WHERE id_applications = $appli 
		AND parent = (SELECT parent FROM menus WHERE id=$id)
		AND ordre > (SELECT ordre FROM menus WHERE id=$id)";
	$req = $ressourceBDD_appli->query($sql);		
		
	if ($req->rowCount()>0) {
		while ($line = $req->fetch(PDO::FETCH_ASSOC)) {
			$query = "UPDATE menus set ordre=ordre-1 WHERE id={$line['id']}";
			$ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
		}
	}
	
	//suppression menu
	$sql0 = "DELETE FROM menus WHERE id = $id";
	$req0 = $ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);
}


?>