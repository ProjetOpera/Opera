<div>
    <script language='javascript' type='text/javascript' src='javascript/ajaxAssocApp.js'></script>

    <script type="text/javascript">
        function envoi_info_form_assoc()
        {
            document.getElementById("formulaire_association").submit();
        }

		function listeUsers(id)
		{
			var xhr_object = null; 
		 
			if(window.XMLHttpRequest) // Firefox 
				xhr_object = new XMLHttpRequest(); 
			else if(window.ActiveXObject) // Internet Explorer 
				xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			else { // XMLHttpRequest non supporté par le navigateur 
				alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
			 
			xhr_object.open("POST", "include/groupesusers/association/listeUserGroupe.php", true); 
			
			xhr_object.onreadystatechange = function() { 
				if(xhr_object.readyState == 4) {
					document.getElementById("listeUsers").innerHTML=xhr_object.responseText;
				}
			} 
			
							
			xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			var data = "id="+id; 
			xhr_object.send(data);
		}
	</script>



    <div id='contenu_AssociationBiensTypes'>

        <?php
        //Si on a validé une association (bouton Association validé), faire les modif en base de données
        if (isset($_GET['association']) && isset($_POST['bouton_assoc']) && isset($_POST['select_bien'])) {
            // 1. suppression dans la table d'association associations_contacts_groupes
            $id_contact = $_POST['select_bien'];
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
            //header("Location: /portailadmin/id_menu=".$_POST['menu']."&");
            
        } else if (isset($_GET['association']) && isset($_POST['bouton_assoc']) && !isset($_GET['id_contact'])) {
            echo "<div style='color:red'>Veuillez sélectionner un utilisateur svp!</div>";
        }




// TABLEAU DES CONTACTS*****************************************************************************************************************************
        echo "<TABLE cellpadding='10' cellspacing='10' style='width:590px;float:left'>";
        echo "<tr>";
        echo "	<td>";
        
        echo "<form id='formulaire_association' method='POST' action='/portailadmin/id_menu=$__commun_id_menu&association=1'>";
        echo "<input type='hidden' name='menu' value='$__commun_id_menu' />";

        $sql_recup_contacts = "SELECT id, prenom_contact, nom_contact FROM contacts ORDER BY upper(nom_contact)";
        $result_recup_contacts = $ressourceBDD_appli->query($sql_recup_contacts);

        $flag_debut_select = true;

        echo "	<select id='select_bien' name='select_bien' size='45' onChange='javascript:ajaxAssocApp(this.value)'>\n";
        while ($r_recup_contacts = $result_recup_contacts->fetch(PDO::FETCH_BOTH)) {
            $id_contact = $r_recup_contacts['id'];
            $selected = (isset($_GET['id_contact']) && $_GET['id_contact'] == $id_contact) ? "selected" : "";
            echo "<option value='$id_contact' $selected >" . htmlentities($r_recup_contacts['nom_contact'], ENT_QUOTES, "UTF-8") . " " . htmlentities($r_recup_contacts['prenom_contact'], ENT_QUOTES, "UTF-8") . "</option>\n";
        }
        echo "</select>\n";
        
        echo "	</td>";
        echo "	<td>";
        if (isset($_GET['id_contact']))
            $contact = "&id_contact=" . $_GET['id_contact'] . "";
        else
            $contact = "";
        
        
  			//echo "<input id='bouton_assoc' name='bouton_assoc' type='submit' value='Associer'/>";
        echo "	</td>";

// TABLEAU des GROUPES ***********************************************************************************************************************************************
				echo "	<td>";
				echo "		<div id='tableau_des_groupes'></div>";
				
				$sql_recup_groupes = "SELECT id, nom from groupes order by nom asc";
				$result_recup_groupes = $ressourceBDD_appli->query($sql_recup_groupes);
				
				$tr_line = 0;
				
				echo "<table style='width: 300px' class='display_list2' cellpadding='0' cellspacing='0' border='0'>\n";
				echo "<tr class='table_line'>\n";
				echo "	<td colspan='3'>Groupes</td>\n";
				echo "</tr>";
				
				while ($r_recup_groupes = $result_recup_groupes->fetch(PDO::FETCH_BOTH)) {
					echo "<tr class='line" . (($tr_line + 1) % 2) . "'>\n";
					echo "	<td>\n";
				
					if (isset($_POST['id'])) {
					  $id_contact = $_POST['id'];
					  $req_groupe = "select * from associations_contacts_groupes where id_contacts =$id_contact and id_groupes=" . $r_recup_groupes['id'] . "";
					  $result_req_groupe = $ressourceBDD_appli->query($req_groupe);
					  $checked = ($result_req_groupe->rowCount() > 0) ? "checked" : "";
					} 
					else $checked = "";
					
					echo "	
						<input 
							id='groupe_" . $r_recup_groupes['id'] . "' 
							name='groupe[]' 
							value='" . $r_recup_groupes['id'] . "' 
							type='checkbox' 
							$checked 
							onclick='ajaxAssocAppBdd(document.getElementById(\"select_bien\").value,this.checked,this.value)' />";
					echo "</td>\n";
					echo "	<td>" . $r_recup_groupes['nom'] . "</td>\n";
					echo "	<td><a href='javascript:listeUsers(".$r_recup_groupes['id'].")'>info groupe</a></td>\n";
					echo "</tr>\n";
					$tr_line++;
				}				
				echo "	</table>";
				
				echo "	</td>";
				echo "<td>";
				echo "<div id='listeUsers'></div>";
				echo "</td>";
				echo "	</tr>";
				echo "</form>";
				echo "</table>";
        
?>
</div>
