<?php

require_once("../../connect.php");
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
	$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
	$temp = $sql->fetch();
	$seuil = $temp['Seuil'];
	$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
	$temp = $sql->fetch();
	$alerte = $temp['Alerte'];

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
			<td><a href="./id_menu=243&type=data_center&target=data_center" target="_self">Sauvegarde TSM</a></td><td><img src="images/pluvieux.png"></td>
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
			<td><a href="./id_menu=243&type=data_center&target=SNP1" target="_self">Sauvegarde TSM</a></td><td><img src="images/pluvieux.png"></td><td><a href="./id_menu=243&type=data_center&target=SNP2" target="_self">Sauvegarde TSM</a></td><td><img src="images/pluvieux.png"></td>
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
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_Bandes" target="_self">Bandes</td><td><img src="images/soleil.png"></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP1_TSM_BD" target="_self">BD</td><td><img src="images/soleil.png"></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_lib_util" target="_self">% d'utilisation</td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP1_stock_vierges" target="_self">Bandes vierges</td><td><img src="images/pluvieux.png"></td>
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
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_Bandes" target="_self">Bandes</td><td><img src="images/soleil.png"></td>
	  	</tr>
		<tr>
	  		<td><a href="./id_menu=243&type=data_center&target=SNP2_TSM_BD" target="_self">BD</td><td><img src="images/soleil.png"></td>
	  	</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Librairie</td>
	  	</tr>
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_lib_util" target="_self">% d'utilisation</td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - Stock</td>
	  	</tr>
		<tr>
			<td><a href="./id_menu=243&type=data_center&target=SNP2_stock_vierges" target="_self">Bandes vierges</td><td><img src="images/pluvieux.png"></td>
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
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP1_TSM_BD") {
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "bd";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP1_lib_util")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "lib_util";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP1_stock_vierges")
	{
		$environnement = "TSM";
		$site = "AMPERE";
		$type = "stock_vierges";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='AMPERE'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP2_TSM_Bandes") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bandes";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Bandes' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP2_TSM_BD") {
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "bd";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='BD' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP2_lib_util")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "lib_util";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Lib_util' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}
	if ($type == "data_center" && $target == "SNP2_stock_vierges")
	{
		$environnement = "TSM";
		$site = "FRANKLIN";
		$type = "stock_vierges";
		$sql = $connexion->query("SELECT Seuil from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$seuil = $temp['Seuil'];
		$sql = $connexion->query("SELECT Alerte from capacityplanning.parametres WHERE Module_concerne='TSM' AND Label='Stock_vierges' AND Site='FRANKLIN'");
		$temp = $sql->fetch();
		$alerte = $temp['Alerte'];
	}

	include 'amchart_sauvegarde.php';
?>