<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');


	//////////////
	// libelles //
	//////////////
	
	$suppr_groupe_titre = "Suppr groupe";
	
	// formulaire
	$form_suppr_groupe_confirm = "Etes-vous sur de vouloir supprimer ce groupe ?";
	$form_suppr_groupe_confirm_oui = "Oui";
	$form_suppr_groupe_confirm_non = "Non";
	$formSupprGroupeSubmit = "Soumettre";
	
	// impossible
	$suppr_impossible_mess = "Impossible de supprimer ce groupe car il possede des sous groupes";
	
	
	/////////////
	// require //
	/////////////
	
	require_once("../../connect.php");
	
	
	
?>


<!doctype html>

<html>
<head>
	<meta charset='utf-8'/>
</head>

<body>

<div style='text-align: center'>

<?php

$__commun_id_menu=$_GET['id_menu'];

if (!isset($_GET['reponse'])){
	 
	echo "<h1>".$suppr_groupe_titre."</h1>\n";
	
	
	$id=mysql_escape_string($_GET['id']);
        //echo $id;
	 
	//$sql="SELECT 1 FROM groupes WHERE id_parent='".$id."'";
        $sql="SELECT id_groupe FROM associations_groupes WHERE id_groupe_parent='".$id."'";
	$req=$ressourceBDD_appli->query($sql);
	if($req->rowCount()==0)
	{
		echo "<form id='formSupprGroupe' name='formSupprGroupe' method='POST' action='include/groupesusers/Gestion_Suppr.php?id=".$id."&id_menu=".$__commun_id_menu."&reponse=1'>\n";
		echo "	<p>".$form_suppr_groupe_confirm."</p>\n";
		
		echo "	<p>\n";
		echo "		<input id='formSupprGroupeRadio' name='formSupprGroupeRadio' type='radio' value='".$id."'/>".$form_suppr_groupe_confirm_oui;
		echo "		<input id='formSupprGroupeRadio' name='formSupprGroupeRadio' type='radio' value='non' /checked>".$form_suppr_groupe_confirm_non;
		echo "	</p>\n";
		
		echo "	<p><input type='submit' value='".$formSupprGroupeSubmit."'/></p>\n";
		
		echo "</form>\n";
	
        } else
		echo "<p>".$suppr_impossible_mess."</p>\n";
}
        // SUPRESSION DU GROUPE EN MEMOIRE
        if (isset($_POST['formSupprGroupeRadio']) && $_POST['formSupprGroupeRadio']!= 'non') {
            
            // suppression dans la table groupe
            $id_groupe = $_POST['formSupprGroupeRadio'];
            $req = "delete from groupes where id=$id_groupe";
            $ressourceBDD_appli->query($req);
            
            // suppression dans la table d'association des groupes
            $req2 = "delete from associations_groupes where id_groupe=$id_groupe";
            $ressourceBDD_appli->query($req2);
            
            header("Location: /portailadmin/id_menu=$__commun_id_menu");
            
        } else if (isset($_POST['formSupprGroupeRadio']) && $_POST['formSupprGroupeRadio']== 'non'){ 
            header("Location: /portailadmin/id_menu=$__commun_id_menu");
        }
        
        
        
?>
</div>
</body>

</html>