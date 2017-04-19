<html>
<head>
<script type="text/javascript" src="./javascript/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./javascript/modify_records.js"></script>
</head>
<body>
<div id="wrapper">

<?php	
	
	$sql_recup_app="SELECT id, Module_concerne, Label, Alerte, Seuil FROM capacityplanning.parametres;";

	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	echo "<br/>\n";
	echo "<br/>\n";
	
	$contenu_tab_app = "";
	$nb_ligne=0;
	
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_module=$row_recup_app['Module_concerne'];
		$recup_label=  $row_recup_app['Label'];
		$recup_alerte=$row_recup_app['Alerte'];
		$recup_seuil=$row_recup_app['Seuil'];
		
		$contenu_tab_app .= "<tr id='row" . $row_recup_app['id'] . "' class='line" . (($nb_ligne+1)%2) . "'>\n";
			$contenu_tab_app .= "<td id=module_val". $row_recup_app['id'] . ">".$recup_module."</td>\n";
			$contenu_tab_app .= "<td id=label_val" . $row_recup_app['id'] . ">".$recup_label."</td>\n";
			$contenu_tab_app .= "<td id=alerte_val" . $row_recup_app['id'] . ">".$recup_alerte."</td>\n";
			$contenu_tab_app .= "<td id=seuil_val" . $row_recup_app['id'] . ">".$recup_seuil."</td>\n";
			$contenu_tab_app .= "<td><input type='button' id='edit_button".$row_recup_app['id']."' value='Editer' class='edit' onclick='edit_row(".$row_recup_app['id'].")'>
										<input type='button' style='display:none' id='save_button".$row_recup_app['id']."' value='Sauvegarder' class='save' onclick='save_row(".$row_recup_app['id'].")'>
										<input type='button' value='Supprimer' class='delete' onclick='delete_row(".$row_recup_app['id'].")'></td>";
		$contenu_tab_app .= "</tr>\n";
		$nb_ligne++;
	}
	
	$contenu_tab_app .= "<tr id='new_row'>
 <td><select name='module' id='new_module'>";

$sql = $ressourceBDD_appli->query("SELECT Environnement, MIN(id_reference) FROM capacityplanning.vueglobale GROUP BY Environnement");
while ($row = $sql->fetch(PDO::FETCH_ASSOC))
{
	$contenu_tab_app .= "<option value='" . $row['Environnement'] . "'>" . $row['Environnement'] . "</option>";
}

$contenu_tab_app .= "</select></td>
 <td><input type='text' id='new_label'></td>
 <td><input type='text' id='new_alerte'></td>
 <td><input type='text' id='new_seuil'></td>
 <td><input type='button' value='Insérer ligne' onclick='insert_row();'></td>
</tr>";
	
	if($nb_ligne!=0)
	{	
		echo "<table class='display_list2' id='user_table' cellpadding=0 cellspacing=0 border=0>\n";
		
		echo "<tr class='table_line'>\n";
		
			echo "<td>Module</td>\n";
			echo "<td>Equipement</td>\n";
			echo "<td>Alerte</td>\n";
			echo "<td>Seuil</td>\n";
			echo "<td>Actions</td>\n";
			
		echo "</tr>\n";
		
		echo $contenu_tab_app;
		
		echo "</table>\n";
	}
	
?>

</div>
</body>
</html>