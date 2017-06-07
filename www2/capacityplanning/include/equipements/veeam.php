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
	<? echo date("d/m/Y")?>
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

<?php
	require_once 'calculsMeteoVEEAM.php';
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
			<td><a href="./include/equipements/veeam.php?type=data_center&target=data_center" target="_self">Sauvegarde des VMs</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	
<?php
	}*/

	if ($type == "data_center" && $target == "data_center") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Ampere</td><td style="color: black;" colspan=2>SNP2 - Franklin</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1" target="_self">Sauvegarde des VMs</a></td><td><?php echo $meteoVEEAM_AMPERE ?></td>
			<td><a href="?type=data_center&target=SNP2" target="_self">Sauvegarde des VMs</a></td><td><?php echo $meteoVEEAM_FRANKLIN ?></td>
		</tr>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>

<?php
	/*if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - VEEAM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP1_veeam1" target="_self">Serveur VEEAM 1</a></td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP1_veeam2" target="_self">Serveur VEEAM 2</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP1_veeam3" target="_self">Serveur VEEAM 3</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/veeam.php?type=data_center&target=data_center" target="_self">Retour</a>
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
	  		<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP2_veeam1" target="_self">Serveur VEEAM 1</a></td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP2_veeam2" target="_self">Serveur VEEAM 2</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP2_veeam3" target="_self">Serveur VEEAM 3</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/veeam.php?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}*/	
	
	if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Ampere ?></td>
	  	</tr>
	</table>
	<a href="?type=data_center&target=data_center" target="_self">Retour</a>
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Franklin ?></td>
	  	</tr>
	</table>
	<a href="?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>	
<?php	
	if ($type == "data_center" && $target == "SNP1_VEEAM_volume")
	{
		$environnement = "VEEAM";
		$site = "AMPERE";
		$type = "volume";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Ampere ?></td>
	  	</tr>

	</table>
	<?php
	if ($_GET['origin'] == "equipement")
	{
	?>
	<a style="position:absolute;top:600px;left:10px;" href="javascript:history.back()" target="_self">Retour</a>
	<?php } else { ?>
	<a style="position:absolute;top:600px;left:10px;" href="?type=data_center&target=SNP1" target="_self">Retour</a>
	<?php } ?>
<?php
	include 'amchart_veeam.php';
	}
	if ($type == "data_center" && $target == "SNP1_VEEAM_licences")
	{
		$environnement = "VEEAM";
		$site = "AMPERE";
		$type = "licences";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Ampere ?></td>
	  	</tr>
	</table>
	<?php
	if ($_GET['origin'] == "equipement")
	{
	?>
	<a style="position:absolute;top:600px;left:10px;" href="javascript:history.back()" target="_self">Retour</a>
	<?php } else { ?>
	<a style="position:absolute;top:600px;left:10px;" href="?type=data_center&target=SNP1" target="_self">Retour</a>
	<?php } ?>
<?php
	include 'amchart_veeam.php';
	}
	
	if ($type == "data_center" && $target == "SNP2_VEEAM_volume")
	{
		$environnement = "VEEAM";
		$site = "FRANKLIN";
		$type = "volume";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='FRANKLIN'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP2_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Franklin ?></td>
	  	</tr>

	</table>
	<?php
	if ($_GET['origin'] == "equipement")
	{
	?>
	<a style="position:absolute;top:600px;left:10px;" href="javascript:history.back()" target="_self">Retour</a>
	<?php } else { ?>
	<a style="position:absolute;top:600px;left:10px;" href="?type=data_center&target=SNP2" target="_self">Retour</a>
	<?php } ?>
<?php
	include 'amchart_veeam.php';
	}
	if ($type == "data_center" && $target == "SNP2_VEEAM_licences")
	{
		$environnement = "VEEAM";
		$site = "FRANKLIN";
		$type = "licences";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='FRANKLIN'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP2_VEEAM_volume" target="_self">Volumétrie</a></td><td><?php echo $meteoVEEAMVolume_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_VEEAM_licences" target="_self">Nombre de licences</a></td><td><?php echo $meteoVEEAMLicence_Franklin ?></td>
	  	</tr>
	</table>
	<?php
	if ($_GET['origin'] == "equipement")
	{
	?>
	<a style="position:absolute;top:600px;left:10px;" href="javascript:history.back()" target="_self">Retour</a>
	<?php } else { ?>
	<a style="position:absolute;top:600px;left:10px;" href="?type=data_center&target=SNP2" target="_self">Retour</a>
	<?php } ?>
<?php
	include 'amchart_veeam.php';
	}
?>