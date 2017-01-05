<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

//require_once('../../connect.php');





//////////////
// libelles //
//////////////

$titre_AjoutLib = "Ajout libelle";

// libelles formulaire ajout 
$form_ajout_libelle_Code_text = "Code";
$form_ajout_libelle_Description_text = "Description";
$form_ajout_libelle_Valeur_text = "Valeur";
$form_ajout_libelle_Nouvelle_Langue_header_text = "Nouvelle Langue";
$form_ajout_libelle_Nouvelle_Langue_Valeur_text = "Valeur";
$form_ajout_libelle_Nouvelle_Langue_text = "Langue";
$form_ajout_libelle_Bouton_text = "Ajouter";

// libelles alert javascript ajout 
$formAjoutLibCode_alert_text = "Veuillez saisir un code de libelle";
$formAjoutLibValeur_alert_text = "Veuillez saisir une valeur";
$formAjoutLibLang_alert_text = "Veuillez saisir une langue";

$contenu_js="";


?>

<!doctype html>

<html>
    <head>
        <meta charset='utf-8'/>
    </head>

    <body>
<script type='text/javascript'>
	
	function verifAjoutLibelle()
	{	
		if(document.getElementById('formAjoutLibelleCode').value==''){
			alert('<?php echo $formAjoutLibCode_alert_text; ?>');
		<?php
		if($contenu_js!="")
		{
			echo "else if(".$contenu_js.")\n";
			echo "alert('".$formAjoutLibValeur_alert_text."');";
		}
		?>
		} else
			document.getElementById('formAjoutLibelle').submit();
	}
</script>

<?php
//////////////////////////////
// formulaire ajout libelle //
//////////////////////////////

echo "<h1>".$titre_AjoutLib."</h1>\n";

	
echo "<form id='formAjoutLibelle' name='formAjoutLibelle' method='POST' action=''>\n";
	echo "<input id='formAjoutLibelleFlag' name='formAjoutLibelleFlag' value='OK' type='hidden'>\n";
	echo "<table>\n";
	
	
	// Code
	echo "<tr>\n";
		echo "<td>".$form_ajout_libelle_Code_text."</td>\n";
		echo "<td><input id='formAjoutLibelleCode' name='formAjoutLibelleCode' type='text'/></td>\n";	
	echo "</tr>\n";
	
	// Description
	echo "<tr>\n";
		echo "<td>".$form_ajout_libelle_Description_text."</td>\n";
		echo "<td><input id='formAjoutLibelleDescription' name='formAjoutLibelleDescription' type='text'/></td>\n";		
	echo "</tr>\n";
	
	// Valeur
	
	$sql_recup_lang="SELECT value FROM lookup_values WHERE type='langue' ORDER BY upper(value)";
	$result_recup_lang=$ressourceBDD_appli->query($sql_recup_lang);
	
	while ($row_recup_lang = $result_recup_lang->fetch(PDO::FETCH_ASSOC))
	{
		
		echo "<tr>\n";
			echo "<td>".$form_ajout_libelle_Valeur_text."(".$row_recup_lang['value'].")</td>\n";
			echo "<td><input id='formAjoutLibelleValeur_".$row_recup_lang['value']."' name='formAjoutLibelleValeur_".$row_recup_lang['value']."' type='text'/></td>\n";	
		echo "</tr>\n";
		
		// contenu js
		if($contenu_js=="")
			$contenu_js .= "document.getElementById('formAjoutLibelleValeur_".$row_recup_lang['value']."').value==''";
		else
		 $contenu_js .= " && document.getElementById('formAjoutLibelleValeur_".$row_recup_lang['value']."').value==''";
		
	}
	
	// Bouton ajout
	echo "<tr>\n";
		echo "<td></td>\n";
		echo "<td><input type='button' value='".$form_ajout_libelle_Bouton_text."' onclick='verifAjoutLibelle();'/></td>\n";	
	echo "</tr>\n";
	
	echo "</table>\n";

echo "</form>";




?>

 
 </body>

</html>
