<?php
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	/*
	$sql_recup_app="SELECT Module_concerne, Label, Alerte, Seuil, Pourcentage FROM capacityplanning;

	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	echo "<br/>\n";
	echo "<br/>\n";
	
	$contenu_tab_app = "";
	$nb_ligne=0;
	
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_module=$row_recup_app['Module_concerne'];
		$recup_label=  $row_recup_app['Label'];
		$recup_alerte=$row_recup_app['Alerte'];
		$recup_seuil=$row_recup_app['Seuil'];
		$recup_pourcentage=$row_recup_app['Pourcentage'];
		
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
	}
	*/
?>

<table class='display_list2' cellpadding=0 cellspacing=0 border=0>
	<tr class='table_line'>
		<td>Module</td>
		<td>Equipement</td>
		<td>Seuil</td>
		<td>Alerte</td>
		<td style="text-align: center;" colspan=2>Actions</td>
	</tr>
	<tr class='line1'>
		<td>Stockage</td>
		<td>AXIOM600</td>
		<td>4 To</td>
		<td>3 To</td>
		<td style="text-align: center;"><img src='../commun/images/save.png'/></td>
		<td style="text-align: center;"><a class='various1 delete' href=''></a></td>
	</tr>
</table>

<br><br>
<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
</style>

<script src="../amchart/amcharts/amcharts.js"></script>
<script src="../amchart/amcharts/serial.js"></script>

<script>
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "marginTop":0,
    "marginRight": 80,
    "dataProvider": [{
        "year": "2013",
        "value": 300
    }, {
        "year": "2014",
        "value": 320
    }, {
        "year": "2015",
        "value": 330
    }, {
        "year": "2016",
        "value": 210
    }, {
        "year": "2017",
        "value": 418
    }],
    "valueAxes": [{
        "axisAlpha": 0,
        "position": "left"
    }],
    "graphs": [{
        "id":"g1",
        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]] Mo</span></b>",
        "bullet": "round",
        "bulletSize": 8,
        "lineColor": "#d1655d",
        "lineThickness": 2,
        "negativeLineColor": "#637bb6",
        "type": "smoothedLine",
        "valueField": "value"
    }],
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
    }
});

chart.addListener("rendered", zoomChart);
</script>

<!-- HTML -->
<br>
<div id="chartdiv"></div>