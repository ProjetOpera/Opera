<?php

// PRESENCE POST FORMULAIRE
if (isset($_POST['bdd']) && !empty($_POST['code']) && !empty($_POST['valeur']) && !empty($_POST['appli'])) {
	
	$code = mysql_escape_string($_POST['code']);
	$valeur = mysql_escape_string($_POST['valeur']);
	$checkbox = mysql_escape_string($_POST['checkbox']);
	$appli = intval($_POST['appli']);
	$id_menu = intval($_POST['id_menu']);

	// AJOUT *************************************************************************
	if($_POST['bdd']=="ajout") {
		
		if($checkbox=='i') $type_val = 'valeur_param_int';
		elseif($checkbox=='v') $type_val = 'valeur_param_varchar';
		elseif($checkbox=='d') $type_val = 'valeur_param_date';
		
		$sql0 = "
			INSERT INTO param_appli (code_param,type_param,$type_val,id_applications) 
			VALUES ('$code','$checkbox','$valeur',$appli)"; 
			
		$req0 = $ressourceBDD_appli->query($sql0);
		header("location: index.php?id_menu=".$_GET['id_menu']."&appli=$appli");
	}
	
	
	
	
}
?>