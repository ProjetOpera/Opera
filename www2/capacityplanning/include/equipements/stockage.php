<?php
	require_once("connect.php");
?>
<style type="text/css">
	.date_jour {
	  	text-align: right;
	  	font-size: 16px;
	  	font-weight: bold;
	  	margin-bottom: 2%;
	}
	
	.tableau_meteo_middle {
		width: 40%;
		margin-left: 30%;
		background-color: #66A3C7;
	}

	.tableau_meteo_middle td {
	  	font-size: 16px;
	 	font-weight: bold;
		text-align: center;
		color: white;
	}
	
	.tableau_meteo_graph {
		width: 39%;
		margin-left: 1%;
		background-color: #66A3C7;
		float: left;
	}

	.tableau_meteo_graph td {
	  	font-size: 16px;
	 	font-weight: bold;
		text-align: center;
		color: white;
	}

	.tableau_meteo_graph a {
		color: #FFFFFF;
	}

	.tableau_meteo_middle a {
		color: #FFFFFF;
	}
</style>

<div class="date_jour">
	<? echo date("d/m/Y");?>
</div>

<script type="text/javascript">
	function redirection()
	{
		window.location.href = window.location.href + '&type=' + document.getElementById("menu_deroulant").value + '&target=' + document.getElementById("menu_deroulant").value;
	}
</script>

<?php
	$type = "SI";

	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	}
	
	if (isset($_GET['target'])) {
		$target = $_GET['target'];
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
	require_once 'calculsMeteoStockage.php';
?>

<?php
/*
	if ($type == "SI") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>Vue globale</td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/stockage.php?type=data_center&target=data_center" target="_self">Stockage</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	
<?php
	}*/
	
	$sql_recup_app = "SELECT name FROM inv_san.baie WHERE date_releve = (SELECT MAX(date_releve) FROM inv_san.baie) ORDER BY name;";

	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	$contenu_tab_app = "";
	$nb_ligne = 0;

	if ($type == "SI") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>Vue globale</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=data_center" target="_self">Stockage</a></td><td><?php echo $meteoStockage ?></td>
			<!--<td><a href="?type=data_center&target=SNP2" target="_self">Stockage</a></td><td><?php //echo $meteoStockage_FRANKLIN ?></td>-->
		</tr>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
	if ($type == "data_center" && $target == "data_center") {
?>
		<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Ampere</td><td style="color: black; font-size: 20px;" colspan=2>SNP2 - Franklin</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1" target="_self">Stockage</a></td><td><?php echo $meteoStockageStockage_AMPERE ?></td>
			<td><a href="?type=data_center&target=SNP2" target="_self">Stockage</a></td><td><?php echo $meteoStockageStockage_FRANKLIN ?></td>
		</tr>
		
		</br></br>
		
		<tr>
			<td><a href="?type=data_center&target=SNP1" target="_self">IPSTOR</a></td><td><?php echo $meteoStockageIPSTOR_AMPERE ?></td>
			<td><a href="?type=data_center&target=SNP2" target="_self">IPSTOR</a></td><td><?php echo $meteoStockageIPSTOR_FRANKLIN ?></td>
		</tr>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php	} ?>

<?php
	if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Baies</td>
	  	</tr>
<?php
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_name = $row_recup_app['name'];
		
		$contenu_tab_app .= "<tr>";
			if (substr($recup_name, -3) == "AMP")
				$contenu_tab_app .= "<td><a href='?type=data_center&target=SNP1_" . $recup_name . "' target='_self'>" . $recup_name . "</td><td>" . $meteo . "</td>";
		$contenu_tab_app .= "</tr>";
		$nb_ligne++;
	}
?>
		
		<!--<tr>
	  		<td style="color: black;" colspan=2>SNP1 - IPSTOR</td>
	  	</tr>-->
		
<?php
	if($nb_ligne != 0)
	{	
		echo "<table class='tableau_meteo_middle'";
		
		echo $contenu_tab_app;
		
		echo "</table>";
	}
?>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
	$nb_ligne = 0;
?>

<?php
	if ($type == "data_center" && $target == "SNP2") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Baies</td>
	  	</tr>
	</table>
<?php
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_name = $row_recup_app['name'];
		
		$contenu_tab_app .= "<tr>";
		if (substr($recup_name, -3) == "FKL")
				$contenu_tab_app .= "<td>"."<a href='?type=data_center&target=SNP2_" . $recup_name . "' target='_self'>" . $recup_name . "</td><td>" . $meteo . "</td>";
		$contenu_tab_app .= "</tr>";
		$nb_ligne++;
	}

	if($nb_ligne != 0)
	{	
		echo "<table class='tableau_meteo_middle'";
		
		echo $contenu_tab_app;
		
		echo "</table>";
	}
?>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>