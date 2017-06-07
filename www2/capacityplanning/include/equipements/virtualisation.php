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
	require_once 'calculsMeteoVirtu.php';
?>

<?php
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
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=data_center" target="_self">Virtualisation</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	
<?php
	}

	if ($type == "data_center" && $target == "data_center") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Ampere</td><td style="color: black;" colspan=2>SNP2 - Franklin</td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP1" target="_self">Virtualisation</a></td><td><img src="images/pluvieux.png"></td><td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP2" target="_self">Virtualisation</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/virtualisation.php" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP1_clus1" target="_self">NUTAMPPRD</a></td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP1_clus2" target="_self">ORAAMPPRD</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP1_clus3" target="_self">VSPAMPRD</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP1_clus4" target="_self">VSPPRDSII</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/virtualisation.php?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP2") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP2_clus1" target="_self">NUTAMPPRD</a></td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP2_clus2" target="_self">ORAAMPPRD</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP2_clus3" target="_self">VSPAMPRD</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/virtualisation.php?type=data_center&target=SNP2_clus4" target="_self">VSPPRDSII</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/virtualisation.php?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>