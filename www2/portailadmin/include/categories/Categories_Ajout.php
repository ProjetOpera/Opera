<?php

//////////////
// libelles //
//////////////

$titre_AjoutCat = "Ajout categorie";

// libelle formulaire ajout categorie
$form_ajout_cat_nom_text = "Nom";
$form_ajout_cat_couleur_text = "Couleur";
$form_ajout_cat_bouton_text = "Ajouter";

// alert js control champ
$alert_js_control_nom = "Veuillez saisir un nom";
$alert_js_control_couleur = "Veuillez saisir une couleur (exemple : FFFFFF)";



?>

<!doctype html>

<html>
<head>
	<meta charset='utf-8'/>
</head>

<body>

<script>
	function verifAjoutCat(){			
	
	var nom = document.getElementById("formAjoutCatNom").value;
	var couleur = document.getElementById("formAjoutCatCouleur").value;
	
	var reg = new RegExp('^[0-9 a-f A-F]{6,6}$');
	
	if (nom=="")
		alert('<?php echo $alert_js_control_nom;?>');
	else if(!reg.test(couleur))
		alert('<?php echo $alert_js_control_couleur;?>');
	else
		document.getElementById("formAjoutCat").submit();
	}
</script>

<?php

	echo "<h1>".$titre_AjoutCat."</h1>\n";
	echo "<form id='formAjoutCat' name='formAjoutCat' method='POST' action=''>\n";
	echo "<input id='formAjoutCatFlag' name='formAjoutCatFlag' value='OK' type='hidden'/>\n";
	echo "	<table>\n";
	echo "		<tr>\n";
	echo "			<td>".$form_ajout_cat_nom_text."</td>\n";
	echo "			<td><input id='formAjoutCatNom' name='formAjoutCatNom' type='text'/></td>\n";
	echo "		</tr>\n";
	echo "		<tr>\n";
	echo "			<td>".$form_ajout_cat_couleur_text."</td>\n";
	echo "			<td><input id='formAjoutCatCouleur' name='formAjoutCatCouleur' type='text' maxlength='6'/></td>\n";
	echo "		</tr>\n";	
	echo "		<tr>\n";
	echo "			<td></td>\n";
	echo "			<td><input value='".$form_ajout_cat_bouton_text."' onclick='verifAjoutCat();' type='button'/></td>\n";
	echo "		</tr>\n";	
	echo "	</table>\n";
	echo "\n";
	echo "</form>\n";


?>

</body>

</html>

