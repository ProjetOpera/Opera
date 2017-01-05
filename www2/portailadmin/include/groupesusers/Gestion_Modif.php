<?php
session_start();
require_once("../../../portailv2/functions/functions.php");
$ressourceBDD_appli = connexion_externe('../../../portailv2/');


//////////////
// libelles //
//////////////

$modif_groupe_titre = "Modif groupe";

// formulaire
$form_modif_groupe_nom = "Nom";
$form_modif_groupe_description = "Description";
$form_modif_groupe_parent = "Parent";
$form_modif_groupe_parent_aucun = "aucun";
$form_modif_groupe_bouton = "Modifier";

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

            function verifModifGroup(){
                var nom = document.getElementById('formModifGroupeNom').value;
                var description = document.getElementById('formModifGroupeDescription').value;
		
                if(nom=="")
                    alert ('<?php echo $alert_js_nom; ?>');
                else if(description=="")
                    alert ('<?php echo $alert_js_description; ?>');
                else 
                    document.getElementById('formModifGroupe').submit();
            }

        </script>

        <?php
        
        if (!isset($_POST['formModifGroupeFlag']) || $_POST['formModifGroupeFlag'] !='OK') {            
        
        $id = mysql_escape_string($_GET['id']);

        $sql = "SELECT nom,description FROM groupes WHERE id='" . $id . "'";

        foreach ($ressourceBDD_appli->query($sql) as $row) {

            echo "<h1>" . $modif_groupe_titre . "</h1>";

            echo "<form method='POST' action='include/groupesusers/Gestion_Modif.php?&id=$id&id_menu=" . $__commun_id_menu . "' id='formModifGroupe' name='formModifGroupe'>\n";
            echo "<input id='formModifGroupeFlag' name='formModifGroupeFlag' type='hidden' value='OK'/>\n";
            echo "<table>\n";
            // Nom
            echo "	<tr>\n";
            echo "		<td>" . $form_modif_groupe_nom . "</td>\n";
            echo "		<td><input id='formModifGroupeNom' name='formModifGroupeNom' type='text' value='" . $row['nom'] . "'/></td>\n";
            echo "	</tr>\n";

            // Description
            echo "	<tr>\n";
            echo "		<td>" . $form_modif_groupe_description . "</td>\n";
            echo "		<td><input id='formModifGroupeDescription' name='formModifGroupeDescription' type='text' value='" . $row['description'] . "'/></td>\n";
            echo "	</tr>\n";
        }

        // Parent (ceux qui n'ont pas encore d'enfant)
        $sql1 = "SELECT DISTINCT id, nom
               FROM groupes
               WHERE NOT EXISTS(
               SELECT id_groupe_parent
               FROM associations_groupes
               WHERE id_groupe_parent=id)
               AND id != $id
               ORDER by nom";

        $result1 = $ressourceBDD_appli->query($sql1);

        echo "	<tr>\n";
        echo "		<td>" . $form_modif_groupe_parent . "</td>\n";
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



        /*
          $sql1="SELECT id,nom FROM groupes ORDER BY upper(nom)";
          $result1=$ressourceBDD_appli->query($sql1);
          $id_parent = $result1->fetch(PDO::FETCH_COLUMN,0);
          $nom_parent = $result1->fetch(PDO::FETCH_COLUMN,1);

          echo "	<tr>\n";
          echo "		<td>".$form_modif_groupe_parent."</td>\n";
          echo "		<td><input type='checkbox' id='formAjoutGroupeParent_".$id_parent."' name='formAjoutGroupeParent_".$id_parent."' value='".$id_parent."'/>".$nom_parent."</td>\n";
          echo "	</tr>\n";


          while($row1=$result1->fetch(PDO::FETCH_ASSOC))
          {
          $sql2="SELECT  1
          FROM associations_groupes
          WHERE id_groupe_parent='".$row1['id']."'
          AND id_groupe='".$id."'";
          $result2=$ressourceBDD_appli->query($sql2);

          $checked= ($result2->rowCount()!=0) ? "checked='checked'": "";


          echo "	<tr>\n";
          echo "		<td></td>\n";
          echo "		<td>\n";
          echo "			<input ".$checked." type='checkbox' id='formAjoutGroupeParent_".$row1['id']."' name='formAjoutGroupeParent_".$row1['id']."' value='".$row1['id']."'/>".$row1['nom']."\n";
          echo "		</td>\n";
          echo "	</tr>\n";
          }
         */

        // Bouton
        echo "	<tr>\n";
        echo "		<td></td>\n";
        echo "		<td><input onclick='verifModifGroup();' type='button' value='" . $form_modif_groupe_bouton . "'/></td>\n";
        echo "	</tr>\n";

        echo "</table>\n";

        echo "</form>\n";

        }
        // MISE EN MEMOIRE DES MODIFICATIONS
        if (isset($_POST['formModifGroupeFlag']) && $_POST['formModifGroupeNom'] != null && $_POST['formModifGroupeDescription'] != null) {

            $nom_groupe = $_POST['formModifGroupeNom'];
            $description_groupe = $_POST['formModifGroupeDescription'];
            $id=$_GET['id'];
            $req = "update groupes set nom='$nom_groupe',description='$description_groupe' where id=$id";
            $ressourceBDD_appli->query($req);

            if (isset($_POST['formAjoutGroupeParent']) && $_POST['formAjoutGroupeParent'] != null) {
                foreach ($_POST['formAjoutGroupeParent'] as $id_parent) {
                    $req_suppresion_parent = "delete from associations_groupes where id_groupe =$id";
                    $req_ajout_parent = "insert into associations_groupes (id_groupe_parent, id_groupe) values ($id_parent, $id)";
                    $ressourceBDD_appli->query($req_suppresion_parent);
                    $ressourceBDD_appli->query($req_ajout_parent);
                }
            }
            header("Location: /portailadmin/id_menu=$__commun_id_menu");
        }
        ?>
    </body>

</html>