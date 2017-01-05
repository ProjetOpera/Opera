<div>
    <script language='javascript' type='text/javascript' src='javascript/ajaxAssocApp.js'></script>


    <?php
    //////////////
    // libelles //
    //////////////
    $msg_selection_groupe = "Selectionnez les groupes autorisés à accéder à l'application : ";
    $niveau = "Niveau d'accès";
    $alert_js_modif_ok = "Enregistrement effectué";

    // header tab
    //$header_colonne_groupe_app = "Application";
    $header_colonne_groupe_nom = "Groupe";
    $header_colonne_groupe_description = "Description";

    ///////////////
    // fonctions //
    ///////////////

    echo "<div id='association_app'>\n";


    //////////////////////
    // Affichage Select //
    //////////////////////

    $sql3 = "SELECT id,nom_appli FROM applications ORDER BY (nom_appli)";
    $req3 = $ressourceBDD_appli->query($sql3);

    if (!isset($_GET['choix'])) {
        ?>

        Sélectionnez une application  : 
        <form>
            <select onChange="location = this.options[this.selectedIndex].value">
                <option></option>
                <?php
                while ($row3 = $req3->fetch(PDO::FETCH_ASSOC)) {

                    $nom_appli = $row3['nom_appli'];
                    $id_appli = $row3['id'];
                    $selected = null;

                    if (isset($_GET['application']) && $_GET['application'] == $id_appli)
                        $selected = "selected";
                    else
                        $selected = "";
                    echo "<option value='/portailadmin/id_menu=$__commun_id_menu&application=$id_appli' $selected >$nom_appli</option><br/>";
                }
                ?>
            </select>
        </form>
        <br/>

        <?php
        if (isset($_GET['application'])) {
            $id_appli = $_GET['application'];



            $application = $_GET['application'];
            echo "$msg_selection_groupe <br/>";

            ///////////////////////
            // Affichage tableau //
            ///////////////////////
            

            
            $indent = "";
            $tiret = "";

            echo"<form action ='/portailadmin/id_menu=$__commun_id_menu&application=$application&choix=1' method='post'>";

            echo "<table id='tab_association_app' class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
            echo "  <tr class='table_line'>\n";
            echo "	<td></td>\n";
            echo "	<td>" . $header_colonne_groupe_nom . "</td>\n";
            echo "      <td>" . $header_colonne_groupe_description . "</td>\n";
            echo "      <td>" . $niveau . "</td> \n";
            echo "	<td></td>";
            echo "  </tr>\n";

            //Récupérations des levels
            $req_level_access = "select id, level from level_access";
            $result_req_level = $ressourceBDD_appli->query($req_level_access);
            $levels = array();
            while ($row = $result_req_level->fetch(PDO::FETCH_ASSOC)) {
                $levels[] = $row;
            }

            $sql1 = "select id, nom, description from groupes";
            $result1 = $ressourceBDD_appli->query($sql1);
            
            while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                
                $req_group_appli = "select id_groupes 
                                    from group_has_level_acces 
                                    where id_applications =$id_appli 
                                    and id_groupes=" . $row1['id'];

                $result_req_group_appli = $ressourceBDD_appli->query($req_group_appli);
                
                if ($result_req_group_appli->rowCount() > 0) $checked = "checked";
                else $checked = "";
                

                echo " <tr class='line0'>\n";
                echo "      <td align><input id='groupe_" . $row1['id'] . "' name='groupe[]' value='" . $row1['id'] . "' type='checkbox' $checked/></td>\n";
                echo "      <td>" . $row1['nom'] . "</td>\n";
                echo "      <td>" . $row1['description'] . "</td>\n";
                echo "      <td>  <select id='" . $row1['nom'] . "' name='levels[]'> ";
                echo "                  <option></option>";
                
                //Affichage des levels
                for ($index = 0; $index < count($levels); $index++) {
                    $req_level = " select id_level_access 
                                   from group_has_level_acces 
                                   where id_groupes=" . $row1['id'] . " 
                                   and id_applications=$id_appli 
                                   and id_level_access=" . $levels[$index]['id'];
                    $result_level = $ressourceBDD_appli->query($req_level);
                                        
                    if ($result_level->rowCount() > 0) $selected = "selected=selected";
                    else $selected = "";
                    
                echo "                  <option value='level=" . $levels[$index]['id'] . "&groupe=" . $row1['id'] . "' $selected>" . $levels[$index]['level'] . "</option>";
                };
                
                echo "             </select></td>";
                echo "      <td><a class='search various1' href='include/groupesusers/association/Association_liste_users.php?id_menu=$__commun_id_menu&id=".$row1['id']."'></a></td>";
                echo " </tr>\n";
            }

            echo "</table>\n";
            echo "<br/>";
            echo "<input type='submit' id='Enregistrer' value='Enregistrer'>";
            echo "</form>";

            echo "</div>\n";
        }
    } else if (isset($_GET['choix'])) {

        $application = $_GET['application'];

        //suppression du groupe dans la table d'association
        $req_supp = "delete from group_has_level_acces where id_applications=$application";
        $ressourceBDD_appli->query($req_supp);
        $req_supp_autorisation = "delete from autorisations where id_applications=$application ";
        $ressourceBDD_appli->query($req_supp_autorisation);


        foreach ($_POST['levels'] as $key => $post) {

            if($_POST['levels'])
            
            $token = explode('&', $post);
            $level = $token[0];
            $groupe = $token[1];
            $token_level = explode('=', $level);
            $token_groupe = explode('=', $groupe);

            $level = $token_level[1];
            $groupe = $token_groupe[1];

            //if (isset($_POST['groupe']) && $_post['groupe']!="off")
            foreach ($_POST['groupe'] as $key => $post_group) {
                if ($post_group == null) {
                    
                } else {

                    //insertion de la nouvelle entrée
                    $req_assoc_groupe_level = "insert into group_has_level_acces (id_groupes, id_level_access, id_applications) values ('$groupe', '$level', '$application')";
                    $ressourceBDD_appli->query($req_assoc_groupe_level);
                }
            }
        }


        header("location: /portailadmin/id_menu=$__commun_id_menu&application=$application");
    }
    ?>
</div>