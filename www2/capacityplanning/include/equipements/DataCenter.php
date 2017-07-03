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
	$url_interne_DCAmpere = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_AMPERE' //$id_textuel_menu_DCAmpere
	);
	$url_interne_DCFranklin = getInternalUrl($ressourceBDD_appli, $line_tum['nom_appli'], 'MENU_CAPACITYPLANNING_FRANKLIN' //$id_textuel_menu_DCFranklin
	);
	
	if ($test_meteoTSM_N3_SNP1 == 0 && $test_meteoVirtu_N2_SNP1 == 0)
	{
		$meteoDatacenter_SNP1 = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoTSM_N3_SNP1 >= 1 || $test_meteoVirtu_N2_SNP1 >= 1)
	{
		$meteoDatacenter_SNP1 = "<img src='images/nuageux.png'>";
	}
	else if ($test_meteoTSM_N3_SNP1 >= 1 && $test_meteoVirtu_N2_SNP1 >= 1)
	{
		$meteoDatacenter_SNP1 = "<img src='images/pluvieux.png'>";
	}
	
	if ($test_meteoTSM_N3_SNP2 == 0 && $test_meteoVirtu_N2_SNP2 == 0)
	{
		$meteoDatacenter_SNP2 = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoTSM_N3_SNP2 >= 1 || $test_meteoVirtu_N2_SNP2 >= 1)
	{
		$meteoDatacenter_SNP2 = "<img src='images/nuageux.png'>";
	}
	else if ($test_meteoTSM_N3_SNP2 >= 1 && $test_meteoVirtu_N2_SNP2 >= 1)
	{
		$meteoDatacenter_SNP2 = "<img src='images/pluvieux.png'>";
	}
?>

<?php
	if ($type == "SI") {
?>
	<table class="tableau_meteo_middle">
	  	<tr>
			<th></th><th></th>
		</tr>
		<tr>
	  		<td style="color: black; font-size: 20px;" colspan=2>DataCenter</td>
	  	</tr>
	  	<tr>
			<td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_DCAmpere;?>&type=SI" target="_self">AMPERE</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoDatacenter_SNP1 ?></td>
		</tr>
		<tr>
			<td style="text-align: left; padding-left: 10px;"><a href="/<?php echo $url_interne_DCFranklin;?>&type=SI" target="_self">FRANKLIN</a></td><td style="text-align: right; padding-right: 10px;"><?php echo $meteoDatacenter_SNP2 ?></td>
		</tr>
	</table>
	<a href="javascript:history.back()" target="_self">Retour</a>
<?php
	}
?>