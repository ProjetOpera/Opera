<?php
/*session_start();
require_once("../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../portailv2/');*/

session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

//////////////
// libelles //
//////////////

$form_demande_confirm_suppr="Etes-vous sur de vouloir supprimer ce libelle ?";
$form_demande_confirm_suppr_oui="Oui";
$form_demande_confirm_suppr_non="Non";

// libelle message impossible suppr cat
$message_erreur_suppr_lib = "Impossible de supprimer le libelle car il est liee a un menu des applications";



/////////////
// require //
/////////////

require_once('../../connect.php');

?>


<!doctype html>

<html>

<title>
	<meta charset='utf-8'/>
</title>

<body>
<div  style='text-align: center'>
<?php
	$id=mysql_escape_string($_GET['id']);
	
	
	$sql_attach_lib="SELECT a.nom_appli
					FROM applications a, menus m, libelles l
					WHERE l.id='".$id."'
						AND l.id=m.code_libelle
						AND m.id_applications=a.id";

	$result_attach_lib=$ressourceBDD_appli->query($sql_attach_lib);
	

	if ($result_attach_lib->rowCount()==0)
	{
	
		echo "<form method='POST' action=''>\n";
		
		echo "<input id='form_suppr_id' name='form_suppr_id' type='hidden' value='".$id."'/>";
		
		echo "<p>".$form_demande_confirm_suppr."</p>";
		
		echo "<p>\n";
			echo "<input id='form_suppr_lib_confirm' name='form_suppr_lib_confirm' type='radio' value='oui'/>".$form_demande_confirm_suppr_oui."\n";
			echo "<input id='form_suppr_lib_confirm' name='form_suppr_lib_confirm' type='radio'value='nom' checked='checked'/>".$form_demande_confirm_suppr_non."\n";
		echo "</p>\n";

		echo "<input type='submit'/>\n";
		
		echo "</form>\n";
	}
	else
	{
		echo $message_erreur_suppr_lib." : <br/>\n";
		echo "<br/>\n";
		while ($row_attach_lib=$result_attach_lib->fetch(PDO::FETCH_ASSOC))
		{
			echo "- ".$row_attach_lib['nom_appli']."<br/>\n";		
		}
	}
	

?>
</div>

</body>

</html>

