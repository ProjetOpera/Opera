<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');


//////////////
// libelles //
//////////////

$ajout_level_titre = "Ajout niveau";

// formulaire
$form_ajout_level = "Niveau";
$form_ajout_level_description = "Description";
$form_ajout_groupe_bouton = "Ajouter";

// alert js

$alert_js_level = "Veuillez saisir un niveau d'acces";
$alert_js_description = "Veuillez saisir une description";


$__commun_id_menu = $_GET['id_menu'];


// AFFICHAGE FORMULAIRE
// ***************************************************************************************
if (!isset($_POST['formAjoutLevelFlag']) || $_POST['formAjoutLevelFlag'] = !'OK') {
?>

<!doctype html>

<html>
	<head>
		<script language="javascript">
					              function verifAjoutLevel() {
						                var level = document.getElementById('formAjoutLevel').value;
						                var description = document.getElementById('formAjoutLevelDescription').value;
								
						                if(level=="") alert("<?php echo $alert_js_level; ?>");
						                else if(description=="") alert("<?php echo $alert_js_description; ?>");
						                else document.getElementById('formAjoutLevel').submit();
						            }
		</script> 
					    </head>
					  <body>
<?php
            echo "<h1>" . $ajout_level_titre . "</h1>";

            echo "<form method='POST' action='include/groupesusers/Gestion_Ajout_level.php?id_menu=" . $__commun_id_menu . "' id='formAjoutLevel' name='formAjoutLevel'>\n";
            echo "<input id='formAjoutLevelFlag' name='formAjoutLevelFlag' type='hidden' value='OK'/>\n";
            echo "<table>\n";
            // Level
            echo "	<tr>\n";
            echo "		<td>" . $form_ajout_level . "</td>\n";
            echo "		<td><input id='formAjoutLevel' name='formAjoutLevel' type='text'/></td>\n";
            echo "	</tr>\n";

            // Description
            echo "	<tr>\n";
            echo "		<td>" . $form_ajout_level_description . "</td>\n";
            echo "		<td><input id='formAjoutLevelDescription' name='formAjoutLevelDescription' type='text'/></td>\n";
            echo "	</tr>\n";

            // Bouton
            echo "	<tr>\n";
            echo "		<td></td>\n";
            echo "		<td><input onclick='verifAjoutLevel()' type='button' value='" . $form_ajout_groupe_bouton . "'/></td>\n";
            echo "	</tr>\n";

            echo "</table>\n";

            echo "</form>\n";
?>
				    </body>
				
				</html>
<?php

}

// INSERTION BDD
// ***************************************************************************************
elseif (isset($_POST['formAjoutLevelFlag']) && $_POST['formAjoutLevel'] != null && $_POST['formAjoutLevelDescription'] != null) {

            $level = $_POST['formAjoutLevel'];
            $description_level = $_POST['formAjoutLevelDescription'];
            $req = "insert into level_access (level, description) values ('$level','$description_level')";
            $ressourceBDD_appli->query($req);
            header("Location: /portailadmin/id_menu=$__commun_id_menu");
}
?>
        



