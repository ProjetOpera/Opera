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
	<?=date("d/m/Y")?>
</div>

<script type="text/javascript">
	function redirection()
	{
		window.location.href = window.location.href + '&type=' + document.getElementById("menu_deroulant").value + '&target=' + document.getElementById("menu_deroulant").value + '&origin=' + document.getElementById("menu_deroulant").value;
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
	$test_meteoTSM_AmpereN2 = 0;
	$test_meteoTSM_FranklinN2 = 0;
	$test_meteoTSM_N3 = 0;
?>

<?php
	//Calcul Bandes
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
		if ($capacity <= $alerte)
		{
			$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
	}
	else
	{
		$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul BD
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	
	if ($sql = $ressourceBDD_appli->query("SELECT Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom2'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoTSMBD_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoTSMBD_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoTSMBD_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
	}
	else
	{
		$meteoTSMBD_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Lib
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom3'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoTSMLib_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoTSMLib_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoTSMLib_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
	}
	else
	{
		$meteoTSMLib_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Stock vierges
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom4 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom4'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoTSMStock_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoTSMStock_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
		if ($capacity <= $alerte)
		{
			$meteoTSMStock_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_AmpereN2++;
		}
	}
	else
	{
		$meteoTSMStock_Ampere = "<img src='images/soleil.png'>";
	}

	//Calcul Bandes
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoTSMBandes_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoTSMBandes_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
		if ($capacity <= $alerte)
		{
			$meteoTSMBandes_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
	}
	else
	{
		$meteoTSMBandes_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul BD
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom2'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoTSMBD_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoTSMBD_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoTSMBD_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
	}
	else
	{
		$meteoTSMBD_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul Lib
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom3'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoTSMLib_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoTSMLib_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoTSMLib_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
	}
	else
	{
		$meteoTSMLib_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul Stock vierges
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom4'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoTSMStock_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoTSMStock_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
		if ($capacity <= $alerte)
		{
			$meteoTSMStock_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoTSM_FranklinN2++;
		}
	}
	else
	{
		$meteoTSMStock_Franklin = "<img src='images/soleil.png'>";
	}
?>

<?php if ($test_meteoTSM_AmpereN2 == 0)
			{
				$meteoTSM_AMPERE = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_AmpereN2 == 1)
			{
				$meteoTSM_AMPERE = "<img src='images/nuageux.png'>";
				$test_meteoTSM_N3++;
			}
			else if ($test_meteoTSM_AmpereN2 >= 2)
			{
				$meteoTSM_AMPERE = "<img src='images/pluvieux.png'>";
				$test_meteoTSM_N3++;
			}
			
			if ($test_meteoTSM_FranklinN2 == 0)
			{
				$meteoTSM_FRANKLIN = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_FranklinN2 == 1)
			{
				$meteoTSM_FRANKLIN = "<img src='images/nuageux.png'>";
				$test_meteoTSM_N3++;
			}
			else if ($test_meteoTSM_FranklinN2 >= 2)
			{
				$meteoTSM_FRANKLIN = "<img src='images/pluvieux.png'>";
				$test_meteoTSM_N3++;
			}
			
			if ($test_meteoTSM_N3 == 0)
			{
				$meteoTSM = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_N3 == 1)
			{
				$meteoTSM = "<img src='images/nuageux.png'>";
			}
			else if ($test_meteoTSM_N3 >= 2)
			{
				$meteoTSM = "<img src='images/pluvieux.png'>";
			}
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
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes&origin=238" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td><td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes&origin=238" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD&origin=238" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td><td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD&origin=238" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td><td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util&origin=238" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td><td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util&origin=238" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td><td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges&origin=238" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td><td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges&origin=238" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	
<?php
	}
?>