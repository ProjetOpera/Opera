<?php

require_once("connect.php");
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	
	/*$sql_recup_app="SELECT * FROM capacityplanning.vueglobale WHERE Rate_Releve = (SELECT MAX(Date_Releve) FROM capacityplanning.vueglobale) ORDER BY Environnement;";

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

	.tableau_meteo2 {
		width: 40%;
		margin-left: 5%;
		background-color: #66A3C7;
	}
	
	.tableau_graph {
		width: 45%;
		margin-left: 45%;
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
	// Variables pour tester dans les niveau 1 et 2 si on affiche Soleil, Nuage ou Pluie
	
	$test_meteoTSM_AmpereN2 = 0;
	$test_meteoTSM_FranklinN2 = 0;
	$test_meteoTSM_N3 = 0;
?>

<?php
	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Label='Bandes' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom2'];
	}
	
	if ($capacity > $alerte)
	{
		$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
	}
	else if ($capacity <= $alerte && $capacity > $seuil)
	{
		$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	else
	{
		$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	
	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Label='BD' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom3'];
	}
	
	if ($capacity < $alerte)
	{
		$meteoTSMBD_Ampere = "<img src='images/soleil.png'>";
	}
	else if ($capacity >= $alerte && $capacity < $seuil)
	{
		$meteoTSMBD_Ampere = "<img src='images/nuageux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	else
	{
		$meteoTSMBD_Ampere = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_AmpereN2++;
	}

	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Label='Lib_util' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom3'];
	}
	
	if ($capacity < $alerte)
	{
		$meteoTSMLib_Ampere = "<img src='images/soleil.png'>";
	}
	else if ($capacity >= $alerte && $capacity < $seuil)
	{
		$meteoTSMLib_Ampere = "<img src='images/nuageux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	else
	{
		$meteoTSMLib_Ampere = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	
	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom4 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='AMPERE' AND Label='Stock_vierges' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom4'];
	}
	
	if ($capacity > $alerte)
	{
		$meteoTSMStock_Ampere = "<img src='images/soleil.png'>";
	}
	else if ($capacity <= $alerte && $capacity > $seuil)
	{
		$meteoTSMStock_Ampere = "<img src='images/nuageux.png'>";
		$test_meteoTSM_AmpereN2++;
	}
	else
	{
		$meteoTSMStock_Ampere = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_AmpereN2++;
	}

	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Label='Bandes' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom2'];
	}
	
	if ($capacity > $alerte)
	{
		$meteoTSMBandes_Franklin = "<img src='images/soleil.png'>";
	}
	else if ($capacity <= $alerte && $capacity > $seuil)
	{
		$meteoTSMBandes_Franklin = "<img src='images/nuageux.png'>";
		$test_meteoTSM_FranklinN2++;
	}
	else
	{
		$meteoTSMBandes_Franklin = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_FranklinN2++;
	}

	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Label='BD' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom3'];
	}
	
	if ($capacity < $alerte)
	{
		$meteoTSMBD_Franklin = "<img src='images/soleil.png'>";
	}
	else if ($capacity >= $alerte && $capacity < $seuil)
	{
		$meteoTSMBD_Franklin = "<img src='images/nuageux.png'>";
		$test_meteoTSM_FranklinN2++;
	}
	else
	{
		$meteoTSMBD_Franklin = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_FranklinN2++;
	}

	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Label='Lib_util' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom3'];
	}
	
	if ($capacity < $alerte)
	{
		$meteoTSMLib_Franklin = "<img src='images/soleil.png'>";
	}
	else if ($capacity >= $alerte && $capacity < $seuil)
	{
		$meteoTSMLib_Franklin = "<img src='images/nuageux.png'>";
		$test_meteoTSM_FranklinN2++;
	}
	else
	{
		$meteoTSMLib_Franklin = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_FranklinN2++;
	}

	$sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$seuil = $temp['Seuil'];
		$alerte = $temp['Alerte'];
	}
	$sql = $connexion->query("SELECT Custom4 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='TSM' AND Site='FRANKLIN' AND Label='Stock_vierges' AND Date_Releve=NOW()");
	while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
	{
		$capacity = $temp['Custom4'];
	}
	
	if ($capacity > $alerte)
	{
		$meteoTSMStock_Franklin = "<img src='images/soleil.png'>";
	}
	else if ($capacity <= $alerte && $capacity > $seuil)
	{
		$meteoTSMStock_Franklin = "<img src='images/nuageux.png'>";
		$test_meteoTSM_FranklinN2++;
	}
	else
	{
		$meteoTSMStock_Franklin = "<img src='images/pluvieux.png'>";
		$test_meteoTSM_FranklinN2++;
	}

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
			<td><a href="./id_menu=243&type=data_center&target=data_center" target="_self">Sauvegarde TSM</a></td><td>
			<?php if ($test_meteoTSM_N3 == 0)
			{
				echo "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_N3 == 1)
			{
				echo "<img src='images/nuageux.png'>";
			}
			else
			{
				echo "<img src='images/pluvieux.png'>";
			}?>
			</td>
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
	  		<td style="color: black;" colspan=2>SNP1 - Ampère</td><td style="color: black;" colspan=2>SNP2 - Franklin</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1" target="_self">Sauvegarde TSM</a></td><td>
			<?php if ($test_meteoTSM_AmpereN2 == 0)
			{
				echo "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_AmpereN2 == 1)
			{
				echo "<img src='images/nuageux.png'>";
				$test_meteoTSM_N3++;
			}
			else
			{
				echo "<img src='images/pluvieux.png'>";
				$test_meteoTSM_N3++;
			}?>
			</td><td><a href="./id_menu=243&type=data_center&target=SNP2" target="_self">Sauvegarde TSM</a></td><td>
			<?php if ($test_meteoTSM_FranklinN2 == 0)
			{
				echo "<img src='images/soleil.png'>";
			}
			else if ($test_meteoTSM_FranklinN2 == 1)
			{
				echo "<img src='images/nuageux.png'>";
				$test_meteoTSM_N3++;
			}
			else
			{
				echo "<img src='images/pluvieux.png'>";
				$test_meteoTSM_N3++;
			}?>
			</td>
		</tr>
	</table>
	<a href="./id_menu=243" target="_self">Retour</a>
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
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
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
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP1_TSM_Bandes") {
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "bandes";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_TSM_BD") {
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "bd";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_lib_util")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "lib_util";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP1_stock_vierges")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "stock_vierges";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - TSM</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Ampere ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Ampere ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Ampere ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_TSM_Bandes") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bandes";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_TSM_BD") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bd";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_lib_util")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "lib_util";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
	if ($type == "data_center" && $target == "SNP2_stock_vierges")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "stock_vierges";
		$result = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'");
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $row['Seuil'];
			$alerte = $row['Alerte'];
		}
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP2</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><?php echo $meteoTSMBandes_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><?php echo $meteoTSMBD_Franklin ?></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><?php echo $meteoTSMLib_Franklin ?></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><?php echo $meteoTSMStock_Franklin ?></td>
		</tr>
	</table>
	<a href="./id_menu=243&type=data_center&target=data_center" target="_self">Retour</a>
<?php
	include 'amchart_sauvegarde.php';
	}
?>