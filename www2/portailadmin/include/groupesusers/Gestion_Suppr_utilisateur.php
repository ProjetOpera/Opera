<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');

//////////////
// libelles //
//////////////

$suppr_user_titre = "Suppr utilisateur";

// formulaire
$form_suppr_user_confirm = "Etes-vous sûr de vouloir supprimer cet utilisateur ?";
$form_suppr_user_confirm_oui = "Oui";
$form_suppr_user_confirm_non = "Non";
$formSupprUserSubmit = "Soumettre";

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

    echo "<h1>" . $suppr_user_titre . "</h1>\n";
    $id = mysql_escape_string($_GET['id']);

    echo "<form id='formSupprUser' name='formSupprUser' method='POST' action='include/groupesusers/Gestion_Suppr_utilisateur.php?id=" . $id . "&id_menu=" . $__commun_id_menu . "&reponse=1'>\n";
    echo "	<p>" . $form_suppr_user_confirm . "</p>\n";

    echo "	<p>\n";
    echo "		<input id='formSupprUserRadio' name='formSupprUserRadio' type='radio' value='" . $id . "'/>" . $form_suppr_user_confirm_oui;
    echo "		<input id='formSupprUserRadio' name='formSupprUserRadio' type='radio' value='non' /checked>" . $form_suppr_user_confirm_non;
    echo "	</p>\n";

    echo "	<p><input type='submit' value='" . $formSupprUserSubmit . "'/></p>\n";

    echo "</form>\n";
}

// SUPRESSION DU User EN MEMOIRE
if (isset($_POST['formSupprUserRadio']) && $_POST['formSupprUserRadio'] != 'non') {

    // suppression dans la table user_access
    $id_user = $_POST['formSupprUserRadio'];
    $req = "delete from user_access where id=$id_user";
    $ressourceBDD_appli->query($req);

    // suppression dans la table d'association des groupes
    $req2 = "delete from group_has_user_acces where id_user_access=$id_user";
    $ressourceBDD_appli->query($req2);

    header("Location: /portailadmin/id_menu=$__commun_id_menu");
} else if (isset($_POST['formSupprUserRadio']) && $_POST['formSupprUserRadio'] == 'non') {
    header("Location: /portailadmin/id_menu=$__commun_id_menu");
}
?>
        </div>
    </body>

</html>


