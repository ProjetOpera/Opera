<div>
    <script language='javascript' type='text/javascript' src='javascript/ajax.js'></script>

    <script type="text/javascript">
        function envoi_info_form_assoc()
        {
            document.getElementById("formulaire_association").submit();
        }

    </script>



    <div id='contenu_AssociationBiensTypes'>

        <?php
        //Si on a validé une association (bouton Association validé), faire les modif en base de données
        if (isset($_GET['association']) && isset($_POST['bouton_assoc']) && isset($_GET['id_contact'])) {
            // 1. suppression dans la table d'association associations_contacts_groupes
            $id_contact = $_GET['id_contact'];
            $req_supp = "delete from associations_contacts_groupes where id_contacts =$id_contact";
            $ressourceBDD_appli->query($req_supp);

            //2. insertion des nouvelles associations si le groupe a été sélectionné
            if (isset($_POST['groupe'])) {
                for ($index = 0; $index < count($_POST['groupe']); $index++) {
                    $id_groupe = $_POST['groupe'][$index];
                    if ($id_groupe != null) {
                        $req_ass = "insert into associations_contacts_groupes (id_contacts, id_groupes) values ($id_contact, $id_groupe)";
                        $ressourceBDD_appli->query($req_ass);
                    }
                }
            }
        } else if (isset($_GET['association']) && isset($_POST['bouton_assoc']) && !isset($_GET['id_contact'])) {
            echo "<font color='red>Veuillez sélectionner un utilisateur svp!</font>";
        }




// TABLEAU DES CONTACTS*****************************************************************************************************************************
        echo "<TABLE cellpadding='10' cellspacing='10' style='width:590px;float:left'>";
        echo "<tr>";
        echo "<td>";

        $sql_recup_contacts = "SELECT id, prenom_contact, nom_contact FROM contacts ORDER BY upper(nom_contact)";
        $result_recup_contacts = $ressourceBDD_appli->query($sql_recup_contacts);

        $flag_debut_select = true;

        echo "<select id='select_bien' name='select_bien' size='20' onChange='location = this.options[this.selectedIndex].value'>\n";
        while ($r_recup_contacts = $result_recup_contacts->fetch(PDO::FETCH_BOTH)) {

            $id_contact = $r_recup_contacts['id'];

            if (isset($_GET['id_contact']) && $_GET['id_contact'] == $id_contact) {
                $selected = "selected";
            } else {
                $selected = "";
            }

            echo "<option value='/portailadmin/id_menu=$__commun_id_menu&id_contact=$id_contact' $selected >" . htmlentities($r_recup_contacts['nom_contact']) . " " . htmlentities($r_recup_contacts['prenom_contact']) . "</option>\n";
        }
        echo "</select>\n";
        echo "</td>";
        echo "<td>";
        if (isset($_GET['id_contact']))
            $contact = "&id_contact=" . $_GET['id_contact'] . "";
        else
            $contact = "";
        echo "<form id='formulaire_association' method='POST' action='/portailadmin/id_menu=$__commun_id_menu$contact&association=1'>";
        echo "<input id='bouton_assoc' name='bouton_assoc' type='submit' value='Associer'/>";
        echo "</td>";

//***********************************************************************************************************************************************


        $sql_recup_groupes = "SELECT id, nom from groupes";

        $result_recup_groupes = $ressourceBDD_appli->query($sql_recup_groupes);

        $tr_line = 0;
        echo "<td>";
        echo "<div id='tableau_groupes'>";


        echo "<table style='width: 300px' class='display_list2' cellpadding='0' cellspacing='0' border='0'>\n";
        echo "<tr class='table_line'>\n";
        echo "<td colspan='2'>Groupes</td>\n";
        echo "</tr>\n";


        while ($r_recup_groupes = $result_recup_groupes->fetch(PDO::FETCH_BOTH)) {
            echo "<tr class='line" . (($tr_line + 1) % 2) . "'>\n";
            echo "<td>";

            if (isset($_GET['id_contact'])) {
                $id_contact = $_GET['id_contact'];
                $req_groupe = "select * from associations_contacts_groupes where id_contacts =$id_contact and id_groupes=" . $r_recup_groupes['id'] . "";
                $result_req_groupe = $ressourceBDD_appli->query($req_groupe);
                if ($result_req_groupe->rowCount() > 0) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
            } else {
                $checked = "";
            }

            echo "<input id='groupe_" . $r_recup_groupes['id'] . "' name='groupe[]' value='" . $r_recup_groupes['id'] . "' type='checkbox' $checked/></td>\n";
            echo "<td>" . $r_recup_groupes['nom'] . "</td>\n";
            echo "</tr>\n";
            $tr_line++;
        }
        echo "</table>\n";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
        ?>


    </div>
