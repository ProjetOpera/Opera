<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

//////////////
// libelles //
//////////////
$suppr_level_titre = "Suppression niveau";
$suppression_impossible = "- Impossible de supprimer le niveau car il existe des d&eacute;pendances dans les menus et/ou groupes utilisateurs -";

// formulaire
$form_suppr_level_confirm = "Etes-vous sur de vouloir supprimer ce niveau ?";
$form_suppr_level_confirm_oui = "Oui";
$form_suppr_level_confirm_non = "Non";
$formSupprLevelSubmit = "Soumettre";

/////////////
// require //
/////////////

require_once("../../connect.php");
?>

<!doctype html>

<html>
    <head>
        <meta charset='utf-8'/>
    </head>

    <body>

        <div style='text-align: center'>

<?php
$__commun_id_menu = $_GET['id_menu'];

if (!isset($_GET['reponse'])) {

    echo "<h1>" . $suppr_level_titre . "</h1>\n";
    $id = mysql_escape_string($_GET['id']);

    // Suppression possible si le level n'est pas lié à un groupe
    $req_group = "select 1 from group_has_level_acces,menus where id_level_access =$id OR id_level=$id";
    $result_group = $ressourceBDD_appli->query($req_group);
    if ($result_group->rowCount()!=0)	echo "<div>$suppression_impossible</div>";
    else {
	    echo "<form id='formSupprLevel' name='formSupprLevel' method='POST' action='include/groupesusers/Gestion_Suppr_level.php?id=" . $id . "&id_menu=" . $__commun_id_menu . "&reponse=1'>\n";
	    echo "	<p>" . $form_suppr_level_confirm . "</p>\n";
	    echo "	<p>\n";
	    echo "		<input id='formSupprLevelRadio' name='formSupprLevelRadio' type='radio' value='" . $id . "'/>" . $form_suppr_level_confirm_oui;
	    echo "		<input id='formSupprLevelRadio' name='formSupprLevelRadio' type='radio' value='non' /checked>" . $form_suppr_level_confirm_non;
	    echo "	</p>\n";
	    echo "	<p><input type='submit' value='" . $formSupprLevelSubmit . "'/></p>\n";
	    echo "</form>\n";
  }
}

// SUPRESSION DU Level EN MEMOIRE
if (isset($_POST['formSupprLevelRadio']) && $_POST['formSupprLevelRadio'] != 'non') {

    // suppression dans la table level_access
    $id_level = $_POST['formSupprLevelRadio'];
    $req = "delete from level_access where id=$id_level";
    $ressourceBDD_appli->query($req);

    // suppression dans la table d'association des groupes
    $req2 = "delete from group_has_level_acces where id_level_access=$id_level";
    $ressourceBDD_appli->query($req2);

    header("Location: /portailadmin/id_menu=$__commun_id_menu");
} else if (isset($_POST['formSupprLevelRadio']) && $_POST['formSupprLevelRadio'] == 'non') {
    header("Location: /portailadmin/id_menu=$__commun_id_menu");
}
?>
        </div>
    </body>

</html>


