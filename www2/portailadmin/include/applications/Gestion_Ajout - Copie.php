<?php
		
	// connexion base APPLIS
	// *******************************************************
	session_start();
	require_once("../../../portailv2/functions/functions.php");
	$ressourceBDD_appli = connexion_externe('../../../portailv2/');

	//////////////
	// libelles //
	//////////////
	
	$lienAjoutApp="Ajouter";

	// libelles formulaire ajout app
	$formAjoutAppNom_text = "Nom";
	$formAjoutAppURL_text = "Url";
	$formAjoutAppCategorie_text = "Categorie";
	$formAjoutAppInterne_text = "Interne";
	$formAjoutAppServeur_text = "Serveur base";
	$formAjoutAppNomBase_text = "Nom base";
	$formAjoutAppIdentifiant_text = "Identifiant";
	$formAjoutAppMotDePasse_text = "Mot de passe";
	$formAjoutAppBouton_text = "Ajouter";
	
	// libelles alert javascript ajout app
	$formAjoutAppNom_alert_text = "Veuillez saisir un nom d application";
	$formAjoutAppURL_alert_text = "Veuillez saisir une URL";
	$formAjoutAppServeur_alert_text = "Veuillez saisir le serveur de la base";
	$formAjoutAppNomBase_alert_text = "Veuillez saisir le nom de la base";
	$formAjoutAppIdentifiant_alert_text = "Veuillez saisir un identifiant";
	$formAjoutAppMotDePasse_alert_text = "Veuillez saisir un mot de passe";

	
	// Ajout
	////////
	
	
	echo "<form id='formAjoutApp' name='formAjoutApp' method='post' action=''>\n";
	echo "<table>\n";
		
	// Nom
	echo "<tr>\n";
		echo "<td>".$formAjoutAppNom_text."</td>\n";
		echo "<td><input id='formAjoutAppNom' name='formAjoutAppNom' type='text'/></td>\n";
	echo "</tr>\n";
	
	// URL
	echo "<tr>\n";
		echo "<td>".$formAjoutAppURL_text."</td>\n";
		echo "<td><input id='formAjoutAppURL' name='formAjoutAppURL' type='text'/></td>\n";
	echo "</tr>\n";
	
	// Categorie
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppCategorie_text."</td>\n";
		echo "<td>\n";
		
			echo "<select id='formAjoutAppCategorie' name='formAjoutAppCategorie'>\n";
			
			
			$sql_formAjoutAppCategorie = "SELECT id,nom_categorie FROM categories";
			$result_formAjoutAppCategorie = $ressourceBDD_appli->query($sql_formAjoutAppCategorie);
			while ($row_formAjoutAppCategorie = $result_formAjoutAppCategorie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value='".$row_formAjoutAppCategorie['id']."'>".utf8_encode($row_formAjoutAppCategorie['nom_categorie'])."</option>\n";
			}
		
			
			echo "</select>\n";
		
		
		echo "</td>\n";
	echo "</tr>\n";
		
	// Interne
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppInterne_text."</td>\n";
		echo "<td><input id='formAjoutAppInterne' name='formAjoutAppInterne' type='checkbox' value='checked'/></td>\n";
	echo "</tr>\n";
	
		
	// Serveur
	echo "<tr>\n";
		echo "<td>".$formAjoutAppServeur_text."</td>\n";
		echo "<td><input id='formAjoutAppServeur' name='formAjoutAppServeur' type='text'/></td>\n";
	echo "</tr>\n";	
	
	// Base
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppNomBase_text."</td>\n";
		echo "<td><input id='formAjoutAppNomBase' name='formAjoutAppNomBase' type='text'/></td>\n";
	echo "</tr>\n";

	// Identifiant
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppIdentifiant_text."</td>\n";
		echo "<td><input id='formAjoutAppIdentifiant' name='formAjoutAppIdentifiant' type='text'/></td>\n";
	echo "</tr>\n";	
	
	// Mot de passe
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppMotDePasse_text."</td>\n";
		echo "<td><input id='formAjoutAppMotDePasse' name='formAjoutAppMotDePasse' type='password'/></td>\n";
	echo "</tr>\n";
	
	// Bouton Ajouter
	echo "<tr>\n";	
		echo "<td></td>\n";
		echo "<td><input id='formAjoutBouton' name='formAjoutBouton' type='button' value='".$formAjoutAppBouton_text."' onclick='verifAjoutApp();'/></td>\n";
	echo "</tr>\n";
	
	echo "</table>\n";
	echo "</form>\n";
?>


<script type='text/javascript'>
	
	function verifAjoutApp()
	{	
		if(document.getElementById('formAjoutAppNom').value=='')
			alert('<?php echo $formAjoutAppNom_alert_text; ?>');
		else if(document.getElementById('formAjoutAppURL').value=='')
			alert('<?php echo $formAjoutAppURL_alert_text; ?>');
		else if (document.getElementById('formAjoutAppInterne').value!='checked') {
                    if (document.getElementById('formAjoutAppServeur').value=='')
						alert('<?php echo $formAjoutAppServeur_alert_text; ?>');
                    else if(document.getElementById('formAjoutAppNomBase').value=='')
						alert('<?php echo $formAjoutAppNomBase_alert_text; ?>');
                    else if(document.getElementById('formAjoutAppIdentifiant').value=='')
						alert('<?php echo $formAjoutAppIdentifiant_alert_text; ?>');
                    else if(document.getElementById('formAjoutAppMotDePasse').value=='')
						alert('<?php echo $formAjoutAppMotDePasse_alert_text; ?>');
		} else
                    
			document.getElementById('formAjoutApp').submit();
	}

</script>