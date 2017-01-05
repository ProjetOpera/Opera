<?php
session_start();

require_once("../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../portailv2/');

require_once("../../connect.php");
require_once("../../variables_".$_SESSION['PORTAIL\lang'].".php");
require_once("../../variables.php");
include_once("../../../commun/functions/functions.php");
$titre_ajout_param = "Ajout de parametre";
$titre_modif_param = "Modification de parametre";
$form_modif_alert_text_code = "Renseigner un code";
$form_modif_alert_text_checkbox = "Renseigner un type";
$form_modif_alert_text_type = "Renseigner un type"; 
$form_modif_alert_text_valeur = "Renseigner une valeur"; 
$form_modif_alert_int_type = "Renseigner une Valeur de type INT";


header('Expires: Sun, 19 Nov 1978 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
echo "<html>";
echo "<head></head>";
echo "<body>";


/***************************************************************************************************
**** AJOUT PARAMETRE
****************************************************************************************************/
if ($_GET['type']=='ajout') {
	echo "<h1>$titre_ajout_param</h1>";
	echo "<form method='POST' name='form_ajout' id='form_ajout' action=''>";
	echo "	<input type='hidden' name='bdd' value='ajout' />";
	echo "	<input type='hidden' name='appli' value='".$_GET['id_appli']."' />";
	echo "	<input type='hidden' name='id_menu' value='".$_GET['id_menu']."' />";

	echo "<table style='width:350px'><tbody>\n";
	echo "<tr><td>Code</td><td><input type='text' name='code' id='code' /></td></tr>";
	
	echo "<tr><td>Type de valeur</td><td>";
	echo "	<input id='checkbox1' name='checkbox' type='radio' value='i'/>INT&nbsp;&nbsp;";
	echo "	<input id='checkbox2' name='checkbox' type='radio' value='v'/>VARCHAR&nbsp;&nbsp;";
	echo "	<input id='checkbox3' name='checkbox' type='radio' value='d'/>DATE";
	echo "</td></tr>";
	
	echo "<tr><td>Valeur</td><td><input type='text' name='valeur' id='valeur'</td></tr>";
	echo "<tr><td colspan='2'><input type='button' value='Ajouter' onclick='verif_modif_menu(\"form_ajout\")' /></td></tr>\n";
	echo "</tbody></table>";
	echo "</form>";

}

/***************************************************************************************************
**** MODIFICATION PARAMETRE
****************************************************************************************************/
if ($_GET['type']=='modif') {
	echo "<h1>$titre_modif_param</h1>";
	echo "<form method='POST' name='form_ajout' id='form_ajout' action=''>";
	echo "	<input type='hidden' name='bdd' value='ajout' />";
	echo "	<input type='hidden' name='appli' value='".$_GET['id_appli']."' />";
	echo "	<input type='hidden' name='id_menu' value='".$_GET['id_menu']."' />";

	echo "<table style='width:350px'><tbody>\n";
	echo "<tr><td>Code</td><td><input type='text' name='code' id='code' /></td></tr>";
	
	echo "<tr><td>Type de valeur</td><td>";
	echo "	<input id='checkbox1' name='checkbox' type='radio' value='i'/>INT&nbsp;&nbsp;";
	echo "	<input id='checkbox2' name='checkbox' type='radio' value='v'/>VARCHAR&nbsp;&nbsp;";
	echo "	<input id='checkbox3' name='checkbox' type='radio' value='d'/>DATE";
	echo "</td></tr>";
	
	echo "<tr><td>Valeur</td><td><input type='text' name='valeur' id='valeur'</td></tr>";
	echo "<tr><td colspan='2'><input type='button' value='Ajouter' onclick='verif_modif_menu(\"form_ajout\")' /></td></tr>\n";
	echo "</tbody></table>";
	echo "</form>";
}



echo "</body></html>\n";
?>


<script type='text/javascript'>
	
	function verif_modif_menu(formulaire)
	{	
		var alerte = "";
		if(document.getElementById('code').value=='')	alerte += "<?php echo $form_modif_alert_text_code; ?>";
		if(document.getElementById('checkbox1').checked==false && document.getElementById('checkbox2').checked==false && document.getElementById('checkbox3').checked==false)	
			alerte += "\r\n<?php echo $form_modif_alert_text_type; ?>";
		else if (document.getElementById('checkbox1').checked==true && isNaN(document.getElementById('valeur').value)) alerte += "\r\n<?php echo $form_modif_alert_int_type; ?>";
				
		if(document.getElementById('valeur').value=='')	alerte += "\r\n<?php echo $form_modif_alert_text_valeur; ?>";
		
		if (alerte!="") alert(alerte);
		else	document.getElementById(formulaire).submit();
	}

</script>