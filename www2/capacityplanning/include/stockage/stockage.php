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
<style type="text/css">
	.date_jour {
	  	text-align: right;
	  	font-size: 16px;
	  	font-weight: bold;
	}

	.tableau_meteo {
		width: 25%;
		margin-left: 37.5%;
		background-color: #66A3C7;
	}

	.tableau_meteo td {
	  	font-size: 16px;
	 	font-weight: bold;
	}

	.tableau_meteo td {
		text-align: center;
		color: white;
	}
</style>

<div class="date_jour">
	<?=date("d/m/Y")?>
</div>

<center>
	<select name="menu_deroulant">
		<option>SI
		<option>Data Center
		<option>Baie/IPSTOR
	</select>
</center></br></br>

<table class="tableau_meteo">
  	<tr>
		<th></th><th></th>
	</tr>
  	<tr>
  		<td>Virtualisation</td><td><img src="images/nuageux.png"></td>
  	</tr>
  	<tr>
		<td>Stockage</td><td><img src="images/pluvieux.png"></td>
	</tr>
  	<tr>
		<td>Sauvegarde des VMs</td><td><img src="images/soleil.png"></td>
	</tr>
  	<tr>
		<td>Sauvegarde</td><td><img src="images/nuageux.png"></td>
	</tr>
</table>