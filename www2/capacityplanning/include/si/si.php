<?php
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	
	/*$sql_recup_app="SELECT name, role, localisation FROM inv_san.baie WHERE date_releve = (SELECT MAX(date_releve) FROM inv_san.baie) ORDER BY name;";

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
	}*/
	
?>
<style type="text/css">
	.date_jour {
	  	text-align: right;
	  	font-size: 16px;
	  	font-weight: bold;
	}

	.tableau_meteo {
		width: 50%;
		margin-left: 25%;
		background-color: #66A3C7;
	}

	.tableau_meteo td {
	  	font-size: 16px;
	 	font-weight: bold;
		text-align: center;
		color: white;
	}
</style>

<div class="date_jour">
	<?=date("d/m/Y")?>
</div>

<script type="text/javascript">
	function redirection()
	{
		window.location.href = window.location.href + '&type=' + document.getElementById("menu_deroulant").value + '&target=' + document.getElementById("menu_deroulant").value;
	}
</script>

<?php
	$type = "SI";
	//$target = "SNP1";

	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	}
	
	if (isset($_GET['target'])) {
		$target = $_GET['target'];
	}
	
	if ($target == "SNP1") {
		$select_SNP1 = "selected";
	}

	if ($target == "SNP2") {
		$select_SNP2 = "selected";
	}

	if ($type == "SI") {
		$select_SI = "selected";
	}

	if ($type == "data_center") {
		$select_data_center = "selected";
	}

	if ($type == "baie_ipstor") {
		$select_baie_ipstor = "selected";
	}
?>

<!--<center>
	<select name="menu_deroulant" id="menu_deroulant" onChange="redirection();">
		<option value="SI" <?//=$select_SI?>>SI</option>
		<option value="data_center" <?//=$select_data_center?>>Data Center</option>
		<option value="baie_ipstor" <?//=$select_baie_ipstor?>>Baie/IPSTOR</option>
	</select>
</center></br></br>-->

<?php
	if ($type == "SI") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td>Virtualisation</td><td><img src="images/nuageux.png">
	  	</tr>
	  	<tr>
			<td><a href="http://localhost/capacityplanning/id_menu=235&type=data_center&target=SNP1" target="_self">Stockage</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	  	<tr>
			<td>Sauvegarde des VMs</td><td><img src="images/soleil.png"></td>
		</tr>
	  	<tr>
			<td>Sauvegarde</td><td><img src="images/nuageux.png"></td>
		</tr>
	</table>	
	
<?php
	}

	if ($type == "data_center" && $target == "data_center") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td>NUTAMPPRD</td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td>ORAAMPPRD</td><td><img src="images/pluvieux.png"></td>
	  	<tr>
			<td>VSPAMPRD</td><td><img src="images/nuageux.png"></td>
		</tr>
	  	<tr>
			<td>VSPPRDSII</td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
<?php
	}
?>