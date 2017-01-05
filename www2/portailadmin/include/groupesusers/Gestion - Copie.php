<?php

	//////////////
	// libelles //
	//////////////
	
	$ajout_groupe_text="Ajouter un groupe...";
        $ajout_level_text="Ajouter un niveau d'accès...";
        $ajout_utilisateur_text="Ajouter un utilisateur...";
	
	// header tab
        $header_colonne_suppression = "Supprimer";
        //--groupes--
	$header_colonne_groupe_nom = "Nom";
	$header_colonne_groupe_description = "Description";
        //--levels--
        $header_colonne_niveau = "Niveau";
        $header_colonne_niveau_description ="Description";
        //--utilisateurs--
        $header_colonne_login="Login";
        $header_colonne_nom="Nom";
        $header_colonne_prenom="Prénom";
	
	///////////////
	// fonctions //
	///////////////
	
	function creationTabGroupe($id_parent,$indent)
	{
		global $ressourceBDD_appli, $__commun_id_menu;
		$sql2="SELECT g.id,g.nom,g.description 
				FROM groupes g, associations_groupes ag
				WHERE ag.id_groupe_parent='".$id_parent."' 
					AND ag.id_groupe=g.id
				ORDER BY upper(nom)";
	
		$result2=$ressourceBDD_appli->query($sql2);
		
		$indent.="&nbsp&nbsp";
		while($row2=$result2->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr class='line1'>\n";

			echo "	<td>".$indent."&nbsp;|--&nbsp;&nbsp;<a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=".$row2['id']."&id_menu=".$__commun_id_menu."'>".$row2['nom']."</a></td>\n";
			echo "	<td>".  htmlspecialchars($row2['description'], ENT_QUOTES, "UTF-8")."</td>\n";
			echo "	<td><a href='include/groupesusers/Gestion_Suppr.php?id=".$row2['id']."&id_menu=".$__commun_id_menu."' class='delete various1' /></td>\n";
			
			echo "</tr>\n";
			creationTabGroupe($row2['id'],$indent.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		}
	}
        
//*********************************************************************************************************************************************************************************************************************************        
        
        ////////////////////////////////////////////
	// Affichage tableau niveau d'acces      //
	//////////////////////////////////////////
        
        // lien ajout d'un groupe 
        echo "<fieldset style='width:900px;float:left;margin-bottom:10px;margin-left:20px; padding:10px'> <legend>Niveau d'accès</legend>"; 
	echo "<a class='various1' href='include/groupesusers/Gestion_Ajout_level.php?id_menu=$__commun_id_menu'>+ ".$ajout_level_text."</a>\n";
	echo "<br/>\n";
	echo "<br/>\n";
        
        //tableau
        echo "
        			<table class='display_list2' cellpadding='0' cellspacing='0' border='0'><tbody>
                <tr class='table_line'>
                    <td>". $header_colonne_niveau. "</td>
                    <td>". $header_colonne_niveau_description. "</td>
                    <td>". $header_colonne_suppression. "</td>
                </tr>
                ";

        $req_niveau_acces = "select id, level, description from level_access";
        $result_level_access = $ressourceBDD_appli->query($req_niveau_acces);
        $num=1;
        while ($row = $result_level_access->fetch(PDO::FETCH_ASSOC)) {
            echo "
            	<tr class='line".($num%2)."'>
                <td>". $row['level']. "</td>
                <td>". $row['description']. "</td>
                <td><a href='include/groupesusers/Gestion_Suppr_level.php?id=".$row['id']."&id_menu=".$__commun_id_menu."' class='delete various1'/></td>
              </tr>";
              $num++;
        }
        echo "</tbody></table></fieldset>";

	////////////////////////////////////////////
	// Affichage tableau groupe d'utilisateurs//
	//////////////////////////////////////////
	
	// lien ajout d'un groupe 
        echo "<fieldset style='width:900px;float:left;margin-bottom:10px;margin-left:20px; padding:10px'> <legend>Groupes d'utilisateurs</legend>"; 
	echo "<a class='various1' href='include/groupesusers/Gestion_Ajout.php?id_menu=$__commun_id_menu'>+ ".$ajout_groupe_text."</a>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	
	
	// tableau
	echo "<table class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
	
	echo "<tr class='table_line'>\n";

	echo "	<td>".$header_colonne_groupe_nom."</td>\n";
	echo "	<td>".$header_colonne_groupe_description."</td>\n";
	echo "	<td>".$header_colonne_suppression."</td>\n";
	
	echo "</tr>\n";
	
	
	$sql1="SELECT g.id,g.nom,g.description 
			FROM groupes g
			WHERE NOT EXISTS
			(
				SELECT 1 
				FROM associations_groupes ag
				WHERE ag.id_groupe=g.id	
			)
			ORDER BY upper(g.nom)
	";
	
	
	$result1=$ressourceBDD_appli->query($sql1);
	$indent="";
	
	while($row1=$result1->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr class='line0'>\n";

		echo "	<td><a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=".$row1['id']."&id_menu=".$__commun_id_menu."'>".$row1['nom']."</a></td>\n";
		echo "	<td>".  htmlspecialchars($row1['description'], ENT_QUOTES, "UTF-8")."</td>\n";
		echo "	<td><a href='include/groupesusers/Gestion_Suppr.php?id=".$row1['id']."&id_menu=".$__commun_id_menu."' class='delete various1'/></td>\n";
		
		echo "</tr>\n";
		creationTabGroupe($row1['id'],$indent);
	}

	echo "</table>\n";
        echo "</fieldset>";
        
        
?>