<?php

//////////////
// libelles //
//////////////

// libelle formulaire Modif categorie
$form_Modif_cat_nom_text = "Nom";
$form_Modif_cat_couleur_text = "Couleur";
$form_Modif_cat_bouton_text = "Modifier";

// alert js control champ
$alert_js_control_nom = "Veuillez saisir un nom";
$alert_js_control_couleur = "Veuillez saisir une couleur (exemple : FFFFFF)";

// require
session_start();
require_once("../../connect.php");
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

?>

<!doctype html>

<html>
<head>
	<meta charset='utf-8'/>
</head>

<body>

<script>
	function verifModifCat(){			
	
	var nom = document.getElementById("formModifCatNom").value;
	var couleur = document.getElementById("formModifCatCouleur").value;
	
	var reg = new RegExp('^[0-9 a-f A-F]{6,6}$');
	
	if (nom=="")
		alert('<?php echo $alert_js_control_nom;?>');
	else if(!reg.test(couleur))
		alert('<?php echo $alert_js_control_couleur;?>');
	else
		document.getElementById("formModifCat").submit();
	}
</script>

<?php
	$id=mysql_real_escape_string($_GET['id']);

	echo "<form id='formModifCat' name='formModifCat' method='POST' action=''>\n";
	echo "<input id='formModifCatFlag' name='formModifCatFlag' value='".$id."' type='hidden'/>\n";
	
	// recuperation info cat
	$sql_recup_info_cat="SELECT nom_categorie,couleur_categorie FROM categories WHERE id=".$id;
	$result_recup_info_cat=$ressourceBDD_appli->query($sql_recup_info_cat);
	
	$nom_modif_cat=$result_recup_info_cat->fetch(PDO::FETCH_COLUMN,0);
	$couleur_modif_cat=$result_recup_info_cat->fetch(PDO::FETCH_COLUMN,1);
	
	
	echo "	<table>\n";
	echo "		<tr>\n";
	echo "			<td>".$form_Modif_cat_nom_text."</td>\n";
	echo "			<td><input id='formModifCatNom' name='formModifCatNom' type='text' value='".$nom_modif_cat."'/></td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td>".$form_Modif_cat_couleur_text."</td>\n";
	echo "			<td><input id='formModifCatCouleur' name='formModifCatCouleur' type='text' value='".$couleur_modif_cat."' maxlength='6'/></td>\n";
	echo "		</tr>\n";	
	echo "		<tr>\n";
	echo "			<td></td>\n";
	echo "			<td><input value='".$form_Modif_cat_bouton_text."' onclick='verifModifCat();' type='button'/></td>\n";
	echo "		</tr>\n";	
	echo "	</table>\n";
	echo "\n";
	echo "</form>\n";

?>

</body>

</html>