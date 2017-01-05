<?php

//////////////
// libelles //
//////////////


// libelle formulaire ajout categorie
$form_suppr_cat_demande_confirm = "Etes-vous sur de vouloir supprimer cette categorie ?";
$form_suppr_cat_demande_confirm_oui = "Oui";
$form_suppr_cat_demande_confirm_non = "Non";
$form_suppr_cat_submit = "Soumettre";

// libelle message impossible suppr cat
$message_erreur_suppr_cat = "Impossible de supprimer la categorie car elle est liee aux applications suivantes";

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
<div style='text-align: center'>
<?php

	$id=mysql_real_escape_string($_GET['id']);
	
	$sql_attach_app="SELECT a.nom_appli
					FROM applications a, categories c
					WHERE c.id='".$id."'
						AND a.id_categories=c.id";
	$result_attach_app=$ressourceBDD_appli->query($sql_attach_app);
	
	// si pas app attach cat
	if ($result_attach_app->rowCount()==0)
	{
		echo "<form id='formSupprCat' name='formSupprCat' method='POST' action=''>\n";
		echo "	<p>".$form_suppr_cat_demande_confirm."</p>\n";
		echo "	<p>\n";
		echo "		<input id='formSupprCatConfirm' name='formSupprCatConfirm' value='".$id."' type='radio'/>".$form_suppr_cat_demande_confirm_oui."\n";
		echo "		<input id='formSupprCatConfirm' name='formSupprCatConfirm' value='' type='radio' checked/>".$form_suppr_cat_demande_confirm_non."\n";
		echo "	</p>\n";
		echo "	<p>\n";
		echo "		<input value='".$form_suppr_cat_submit."' type='submit'/>\n";
		echo "	</p>\n";
		echo "</form>\n";
	}
	// sinon
	else
	{
		echo $message_erreur_suppr_cat." : <br/>\n";
		echo "<br/>\n";
		while ($row_attach_app=$result_attach_app->fetch(PDO::FETCH_ASSOC))
		{
			echo "- ".$row_attach_app['nom_appli']."<br/>\n";		
		}
	}

?>
</div>
</body>

</html>

