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
	
	/*if (isset($_GET['origin'])) {
		$origin = $_GET['origin'];
	}*/
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
	//$url_interne_veeam = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_VEEAM' //$id_textuel_menu_veeam
	//);
	//$url_interne_stockage = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_STOCKAGE' //$id_textuel_menu_stockage
	//);
	$url_interne_virtu = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_VIRTUALISATION' //$id_textuel_menu_virtu
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
	  		<td style="color: black; font-size: 20px; text-align: center;" colspan=4>Sauvegarde TSM</td>
	  	</tr>
	  	<tr>
			<td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_sauvegarde;?>&type=data_center&target=SNP1" target="_self">AMPERE</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoTSM_AMPERE ?></td><td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_sauvegarde;?>&type=data_center&target=SNP2" target="_self">FRANKLIN</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoTSM_FRANKLIN ?></td>
		</tr>
		</table>
		
		</br></br>
		
		<table class="tableau_meteo_middle">
		<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px; text-align: center;" colspan=4>Virtualisation</td>
	  	</tr>
	  	<tr>
	  		<td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_virtu;?>&type=data_center&target=SNP1" target="_self">AMPERE</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoVirtu_Ampere_N2 ?></td><td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_virtu;?>&type=data_center&target=SNP1" target="_self">FRANKLIN</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoVirtu_Franklin_N2 ?></td>
	  	</tr>
		</table>
		
		<!--<table class="tableau_meteo_middle">
		<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1 - VEEAM</td><td style="color: black; font-size: 20px;" colspan=2>SNP2 - VEEAM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="/<?php //echo $url_interne_veeam;?>&type=data_center&target=SNP1" target="_self">Sauvegardes de VMs</a></td><td><?php //echo $meteoVEEAM_AMPERE ?></td><td><a href="/<?php //echo $url_interne_veeam;?>&type=data_center&target=SNP2" target="_self">Sauvegardes de VMs</a></td><td><?php //echo $meteoVEEAM_FRANKLIN ?></td>
	  	</tr>
		</table>
		
		</br></br>
		
		<table class="tableau_meteo_middle">
		<tr>
			<th></th><th></th><th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>Vue globale - Stockage</td>
	  	</tr>
	  	<tr>
	  		<td><a href="/<?php //echo $url_interne_stockage;?>&type=data_center&target=SNP1" target="_self">Stockage</a></td><td><?php //echo $meteoStockage ?></td>
	  	</tr>
	</table>-->
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>