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
	$formAjoutAppTypeServeur_text = "Type base";
	$formAjoutAppNomBase_text = "Nom base";
	$formAjoutAppIdentifiant_text = "Identifiant";
	$formAjoutAppMotDePasse_text = "Mot de passe";
	$formAjoutAppBouton_text = "Ajouter";
	$formTestCxnBddBouton_text = "Test connexion BDD";
	
	// libelles alert javascript ajout app
	$formAjoutAppNom_alert_text = "Veuillez saisir un nom d application";
	$formAjoutAppURL_alert_text = "Veuillez saisir une URL";
	$formAjoutAppServeur_alert_text = "Veuillez saisir le serveur de la base";
	$formAjoutAppNomBase_alert_text = "Veuillez saisir le nom de la base";
	$formAjoutAppIdentifiant_alert_text = "Veuillez saisir un identifiant";
	$formAjoutAppMotDePasse_alert_text = "Veuillez saisir un mot de passe";

	if ($_REQUEST['action'] == 'testCnxBdd') {
		$bddServer = $_REQUEST['BddServer'];
		$bddServerType = $_REQUEST['BddServerType'];
		$bddName = $_REQUEST['BddName'];
		$bddUser = $_REQUEST['BddUser'];
		$bddPwd = $_REQUEST['BddPwd'];

		if ($bddServerType == "SQLSERVER")
			$bdd = "sqlsrv:server=$bddServer; Database=$bddName";
		else
			$bdd = "mysql:host=$bddServer;dbname=$bddName;charset=UTF8";
		
		//Ne prendre  que les erreurs de niveau ERROR
		//Pas le niveau WARNING car il provoque l'erreur de retour de AJAX
		error_reporting(E_ERROR);
		try {
			$connexion = new PDO($bdd, $bddUser, $bddPwd);
			header ("200", true, 200);
		} catch (PDOException $error) {
			header ("500", true, 500);
			echo utf8_encode($error->getMessage());
		}
		return;
	}
	
	
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
				echo "<option value='".$row_formAjoutAppCategorie['id']."'>".$row_formAjoutAppCategorie['nom_categorie']."</option>\n";
			}
		
			
			echo "</select>\n";


		echo "</td>\n";
	echo "</tr>\n";
		
	// Interne
	echo "<tr>\n";	
		echo "<td>".$formAjoutAppInterne_text."</td>\n";
		echo "<td><input id='formAjoutAppInterne' name='formAjoutAppInterne' type='checkbox' checked='checked'/></td>\n";
	echo "</tr>\n";
	
		
	// Serveur
	echo "<tr id='ServeurLine'>\n";
		echo "<td>".$formAjoutAppServeur_text."</td>\n";
		echo "<td><input id='formAjoutAppServeur' name='formAjoutAppServeur' type='text'/></td>\n";
	echo "</tr>\n";	
	
	// Type de Serveur
	echo "<tr id='TypeServeurLine'>\n";
		echo "<td>".$formAjoutAppTypeServeur_text."</td>\n";
		echo "<td><select id='formAjoutAppTypeServeur' name='formAjoutAppTypeServeur'>\n";
		echo "	<option value='MYSQL'>MYSQL</option>\n";
		echo "	<option value='SQLSERVER'>SQLSERVER</option>\n";
		echo "</select>\n";
		echo "</td>\n";
	echo "</tr>\n";	
	
	// Base
	echo "<tr id='NomBaseLine'>\n";	
		echo "<td>".$formAjoutAppNomBase_text."</td>\n";
		echo "<td><input id='formAjoutAppNomBase' name='formAjoutAppNomBase' type='text'/></td>\n";
	echo "</tr>\n";

	// Identifiant
	echo "<tr id='IdentifiantLine'>\n";	
		echo "<td>".$formAjoutAppIdentifiant_text."</td>\n";
		echo "<td><input id='formAjoutAppIdentifiant' name='formAjoutAppIdentifiant' type='text'/></td>\n";
	echo "</tr>\n";	
	
	// Mot de passe
	echo "<tr id='MotDePasseLine'>\n";	
		echo "<td>".$formAjoutAppMotDePasse_text."</td>\n";
		echo "<td><input id='formAjoutAppMotDePasse' name='formAjoutAppMotDePasse' type='password'/></td>\n";
	echo "</tr>\n";
	
	// Bouton Ajouter
	echo "<tr>\n";	
		echo "<td></td>\n";
		echo "<td><br><input id='formAjoutBouton' name='formAjoutBouton' type='button' value='".$formAjoutAppBouton_text."' onclick='verifAjoutApp();'/></td>\n";
	echo "</tr>\n";
	
?>
	<!--  Bouton Tester Connexion BDD -->
	<tr id="TestCnxLine">	
		<td colspan=2 style='text-align:center'><br><input id='testCxnBdd' type='button' value='<?php echo $formTestCxnBddBouton_text;?>'></td>
	</tr>
	
	</table>
	</form>
	<br>
	<div id="ResultTestCnx" style="text-align:center; color:yellow; display:none"></div>

	<script language='javascript' src='/portailv2/javascript/js/jquery-1.7.2.min.js' type='text/javascript'></script>
	
	<script type='text/javascript'>
		
		function verifAjoutApp()
		{	
			if(document.getElementById('formAjoutAppNom').value=='')
				alert('<?php echo $formAjoutAppNom_alert_text; ?>');
			else if(document.getElementById('formAjoutAppURL').value=='')
				alert('<?php echo $formAjoutAppURL_alert_text; ?>');
			else if (document.getElementById('formAjoutAppInterne').value!='on') {
				if (document.getElementById('formAjoutAppServeur').value=='')
					alert('<?php echo $formAjoutAppServeur_alert_text; ?>');
				else if(document.getElementById('formAjoutAppNomBase').value=='')
					alert('<?php echo $formAjoutAppNomBase_alert_text; ?>');
				else if(document.getElementById('formAjoutAppIdentifiant').value=='')
					alert('<?php echo $formAjoutAppIdentifiant_alert_text; ?>');
				else if(document.getElementById('formAjoutAppMotDePasse').value=='')
					alert('<?php echo $formAjoutAppMotDePasse_alert_text; ?>');
				else
					document.getElementById('formAjoutApp').submit();
			} 
			else
				document.getElementById('formAjoutApp').submit();
		}

		function hideOrShowInfoBdd() {
			if ($("#formAjoutAppInterne").attr("checked") == "checked") {
				$("#ServeurLine").show();
				$("#TypeServeurLine").show();
				$("#NomBaseLine").show();
				$("#IdentifiantLine").show();
				$("#MotDePasseLine").show();
				$("#TestCnxLine").show();
			}
			else {
				$("#ServeurLine").hide();
				$("#TypeServeurLine").hide();
				$("#NomBaseLine").hide();
				$("#IdentifiantLine").hide();
				$("#MotDePasseLine").hide();
				$("#TestCnxLine").hide();
			}
		}

		$(document).ready( function () {
			hideOrShowInfoBdd();
			$("#testCxnBdd").click(function() {
				$("#ResultTestCnx").hide();
				$.ajax({
					async: false,
					type: "POST",
					url: "<?php echo $_SERVER['PHP_SELF'];?>?action=testCnxBdd&id=<?php echo $id_app;?>",
					data: {
						BddServer    : $("#formAjoutAppServeur").val(),
						BddServerType: $("#formAjoutAppTypeServeur").val(),
						BddName      : $("#formAjoutAppNomBase").val(),
						BddUser      : $("#formAjoutAppIdentifiant").val(),
						BddPwd       : $("#formAjoutAppMotDePasse").val()
					},
					success: function(data, textStatus, jqXHR) {
						$("#ResultTestCnx").show().css("background-color", "green").html("<br>Connexion OK<br><br>");
					},
					error: function (jqXHR, textStatus, errorThrown) {
						$("#ResultTestCnx").show().css("background-color", "red").html("<br>Connexion KO<br>Erreur : "+jqXHR["responseText"]+"<br><br>");
					}
				});
			});
			
			$("#formAjoutAppInterne").change(function() {
				hideOrShowInfoBdd();
			});
		});


</script>