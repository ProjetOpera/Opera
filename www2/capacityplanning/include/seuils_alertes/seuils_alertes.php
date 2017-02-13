<?php
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	/*
	$sql_recup_app="SELECT name, role, localisation FROM inv_san.baie WHERE date_releve = (SELECT MAX(date_releve) FROM inv_san.baie) ORDER BY name;";

	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	echo "<br/>\n";
	echo "<br/>\n";
	
	$contenu_tab_app = "";
	$nb_ligne=0;
	
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_name=$row_recup_app['name'];
		$recup_role=  $row_recup_app['role'];
		$recup_localisation=$row_recup_app['localisation'];
		
		$contenu_tab_app .= "<tr class='line".(($nb_ligne+1)%2)."'>\n";
			$contenu_tab_app .= "<td>".$recup_name."</td>\n";
			$contenu_tab_app .= "<td>".$recup_role."</td>\n";
			$contenu_tab_app .= "<td>".$recup_localisation."</td>\n";			
		$contenu_tab_app .= "</tr>\n";
		$nb_ligne++;
	}
	if($nb_ligne!=0)
	{	
		echo "<table class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
		
		echo "<tr class='table_line'>\n";
		
			echo "<td>Nom</td>\n";
			echo "<td>Role</td>\n";
			echo "<td>Localisation</td>\n";
			
		echo "</tr>\n";
		
		echo $contenu_tab_app;	
		
		echo "</table>\n";
	}
	*/
?>

<table class='display_list2' cellpadding=0 cellspacing=0 border=0>
	<tr class='table_line'>
		<td>Module</td>
		<td>Equipement</td>
		<td>Seuil</td>
		<td>Alerte</td>
		<td style="text-align: center;" colspan=2>Actions</td>
	</tr>
	<tr class='line1'>
		<td>Stockage</td>
		<td>AXIOM600</td>
		<td>4 To</td>
		<td>3 To</td>
		<td style="text-align: center;"><img src='../commun/images/save.png'/></td>
		<td style="text-align: center;"><a class='various1 delete' href=''></a></td>
	</tr>
</table>