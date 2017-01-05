<?php

	session_start();
	require_once("../../../portailv2/functions/functions.php");
	require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/librairie.inc.php");
	// require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/debug.inc.php");

	$ressourceBDD_appli = connexion_externe('../../../portailv2/');

	$racine = "aucun";
	$form_modif_alert_text_libelle = "Veuillez saisir un Libelle";
	$form_modif_alert_text_url = "Veuillez saisir une URL";
	$form_modif_alert_text_niveau = "Veuillez choisir un niveau";
	$form_modif_alert_text_presence_id_textuel = "Veuillez saisir l'identifiant textuel du menu";
	$form_modif_alert_text_conformite_id_textuel = "L'identifiant textuel du menu n'est pas correct\\nIl ne doit contenir que des caratères alphanumeriques '[a-zA-Z0-9 _-]'";
	$message_erreur_suppr_menu = "Vous ne pouvez supprimer ce menu car il poss&egrave;de des sous menus";
	$titre_ajout_menu = "Ajout de menu";
	$titre_modif_menu = "Modification de menu";
	$oui = "oui";
	$non = "non";

	/***************************************
	 *   Fonction de d'affichag des parent *
	 ***************************************/
	function afficherChoixParent ($idParentDuMenuModifie, $idParent = -1, $niv = 0) {
		global $ressourceBDD_appli;
		
		$sql1 = "
			SELECT menus.id, traduction, ordre
			FROM menus, libelles_trad, applications, lookup_values
			WHERE code_libelle = id_libelle
				AND id_applications = applications.id
				AND lookup_values.id = libelles_trad.id_lookup_values
				AND lookup_values.value = '{$_SESSION['PORTAIL\lang']}' AND lookup_values.type = 'langue'
				AND parent = $idParent
				".(isset ($_GET['id']) ? "AND menus.id != {$_GET['id']}" : "")."
				AND id_applications = {$_GET['id_appli']}
			ORDER BY ordre";
		$req1 = $ressourceBDD_appli->query($sql1) or ErrorPdo (__FILE__, __LINE__, $sql1, $ressourceBDD_appli);

		while ($line = $req1->fetch(PDO::FETCH_ASSOC)) {
			if ($niv) {
				$nbsp = '&nbsp;';
				for ($i = 1; $i < $niv; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;&nbsp;";

				if ($nbsp) $indent = "$nbsp|- ";
			}
			echo "<option value='{$line['id']}' ".($idParentDuMenuModifie == $line['id'] ? "selected" : "").">$indent{$line['traduction']}</option>\n";
			afficherChoixParent ($idParentDuMenuModifie, $line['id'], $niv+1);
		}
	}
	
	switch ($_GET['type']) {
	case 'ajout' :
		$titre = $titre_ajout_menu;
		break;
	case 'modif' :
		$titre = $titre_modif_menu;
		break;
	case 'suppr' :
		break;
	default :
		return;
	}
?>
	<html><head>
		<meta charset=utf-8' />
	</head>
	<body>
<?php
	/**********************************************
	 *    Ajout et Modification de Menu           *
	 **********************************************/
	 
	if ($_GET['type'] != 'suppr') {
		header('Expires: Sun, 19 Nov 1978 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');
	
?>
		<h1><?php echo $titre;?></h1>
		<form method='POST' name='formulaire' id='formulaire' action=''>
		<input type='hidden' name='bdd' value='<?php echo $_GET['type'];?>' />
		<input type='hidden' name='id' value='<?php echo $_GET['id'];?>' />
		<input type='hidden' name='appli' value='<?php echo $_GET['id_appli'];?>' />
		<input type='hidden' name='id_menu' value='<?php echo $_GET['id_menu'];?>' />

		<table style='width:400px'><tbody>
<?php
		// Rechercher les donnees du menu a modifier
		$tableau = array();
		if (isset ($_GET['id'])) {
			$query = "				
				SELECT 	menus.id,
						libelles_trad.traduction,
						IF (menus.id_textuel = CONCAT('NULL', menus.id), '', menus.id_textuel) id_textuel,
						menus.url,
						menus.parent,
						menus.code_libelle,
						menus.id_level,
						libelles_trad.id_libelle
				FROM libelles_trad, lookup_values, menus
				WHERE libelles_trad.id_libelle = menus.code_libelle
					AND lookup_values.id = libelles_trad.id_lookup_values
					AND lookup_values.value = '{$_SESSION['PORTAIL\lang']}' AND lookup_values.type = 'langue'
					AND menus.id = {$_GET['id']}
				";
			//$req0 = mysql_query($sql0);
			$req0 = $ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);

			$tableau = $req0->fetch(PDO::FETCH_ASSOC);
		}
		/****************************
		 *   Affichage de libelle   *
		 ****************************/
?>
		<tr>
		<td>Libell&eacute;</td>
		<td>
			<select name='libelle' id='libelle'>
				<option value='0'></option>
<?php
		$query = "
			SELECT libelles.id,  libelles.code, libelles_trad.traduction
			FROM libelles
			LEFT JOIN libelles_trad ON libelles_trad.id_libelle = libelles.id
			LEFT JOIN lookup_values on lookup_values.id = libelles_trad.id_lookup_values
			WHERE lookup_values.value = '{$_SESSION['PORTAIL\lang']}' AND lookup_values.type = 'langue'
				AND code LIKE 'menu_%'
			ORDER BY traduction
			";
		$result = $ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
		$line_lib_all = $result-> fetchAll(PDO::FETCH_ASSOC);
		foreach ($line_lib_all as $line_lib) {
			//Memoriser le code de libelle selectionne
			if ($tableau['id_libelle'] == $line_lib['id'])
				$code_libelleSelected = $line_lib['code'];
			echo "<option value='{$line_lib['id']}' ".($tableau['id_libelle'] == $line_lib['id'] ? "SELECTED" : "").">{$line_lib['traduction']}</option>\n";
		}
?>
			</select>
		</td>
		</tr>
		
		<tr style="color:#A7A37E; vertical-align:top;">
		<td>Code du libell&eacute;</td>
		<td><span id='id_codeLibelle' /><?php echo $code_libelleSelected;?></span><br><br></td>
		</tr>

		<tr>
		<td>Identifiant textuel</td>
		<td><input type='text' value='<?php echo $tableau['id_textuel'];?>' name='id_textuel' id='id_textuel' style='width:99%' /></td>
		</tr>

		<tr>
		<td>URL</td>
		<td><input type='text' value='<?php echo $tableau['url'];?>' name='url' id='url' style='width:99%' /></td>
		</tr>

		<!--LEVEL ACCESS -->
		<tr>
		<td>Niveau</td>
		<td>
			<select name='level' id='level'>
				<option></option>
	<?php
		$query = "	SELECT 	id,
							level
					FROM level_access
					ORDER BY level";
		$req_level = $ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);

		while ($level_line = $req_level->fetch(PDO::FETCH_ASSOC)){
			echo "<option value='{$level_line['id']}' ".($level_line['id']==$tableau['id_level'] ? "selected" : "").">{$level_line['level']}</option>";
		}
	?>
			</select>
		</td></tr>

		<tr>
		<td>Parent</td>
		<td>
			<select name='parent' id='parent'>
				<option value='-1'>- <?php echo $racine;?> -</option>
	<?php
		//requete menu - parent
		
		afficherChoixParent (isset ($tableau['parent']) ? $tableau['parent'] : -1);
	?>
			</select>
		</td>
		</tr>
		<tr>
		<td COLSPAN=2 STYLE="TEXT-ALIGN: center"><BR><input type='button' value='Valider' onclick='verif_modif_menu("formulaire")' /><BR></td>
		</tr>
		</tbody>
		</table>
		</form>
	<?php



	}

	/***************************************************************************************************
	**** SUPPRESSION MENU
	****************************************************************************************************/
	else {
		$id = intval($_GET['id']);
		$sql0 = "
			SELECT 1 FROM menus	WHERE parent = $id";
		$req0 = $ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);

		if ($req0->rowCount()>0) {
?>
			<div style='text-align:center'><?php echo $message_erreur_suppr_menu;?></div>
<?php
		}
		else {
?>
			<div style='text-align:center'>
			<form method='POST' action=''>
			<input id='id' name='id' type='hidden' value='<?php echo $id;?>'/>
			<input id='appli' name='appli' type='hidden' value='<?php echo $_GET['appli'];?>'/>
			<p>Voulez-vous supprimer ce menu ?</p>
			<p>
				<input id='checkbox' name='checkbox' type='radio' value='1'/><?php echo $oui;?>
				<input id='checkbox' name='checkbox' type='radio' value='0' checked='checked'/><?php echo $non;?>
			</p>
			<input type='submit' value='Valider' />
			</form>
			</div>
<?php
		}
	}

?>
	<script language='javascript' src='/portailv2/javascript/js/jquery-1.7.2.min.js' type='text/javascript'></script>
	<script type='text/javascript'>
		
		function verif_modif_menu(form)
		{	
			//Tester la presence de LIBELLE
			if(document.getElementById('libelle').value=='') {
				alert ("<?php echo $form_modif_alert_text_libelle; ?>")
				document.getElementById('libelle').focus ()
				return
			}
			//Tester la presence de id_textuel du meni si l'URL est present
			if(document.getElementById('url').value != '') {
				if(document.getElementById('id_textuel').value == '') {
					alert ("<?php echo $form_modif_alert_text_presence_id_textuel; ?>")
					document.getElementById('level').focus ()
					return
				}
				
				var regexp = new RegExp("[^a-zA-Z0-9 _\-]+", "g");
				if (regexp.test (document.getElementById('id_textuel').value)){
					alert ("<?php echo $form_modif_alert_text_conformite_id_textuel; ?>")
					document.getElementById('level').focus ()
					return
				}
			}
			//Tester la presence de NIVEAU
			if(document.getElementById('level').options[document.getElementById('level').options.selectedIndex].value=='') {
				alert ("<?php echo $form_modif_alert_text_niveau; ?>")
				document.getElementById('level').focus ()
				return
			}

			document.getElementById(form).submit();
		}

		$(document).ready(function(){
			code_libelle = new Array();
<?php
			foreach ((array)$line_lib_all as $line_lib) {
				echo "code_libelle[{$line_lib['id']}] = '{$line_lib['code']}';\n";
			}
?>
			$("#libelle").change(function() {
				var valSelected = $(this).val();
				$("#id_codeLibelle").html(code_libelle[valSelected]);
			});
		});

	</script>
	</body>
	</html>
