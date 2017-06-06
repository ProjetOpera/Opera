<?php
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	
	/*$sql_recup_app="SELECT name, role, localisation FROM inv_san.baie WHERE date_releve = (SELECT MAX(date_releve) FROM inv_san.baie) ORDER BY name;";

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

<?php
	$test_meteoVEEAM_AmpereN2 = 0;
	$test_meteoVEEAM_FranklinN2 = 0;
	$test_meteoVEEAM_N3 = 0;
?>

<?php
	//Calcul Volumétrie
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='AMPERE'"))
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
	if ($sql = $connexion->query("SELECT Custom1, Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'] / $temp['Custom2'] * 100;
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
			$meteoVEEAMVolume_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMVolume_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoVEEAMVolume_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
	}
	else
	{
		$meteoVEEAMVolume_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licence
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='AMPERE'"))
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
	
	if ($sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
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
		if ($capacity > $seuil)
		{
			$meteoVEEAMLicence_Ampere = "<img src='images/soleil.png'>";
		}
		/*if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMLicence_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoVEEAMLicence_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
	}
	else
	{
		$meteoVEEAMLicence_Ampere = "<img src='images/soleil.png'>";
	}

	//Calcul Volumétrie
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='FRANKLIN'"))
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
	if ($sql = $connexion->query("SELECT Custom1, Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'] / $temp['Custom2'] * 100;
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
			$meteoVEEAMVolume_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMVolume_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoVEEAMVolume_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
	}
	else
	{
		$meteoVEEAMVolume_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licence
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $connexion->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='FRANKLIN'"))
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
	if ($sql = $connexion->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
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
		if ($capacity > $seuil)
		{
			$meteoVEEAMLicence_Franklin = "<img src='images/soleil.png'>";
		}
		/*if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMLicence_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoVEEAMLicence_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
	}
	else
	{
		$meteoVEEAMLicence_Franklin = "<img src='images/soleil.png'>";
	}
?>

<?php if ($test_meteoVEEAM_AmpereN2 == 0)
			{
				$meteoVEEAM_AMPERE = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_AmpereN2 == 1)
			{
				$meteoVEEAM_AMPERE = "<img src='images/nuageux.png'>";
				$test_meteoVEEAM_N3++;
			}
			else if ($test_meteoVEEAM_AmpereN2 >= 2)
			{
				$meteoVEEAM_AMPERE = "<img src='images/pluvieux.png'>";
				$test_meteoVEEAM_N3++;
			}
			
			if ($test_meteoVEEAM_FranklinN2 == 0)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_FranklinN2 == 1)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/nuageux.png'>";
				$test_meteoVEEAM_N3++;
			}
			else if ($test_meteoVEEAM_FranklinN2 >= 2)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/pluvieux.png'>";
				$test_meteoVEEAM_N3++;
			}
			
			if ($test_meteoVEEAM_N3 == 0)
			{
				$meteoVEEAM = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_N3 == 1)
			{
				$meteoVEEAM = "<img src='images/nuageux.png'>";
			}
			else if ($test_meteoVEEAM_N3 >= 2)
			{
				$meteoVEEAM = "<img src='images/pluvieux.png'>";
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
			<td><a href="./include/equipements/veeam.php?type=data_center&target=SNP1" target="_self">Sauvegarde des VMs</a></td><td><img src="images/pluvieux.png"></td><td><a href="./include/equipements/veeam.php?type=data_center&target=SNP2" target="_self">Sauvegarde des VMs</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/veeam.php" target="_self">Retour</a>
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
	}
	
	
	
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
	  		<td style="color: black; font-size: 20px;" colspan=2>SNP1</td>
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
	}*/
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