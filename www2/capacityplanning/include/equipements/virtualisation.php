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
		width: 20%;
		margin-left: 35%;
		background-color: #66A3C7;
	}

	.tableau_meteo_middle td {
	  	font-size: 16px;
	 	font-weight: bold;
		text-align: center;
		color: white;
	}
	
	.tableau_meteo_graph {
		width: 20%;
		margin-left: 1%;
		background-color: #66A3C7;
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
	<?php echo date("d/m/Y");?>
</div>

<script type="text/javascript">
	function redirection()
	{
		window.location.href = window.location.href + '?type=' + document.getElementById("menu_deroulant").value + '&target=' + document.getElementById("menu_deroulant").value;
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

<?php
	require_once 'calculsMeteoVirtu.php';
?>

<?php
	if ($type == "SI") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>Vue globale Virtualisation</td>
	  	</tr>
	  	<tr>
			<td style="text-align: left; padding-left: 10px;"><a href="?type=data_center&target=data_center" target="_self">Virtualisation</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoVirtu ?></td>
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1</td><td style="color: black; font-size: 20px;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1" target="_self">Virtualisation</a></td><td><?php echo $meteoVirtu_Ampere_N2 ?></td>
			<td><a href="?type=data_center&target=SNP2" target="_self">Virtualisation</a></td><td><?php echo $meteoVirtu_Franklin_N2 ?></td>
		</tr>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Virtualisation</td>
	  	</tr>
		
		<?php
			foreach ($SNP1_Clusters as $Cluster) {
		?>
		
	  	<tr>
	  		<td style="text-align: left; padding-left: 10px;"><a href="?type=data_center&target=SNP1_Virtu<?php echo $Cluster;?>" target="_self"><?php echo $Cluster;?></a></td><td style="text-align: right; padding-right: 10px;"><?php echo ${'meteoVirtu_AMPERE_'.$Cluster}; ?></td>
	  	</tr>
		
		<?php
			}
		?>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP2") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Virtualisation</td>
	  	</tr>
		
		<?php
			foreach ($SNP2_Clusters as $Cluster) {
		?>
		
	  	<tr>
	  		<td style="text-align: left; padding-left: 10px;"><a href="?type=data_center&target=SNP2_Virtu<?php echo $Cluster;?>" target="_self"><?php echo $Cluster;?></a></td><td style="text-align: right; padding-right: 10px;"><?php echo ${'meteoVirtu_FRANKLIN_'.$Cluster}; ?></td>
	  	</tr>

		<?php
			}
		?>
		
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>

<?php

	foreach ($SNP1_Clusters as $Cluster) {
		if ($type == "data_center" && $target == "SNP1_Virtu" . $Cluster) {
		$environnement = "Virtu";
		$site = "AMPERE";
		$type = "CPU";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='CPU utilisé (%)' AND Site='AMPERE'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo_graph">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Virtualisation</td>
	  	</tr>
		
		<?php
			foreach ($SNP1_Clusters as $Cluster) {
		?>
		
	  	<tr>
	  		<td style="text-align: left; padding-left: 10px;"><a href="?type=data_center&target=SNP1_Virtu<?php echo $Cluster;?>" target="_self"><?php echo $Cluster;?></a></td><td style="text-align: right; padding-right: 10px;"><?php echo ${'meteoVirtu_AMPERE_'.$Cluster}; ?></td>
	  	</tr>
		
		<?php
			}
		?>
	</table>
	</br>
	<a style="position:relative;margin-top:25px;left:10px;" href="javascript:history.back()" target="_self">Retour</a>
	</br>
<?php
	include 'amchart_virtualisation.php';
	}
?>
<?php	
	}
?>