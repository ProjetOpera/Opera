<?php
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
?>
	<!-- Styles -->
	<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
	</style>

	<!-- Resources -->
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<!-- Chart code -->
	<script>
	var chart = AmCharts.makeChart("chartdiv", {
	    "type": "serial",
	    "theme": "light",
	    "marginTop":0,
	    "marginRight": 80,
	    "dataProvider": [{
	        "year": "1950",
	        "value": -0.307
	    }, {
	        "year": "1951",
	        "value": -0.168
	    }, {
	        "year": "1952",
	        "value": -0.073
	    }, {
	        "year": "1953",
	        "value": -0.027
	    }, {
	        "year": "1954",
	        "value": -0.251
	    }, {
	        "year": "1955",
	        "value": -0.281
	    }, {
	        "year": "1956",
	        "value": -0.348
	    }, {
	        "year": "1957",
	        "value": -0.074
	    }, {
	        "year": "1958",
	        "value": -0.011
	    }, {
	        "year": "1959",
	        "value": -0.074
	    }, {
	        "year": "1960",
	        "value": -0.124
	    }, {
	        "year": "1961",
	        "value": -0.024
	    }, {
	        "year": "1962",
	        "value": -0.022
	    }, {
	        "year": "1963",
	        "value": 0
	    }, {
	        "year": "1964",
	        "value": -0.296
	    }, {
	        "year": "1965",
	        "value": -0.217
	    }, {
	        "year": "1966",
	        "value": -0.147
	    }, {
	        "year": "1967",
	        "value": -0.15
	    }, {
	        "year": "1968",
	        "value": -0.16
	    }, {
	        "year": "1969",
	        "value": -0.011
	    }, {
	        "year": "1970",
	        "value": -0.068
	    }, {
	        "year": "1971",
	        "value": -0.19
	    }, {
	        "year": "1972",
	        "value": -0.056
	    }, {
	        "year": "1973",
	        "value": 0.077
	    }, {
	        "year": "1974",
	        "value": -0.213
	    }, {
	        "year": "1975",
	        "value": -0.17
	    }, {
	        "year": "1976",
	        "value": -0.254
	    }, {
	        "year": "1977",
	        "value": 0.019
	    }, {
	        "year": "1978",
	        "value": -0.063
	    }, {
	        "year": "1979",
	        "value": 0.05
	    }, {
	        "year": "1980",
	        "value": 0.077
	    }, {
	        "year": "1981",
	        "value": 0.12
	    }, {
	        "year": "1982",
	        "value": 0.011
	    }, {
	        "year": "1983",
	        "value": 0.177
	    }, {
	        "year": "1984",
	        "value": -0.021
	    }, {
	        "year": "1985",
	        "value": -0.037
	    }, {
	        "year": "1986",
	        "value": 0.03
	    }, {
	        "year": "1987",
	        "value": 0.179
	    }, {
	        "year": "1988",
	        "value": 0.18
	    }, {
	        "year": "1989",
	        "value": 0.104
	    }, {
	        "year": "1990",
	        "value": 0.255
	    }, {
	        "year": "1991",
	        "value": 0.21
	    }, {
	        "year": "1992",
	        "value": 0.065
	    }, {
	        "year": "1993",
	        "value": 0.11
	    }, {
	        "year": "1994",
	        "value": 0.172
	    }, {
	        "year": "1995",
	        "value": 0.269
	    }, {
	        "year": "1996",
	        "value": 0.141
	    }, {
	        "year": "1997",
	        "value": 0.353
	    }, {
	        "year": "1998",
	        "value": 0.548
	    }, {
	        "year": "1999",
	        "value": 0.298
	    }, {
	        "year": "2000",
	        "value": 0.267
	    }, {
	        "year": "2001",
	        "value": 0.411
	    }, {
	        "year": "2002",
	        "value": 0.462
	    }, {
	        "year": "2003",
	        "value": 0.47
	    }, {
	        "year": "2004",
	        "value": 0.445
	    }, {
	        "year": "2005",
	        "value": 0.47
	    }],
	    "valueAxes": [{
	        "axisAlpha": 0,
	        "position": "left"
	    }],
	    "graphs": [{
	        "id":"g1",
	        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
	        "bullet": "round",
	        "bulletSize": 8,
	        "lineColor": "#d1655d",
	        "lineThickness": 2,
	        "negativeLineColor": "#637bb6",
	        "type": "smoothedLine",
	        "valueField": "value"
	    }],
	    "chartScrollbar": {
	        "graph":"g1",
	        "gridAlpha":0,
	        "color":"#888888",
	        "scrollbarHeight":55,
	        "backgroundAlpha":0,
	        "selectedBackgroundAlpha":0.1,
	        "selectedBackgroundColor":"#888888",
	        "graphFillAlpha":0,
	        "autoGridCount":true,
	        "selectedGraphFillAlpha":0,
	        "graphLineAlpha":0.2,
	        "graphLineColor":"#c2c2c2",
	        "selectedGraphLineColor":"#888888",
	        "selectedGraphLineAlpha":1

	    },
	    "chartCursor": {
	        "categoryBalloonDateFormat": "YYYY",
	        "cursorAlpha": 0,
	        "valueLineEnabled":true,
	        "valueLineBalloonEnabled":true,
	        "valueLineAlpha":0.5,
	        "fullWidth":true
	    },
	    "dataDateFormat": "YYYY",
	    "categoryField": "year",
	    "categoryAxis": {
	        "minPeriod": "YYYY",
	        "parseDates": true,
	        "minorGridAlpha": 0.1,
	        "minorGridEnabled": true
	    },
	    "export": {
	        "enabled": true
	    }
	});

	chart.addListener("rendered", zoomChart);
	if(chart.zoomChart){
		chart.zoomChart();
	}

	function zoomChart(){
	    chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
	}
	</script>

	<!-- HTML -->
	<div id="chartdiv"></div>
<?php
	}
?>