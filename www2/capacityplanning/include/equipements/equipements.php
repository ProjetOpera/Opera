<?php
	require_once("connect.php");
	chdir (dirname(__FILE__));
    require_once("../../parametres.inc.php");
?>

<style type="text/css">
	.date_jour {
	  	text-align: right;
	  	font-size: 16px;
	  	font-weight: bold;
	  	margin-bottom: 2%;
	}
	
	.tableau_meteo_middle {
		width: 50%;
		margin-left: 25%;
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
		//window.location.href = window.location.href + '?type=' + document.getElementById("menu_deroulant").value + '&target=' + document.getElementById("menu_deroulant").value + '&origin=' + document.getElementById("menu_deroulant").value;
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
	
	if (isset($_GET['origin'])) {
		$origin = $_GET['origin'];
	}
?>

<?php
	require_once 'calculsMeteoTSM.php';
	require_once 'calculsMeteoVEEAM.php';
	require_once 'calculsMeteoStockage.php';
	require_once 'calculsMeteoVirtu.php';
?>

<?php			
	$url_interne_sauvegarde = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_SAUVEGARDE' //$id_textuel_menu_sauvegarde
	);
	$url_interne_veeam = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_VEEAM' //$id_textuel_menu_veeam
	);
	$url_interne_stockage = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_STOCKAGE' //$id_textuel_menu_stockage
	);
	$url_interne_stockage = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_VIRTUALISATION' //$id_textuel_menu_virtu
	);
?>

<?php
	if ($type == "SI") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td><td style="color: black;" colspan=2>SNP2 - TSM</td>
	  	</tr>
	  	<tr>
			<td><a href="/<?php echo $url_interne_sauvegarde;?>&type=data_center&target=data_center&origin=equipement" target="_self">Sauvegarde TSM</a></td><td><?php echo $meteoTSM_AMPERE ?></td><td><a href="/<?php echo $url_interne_sauvegarde;?>&type=data_center&target=data_center&origin=equipement" target="_self">Sauvegarde TSM</a></td><td><?php echo $meteoTSM_FRANKLIN ?></td>
		</tr>
		</table>
		
		</br></br>
		
		<table class="tableau_meteo_middle">
		<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - VEEAM</td><td style="color: black;" colspan=2>SNP2 - VEEAM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="/<?php echo $url_interne_veeam;?>&type=data_center&target=data_center&origin=equipement" target="_self">Sauvegardes de VMs</a></td><td><?php echo $meteoVEEAM_AMPERE ?></td><td><a href="/<?php echo $url_interne_veeam;?>&type=data_center&target=data_center&origin=equipement" target="_self">Sauvegardes de VMs</a></td><td><?php echo $meteoVEEAM_FRANKLIN ?></td>
	  	</tr>
		</table>
		
		</br></br>
		
		<table class="tableau_meteo_middle">
		<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>Vue globale - Stockage</td>
	  	</tr>
	  	<tr>
	  		<td><a href="/<?php echo $url_interne_stockage;?>&type=data_center&target=data_center&origin=equipement" target="_self">Stockage</a></td><td><?php echo $meteoStockage ?></td>
	  	</tr>
	</table>
	
<?php
	}
?>