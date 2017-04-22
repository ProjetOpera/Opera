<style type="text/css">
	.date_jour {
	  	text-align: right;
	  	font-size: 16px;
	  	font-weight: bold;
	  	margin-bottom: 2%;
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

	.tableau_meteo a {
		color: #FFFFFF;
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
	if ($type == "SI") {
?>
	<table class="tableau_meteo">
	  	<tr>
			<th></th><th></th>
		</tr>
		<!--
	  	<tr>
	  		<td><a href="./id_menu=239&type=data_center&target=data_center" target="_self">Virtualisation</td><td><img src="images/croix.png">
	  	</tr>
		<tr>
			<td><a href="./id_menu=240&type=data_center&target=data_center" target="_self">VEEAM</td><td><img src="images/croix.png"></td>
		</tr>
	  	<tr>
			<td><a href="./id_menu=241&type=data_center&target=data_center" target="_self">Stockage</a></td><td><img src="images/croix.png"></td>
		</tr>
		-->
	  	<tr>
			<td><a href="./id_menu=243&type=data_center&target=data_center" target="_self">Sauvegarde</td><td><img src="images/nuageux.png"></td>
		</tr>
	</table>
<?php
	}
?>