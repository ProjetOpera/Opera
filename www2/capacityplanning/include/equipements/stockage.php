<?php
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	
	$sql_recup_app="SELECT name, role, localisation FROM inv_san.baie WHERE date_releve = (SELECT MAX(date_releve) FROM inv_san.baie) ORDER BY name;";

	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	//echo "<br/>\n";
	//echo "<br/>\n";
	
	$contenu_tab_app = "";
	$nb_ligne=0;
	
	
	
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

<!--<center>
	<select name="menu_deroulant" id="menu_deroulant" onChange="redirection();">
		<option value="SI" <?//=$select_SI?>>SI</option>
		<option value="data_center" <?//=$select_data_center?>>Data Center</option>
		<option value="baie_ipstor" <?//=$select_baie_ipstor?>>Baie/IPSTOR</option>
	</select>
</center></br></br>-->

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
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=data_center" target="_self">Stockage</a></td><td><img src="images/pluvieux.png"></td>
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
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP1" target="_self">Stockage</a></td><td><img src="images/pluvieux.png"></td><td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP2" target="_self">Stockage</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP1" target="_self">IPSTOR</a></td><td><img src="images/pluvieux.png"></td><td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP2" target="_self">IPSTOR</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./id_menu=241" target="_self">Retour</a>
<?php
	}
?>

<?php
	if ($type == "data_center" && $target == "SNP1") {
?>
	<table class="tableau_meteo">
	  	
	  	<tr>
	  		<td style="color: black;" colspan=2>SNP1 - Baies</td>
	  	</tr>
		<?php
		while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_name=$row_recup_app['name'];
		
		$contenu_tab_app .= "<tr>";
			if (substr($recup_name, -3) == "AMP")
				$contenu_tab_app .= "<td>"."<a href='./include/equipements/stockage.php/?type=data_center&target=SNP1_" . $recup_name . "' target='_self'>".$recup_name."</td>";	
		$contenu_tab_app .= "</tr>";
		
		$nb_ligne++;
	}
		?>
		
		<!--<tr>
	  		<td style="color: black;" colspan=2>SNP1 - IPSTOR</td>
	  	</tr>-->
		
		<?php
		

	if($nb_ligne!=0)
	{	
		echo "<table class='tableau_meteo'";
		
		echo $contenu_tab_app;	
		
		echo "</table>";
	}
	?>
	  	<!--<tr>
	  		<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP1_axiom1" target="_self">AXIOM600BENAMP</td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP1_fsone1" target="_self">FSONE316AMP</td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP1 - IPSTOR</td>
	  	</tr>
		<tr>
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP1_falcon1" target="_self">FALCONV8_AMP</td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>-->
	<a href="./include/equipements/stockage.php/?type=data_center&target=data_center" target="_self">Retour</a>
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
	  		<td style="color: black;" colspan=2>SNP2 - Baies</td>
	  	</tr>
	  	<tr>
	  		<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP2_axiom1" target="_self">AXIOM600BENFKL</a></td><td><img src="images/soleil.png"></td>
	  	</tr>
	  	<tr>
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP2_fsone1" target="_self">FSONE316FKL</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
		<tr>
	  		<td style="color: black;" colspan=2>SNP2 - IPSTOR</td>
	  	</tr>
		<tr>
			<td><a href="./include/equipements/stockage.php/?type=data_center&target=SNP2_falcon1" target="_self">FALCONV8_FKL</a></td><td><img src="images/pluvieux.png"></td>
		</tr>
	</table>
	<a href="./include/equipements/stockage.php/?type=data_center&target=data_center" target="_self">Retour</a>
<?php
	}
?>