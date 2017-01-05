<?php
	
	// connexion base APPLIS
	// *******************************************************
	session_start();
	require_once("../../../portailv2/functions/functions.php");
	$ressourceBDD_appli = connexion_externe('../../../portailv2/');

	
	//////////////
	// libelles //
	//////////////
	
	$lienModifApp="Modifer";

	// libelles formulaire Modif app
	$formModifAppNom_text = "Nom";
	$formModifAppURL_text = "Url";
	$formModifAppCategorie_text = "Categorie";
	$formModifAppInterne_text = "Interne";
	$formModifAppServeur_text = "Serveur base";
	$formModifAppTypeServeur_text = "Type base";
	$formModifAppNomBase_text = "Nom base";
	$formModifAppIdentifiant_text = "Identifiant";
	$formModifAppMotDePasse_text = "Mot de passe";
	$formModifAppBouton_text = "Enregistrer Modification";
	$formTestCxnBddBouton_text = "Test connexion BDD";
	
	// libelles alert javascript Modif app
	$formModifAppNom_alert_text = "Veuillez saisir un nom d application";
	$formModifAppURL_alert_text = "Veuillez saisir une URL";
	$formModifAppServeur_alert_text = "Veuillez saisir le serveur de la base";
	$formModifAppTypeServeur_alert_text = "Veuillez saisir le type de serveur de la base";
	$formModifAppNomBase_alert_text = "Veuillez saisir le nom de la base";
	$formModifAppIdentifiant_alert_text = "Veuillez saisir un identifiant";


	
	$id_app = mysql_escape_string($_GET['id']);
	$sql="SELECT 
			a.id AS AppId, 
			c.id AS CatId,
			a.nom_appli, 
			a.url_appli, 
			a.interne, 
			a.serveur_bdd, 
			a.type_serveur_bdd, 
			a.nom_bdd,
			a.user_bdd,
			a.password
	FROM applications a, categories c
	WHERE a.id_categories=c.id
		AND a.id=".$id_app;
	
	
	$result = $ressourceBDD_appli->query($sql);
	$line = $result->fetch(PDO::FETCH_ASSOC);
	$id_app = $line['AppId'];
	$id_cat = $line['CatId'];
	$nom_app = $line['nom_appli'];
	$url_app = $line['url_appli'];
	$interne_app = ($line['interne'] == 1) ? "checked='checked' " : "";
	$serveur_base_app = $line['serveur_bdd'];
	$type_serveur_base_app = $line['type_serveur_bdd'];
	$nom_base_app = $line['nom_bdd'];
	$user_base_app = $line['user_bdd'];
	$password = $line['password'];
	
	if ($_REQUEST['action'] == 'testCnxBdd') {
		$bddServer = $_REQUEST['BddServer'];
		$bddServerType = $_REQUEST['BddServerType'];
		$bddName = $_REQUEST['BddName'];
		$bddUser = $_REQUEST['BddUser'];
		if ($_REQUEST['IsPwdModify'] == 'true') {
			$bddPwd = $_REQUEST['BddPwd'];
		}
		else {
			$bddPwd = $password;
		}

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
	
	// ENTETE HTML
	// header_top('');


?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	</head>

	<body>

	<!--  Modif -->
	<!-- ////// -->
	
	<form id='formModifApp' name='formModifApp' method='post' action=''>
	<table>
		
	<!--  id app -->
	<td><input id='formModifAppId' name='formModifAppId' type='hidden' value='<?php echo $id_app;?>'/></td>	
		
	<!--  Nom -->
	<tr>
		<td><?php echo $formModifAppNom_text;?></td>
		<td><input id='formModifAppNom' name='formModifAppNom' type='text' value='<?php echo $nom_app;?>'/></td>
	</tr>
	
	<!--  URL -->
	<tr>
		<td><?php echo $formModifAppURL_text;?></td>
		<td><input id='formModifAppURL' name='formModifAppURL' type='text' value='<?php echo $url_app;?>'/></td>
	</tr>
	
	<!--  Categorie -->
	<tr>	
		<td><?php echo $formModifAppCategorie_text;?></td>
		<td>
		
			<select id='formModifAppCategorie' name='formModifAppCategorie'>
			
<?php
			$sql_formModifAppCategorie = "SELECT id,nom_categorie FROM categories";
			$result_formModifAppCategorie = $ressourceBDD_appli->query($sql_formModifAppCategorie);
			while ($row_formModifAppCategorie = $result_formModifAppCategorie->fetch(PDO::FETCH_ASSOC))
			{
				if($id_cat==$row_formModifAppCategorie['id']) {
?>
					<option selected='selected' value='<?php echo $row_formModifAppCategorie['id']."'>".$row_formModifAppCategorie['nom_categorie'];?></option>
<?php
				}
				else {	
?>
					<option value='<?php echo $row_formModifAppCategorie['id'];?>'><?php echo $row_formModifAppCategorie['nom_categorie'];?></option>
<?php
				}
			}
?>
			
			</select>
		
		
		</td>
	</tr>
		
	<!--  Interne	 -->
	<tr>	
		<td><?php echo $formModifAppInterne_text;?></td>
		<td><input <?php echo $interne_app;?> id='formModifAppInterne' name='formModifAppInterne' type='checkbox'/></td>
	</tr>
	
		
	<!--  Serveur -->
	<tr id="ServeurLine">
		<td><?php echo $formModifAppServeur_text;?></td>
		<td><input id='formModifAppServeur' name='formModifAppServeur' type='text' value='<?php echo $serveur_base_app;?>'/></td>
	</tr>	
	
	<!--  Type de Serveur -->
	<tr id="TypeServeurLine">
		<td><?php echo $formModifAppTypeServeur_text;?></td>
		<td><select id='formModifAppTypeServeur' name='formModifAppTypeServeur'>
			<option value='MYSQL'>MYSQL</option>
			<option value='SQLSERVER'>SQLSERVER</option>
		</select>
		</td>
	</tr>	
	
	<!--  Base -->
	<tr id="NomBaseLine">	
		<td><?php echo $formModifAppNomBase_text;?></td>
		<td><input id='formModifAppNomBase' name='formModifAppNomBase' type='text' value='<?php echo $nom_base_app;?>'/></td>
	</tr>

	<!--  Identifiant -->
	<tr id="IdentifiantLine">	
		<td><?php echo $formModifAppIdentifiant_text;?></td>
		<td><input id='formModifAppIdentifiant' name='formModifAppIdentifiant' type='text' value='<?php echo $user_base_app;?>'/></td>
	</tr>	
	
	<!--  Mot de passe -->
	<tr id="MotDePasseLine">	
		<td><?php echo $formModifAppMotDePasse_text;?></td>
		<td>
			<input id='formModifAppMotDePasse' name='formModifAppMotDePasse' type='password' placeholder='Saisir un nouveau Pwd' title='Saisir un nouveau Pwd ou laisser vide si pas de modification' value='<?php echo ($password ? "xxxxxxxxxxxxxxxx" : "");?>'/>
			<input id='isModifyPwd' name='isModifyPwd' type='hidden' value='false'>
		</td>
	</tr>
	
	<!--  Bouton Modifer -->
	<tr>	
		<td colspan=2 style='text-align:center'><br><input id='formModifBouton' name='formModifBouton' type='button' style='text-align:center' value='<?php echo $formModifAppBouton_text;?>' onclick='verifModifApp();'/></td>
	</tr>
	
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
		function verifModifApp()
		{	
			if(document.getElementById('formModifAppNom').value=='') alert('<?php echo $formModifAppNom_alert_text; ?>');
			else if(document.getElementById('formModifAppURL').value=='')	alert('<?php echo $formModifAppURL_alert_text; ?>');
			else if (document.getElementById('formModifAppInterne').value!='on') {
					 if(document.getElementById('formModifAppServeur').value=='')	alert('<?php echo $formModifAppServeur_alert_text; ?>');
				else if(document.getElementById('formModifAppTypeServeur').value=='')	alert('<?php echo $formModifAppTypeServeur_alert_text; ?>');
				else if(document.getElementById('formModifAppNomBase').value=='')	alert('<?php echo $formModifAppNomBase_alert_text; ?>');
				else if(document.getElementById('formModifAppIdentifiant').value=='')	alert('<?php echo $formModifAppIdentifiant_alert_text; ?>');
				else	document.getElementById('formModifApp').submit();
			}
			else	document.getElementById('formModifApp').submit();
		}

		function hideOrShowInfoBdd() {
			if ($("#formModifAppInterne").attr("checked") == "checked") {
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
						BddServer    : $("#formModifAppServeur").val(),
						BddServerType: $("#formModifAppTypeServeur").val(),
						BddName      : $("#formModifAppNomBase").val(),
						BddUser      : $("#formModifAppIdentifiant").val(),
						BddPwd       : $("#formModifAppMotDePasse").val(),
						IsPwdModify  : $("#isModifyPwd").val()
					},
					success: function(data, textStatus, jqXHR) {
						$("#ResultTestCnx").show().css("background-color", "green").html("<br>Connexion OK<br><br>");
					},
					error: function (jqXHR, textStatus, errorThrown) {
						$("#ResultTestCnx").show().css("background-color", "red").html("<br>Connexion KO<br><br>"+jqXHR["responseText"]+"<br><br>");
					}
				});
			});
			
			$("#formModifAppMotDePasse").change(function (data) {
				 var defVal = $(this).prop("defaultValue");
				 var newValue = $(this).val();
				 if (($(this).prop("defaultValue") == newValue) || (newValue =="")) {
					$("#isModifyPwd").val('false');
				 }
				 else {
					$("#isModifyPwd").val('true');
				 }
			});
			
			$("#formModifAppInterne").change(function() {
				hideOrShowInfoBdd();
			});
		});



	</script>

	</body>
	</html>
