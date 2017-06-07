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
	require_once 'calculsMeteoTSM.php';
?>

<?php
/*
	if ($type == "SI") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>Vue globale</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=data_center" target="_self">Sauvegarde TSM</a></td><td><?php echo $meteoTSM ?></td>
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Ampere</td><td style="color: black; font-size: 20px;" colspan=2>SNP2 - Franklin</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1" target="_self">Sauvegarde TSM</a></td><td><?php echo $meteoTSM_AMPERE ?></td>
			<td><a href="?type=data_center&target=SNP2" target="_self">Sauvegarde TSM</a></td><td><?php echo $meteoTSM_FRANKLIN ?></td>
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
	</table>

	</br></br>

	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
	</table>

	</br></br>
	
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Ampere ?></td>
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
	  		<td><a href="?type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
	</table>

	</br></br>
	
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
	</table>

	</br></br>
	
	<table class="tableau_meteo_middle">
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP1_TSM_Bandes") {
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "bandes";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Ampere ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_TSM_BD") {
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "bd";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP1_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Ampere ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_lib_util")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "lib_util";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Ampere ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_stock_vierges")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "stock_vierges";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'");
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP1_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Ampere ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_TSM_Bandes") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bandes";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'");
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
	  		<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Franklin ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_TSM_BD") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bd";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'");
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
	  		<td><a href="?type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP2_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Franklin ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_lib_util")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "lib_util";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'");
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
	  		<td><a href="?type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="?type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Franklin ?></td>
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
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_stock_vierges")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "stock_vierges";
		$result = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'");
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
	  		<td><a href="?type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</a></td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="?type=data_center&target=SNP2_TSM_BD" target="_self">BD</a></td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="?type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</a></td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		
		</br></br>
		
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a style="color: #2c3e50;" href="?type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</a></td><td><?php echo $meteoTSMStock_Franklin ?></td>
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
	include 'amchart_sauvegarde.php';
	}
?>