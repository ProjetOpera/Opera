<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');


//////////////
// libelles //
//////////////

$ajout_groupe_titre = "Ajout groupe";

// formulaire
$form_ajout_groupe_nom = "Nom";
$form_ajout_groupe_description = "Description";
$form_ajout_groupe_parent = "Parent";
$form_ajout_groupe_bouton = "Ajouter";

// alert js

$alert_js_nom = "Veuillez saisir un nom";
$alert_js_description = "Veuillez saisir une description";


/////////////
// require //
/////////////

require_once("../../connect.php");

$__commun_id_menu = $_GET['id_menu'];
?>


<!doctype html>

<html>
    <head>
        <meta charset='utf-8'/>
    </head>

    <body>

        <script>

            function verifAjoutGroup(){
                var nom = document.getElementById('formAjoutGroupeNom').value;
                var description = document.getElementById('formAjoutGroupeDescription').value;
		
                if(nom=="")
                    alert ('<?php echo $alert_js_nom; ?>');
                else if(description=="")
                    alert ('<?php echo $alert_js_description; ?>');
                else 
                    document.getElementById('formAjoutGroupe').submit();
            }

        </script>

        <?php
        if (!isset($_POST['formAjoutGroupeFlag']) || $_POST['formAjoutGroupeFlag'] = !'OK') {

            echo "<h1>" . $ajout_groupe_titre . "</h1>";

            echo "<form method='POST' action='include/groupesusers/Gestion_Ajout.php?&id_menu=" . $__commun_id_menu . "' id='formAjoutGroupe' name='formAjoutGroupe'>\n";
            echo "<input id='formAjoutGroupeFlag' name='formAjoutGroupeFlag' type='hidden' value='OK'/>\n";
            echo "<table>\n";
            // Nom
            echo "	<tr>\n";
            echo "		<td>" . $form_ajout_groupe_nom . "</td>\n";
            echo "		<td><input id='formAjoutGroupeNom' name='formAjoutGroupeNom' type='text'/></td>\n";
            echo "	</tr>\n";

            // Description
            echo "	<tr>\n";
            echo "		<td>" . $form_ajout_groupe_description . "</td>\n";
            echo "		<td><input id='formAjoutGroupeDescription' name='formAjoutGroupeDescription' type='text'/></td>\n";
            echo "	</tr>\n";

            // Parent (ceux qui n'ont pas encore d'enfant)
            $sql1 = "SELECT DISTINCT id, nom
               FROM groupes
               WHERE NOT EXISTS(
               SELECT id_groupe_parent
               FROM associations_groupes
               WHERE id_groupe_parent=id)
               ORDER by nom";

            $result1 = $ressourceBDD_appli->query($sql1);

            echo "	<tr>\n";
            echo "		<td>" . $form_ajout_groupe_parent . "</td>\n";
            //echo "		<td><input type='checkbox' id='formAjoutGroupeParent_".mysql_result($result1,0,0)."' name='formAjoutGroupeParent_".mysql_result($result1,0,0)."' value='".mysql_result($result1,0,0)."'/>".mysql_result($result1,0,1)."</td>\n";
            //echo "		<td><input type='checkbox' id='formAjoutGroupeParent_".$result1->fetch(PDO::FETCH_COLUMN,0)."' name='formAjoutGroupeParent_".$result1->fetch(PDO::FETCH_COLUMN,0)."' value='".$result1->fetch(PDO::FETCH_COLUMN,0)."'/>".$result1->fetch(PDO::FETCH_COLUMN,1)."</td>\n";
            //echo "		<td><input type='checkbox' id='formAjoutGroupeParent_".$result1->fetch(PDO::FETCH_COLUMN,0)."' name='formAjoutGroupeParent' value='".$result1->fetch(PDO::FETCH_COLUMN,0)."'/>".$result1->fetch(PDO::FETCH_COLUMN,1)."</td>\n";       
            echo "	</tr>\n";


            while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                echo "	<tr>\n";
                echo "		<td></td>\n";
                echo "		<td>\n";
                //echo "			<input type='checkbox' id='formAjoutGroupeParent_".$row1['id']."' name='formAjoutGroupeParent_".$row1['id']."' value='".$row1['id']."'/>".$row1['nom']."\n";
                echo "			<input type='checkbox' id='formAjoutGroupeParent" . $row1['id'] . "' name='formAjoutGroupeParent[]' value='" . $row1['id'] . "'/>" . $row1['nom'] . "\n";
                echo "		</td>\n";
                echo "	</tr>\n";
            }

            // Bouton
            echo "	<tr>\n";
            echo "		<td></td>\n";
            echo "		<td><input onclick='verifAjoutGroup();' type='button' value='" . $form_ajout_groupe_bouton . "'/></td>\n";
            echo "	</tr>\n";

            echo "</table>\n";

            echo "</form>\n";
        }


// AJOUT DU GROUPE EN MEMOIRE
        if (isset($_POST['formAjoutGroupeFlag']) && $_POST['formAjoutGroupeNom'] != null && $_POST['formAjoutGroupeDescription'] != null) {

            $nom_groupe = $_POST['formAjoutGroupeNom'];
            $description_groupe = $_POST['formAjoutGroupeDescription'];
            $req = "insert into groupes (nom, description) values ('$nom_groupe','$description_groupe')";
            $ressourceBDD_appli->query($req);

            if (isset($_POST['formAjoutGroupeParent']) && $_POST['formAjoutGroupeParent'] != null) {
                foreach ($_POST['formAjoutGroupeParent'] as $id_parent) {
                    $req_id_groupe_nouvellement_ajoute = "select id from groupes where nom ='$nom_groupe'";
                    $result = $ressourceBDD_appli->query($req_id_groupe_nouvellement_ajoute);
                    $id_groupe_nouvellement_ajoute = $result->fetch(PDO::FETCH_COLUMN, 0);
                    $req_ajout_parent = "insert into associations_groupes (id_groupe_parent, id_groupe) values ($id_parent, $id_groupe_nouvellement_ajoute)";

                    $ressourceBDD_appli->query($req_ajout_parent);
                }
            }
            header("Location: /portailadmin/id_menu=$__commun_id_menu");
        }
        ?>
    </body>

</html>