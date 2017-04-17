<html>
<head>
<script type="text/javascript" src="./include/seuils_alertes/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="./include/seuils_alertes/modify_records.js"></script>
</head>
<body>
<div id="wrapper">

<?php	
	
	$sql_recup_app="SELECT id, Module_concerne, Label, Alerte, Seuil FROM capacityplanning.parametres;";

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
		
		$contenu_tab_app .= "<tr id='row" . $row_recup_app['id'] . "' class='line" . (($nb_ligne+1)%2) . "'>\n";
			$contenu_tab_app .= "<td id=module_val". $row_recup_app['id'] . ">".$recup_module."</td>\n";
			$contenu_tab_app .= "<td id=label_val" . $row_recup_app['id'] . ">".$recup_label."</td>\n";
			$contenu_tab_app .= "<td id=alerte_val" . $row_recup_app['id'] . ">".$recup_alerte."</td>\n";
			$contenu_tab_app .= "<td id=seuil_val" . $row_recup_app['id'] . ">".$recup_seuil."</td>\n";
			$contenu_tab_app .= "<td><input type='button' id='edit_button".$row_recup_app['id']."' value='Editer' class='edit' onclick='edit_row(".$row_recup_app['id'].")'>
										<input type='button' id='save_button".$row_recup_app['id']."' value='Sauvegarder' class='save' onclick='save_row(".$row_recup_app['id'].")'>
										<input type='button' value='Supprimer' class='delete' onclick='delete_row(".$row_recup_app['id'].")'></td>";
		$contenu_tab_app .= "</tr>\n";
		$nb_ligne++;
	}
	
	$contenu_tab_app .= "<tr id='new_row'>
 <td><input type='text' id='new_module'></td>
 <td><input type='text' id='new_label'></td>
 <td><input type='text' id='new_seuil'></td>
 <td><input type='text' id='new_alerte'></td>
 <td><input type='button' value='Insérer ligne' onclick='insert_row();'></td>
</tr>";
	
	if($nb_ligne!=0)
	{	
		echo "<table class='display_list2' id='user_table' cellpadding=0 cellspacing=0 border=0>\n";
		
		echo "<tr class='table_line'>\n";
		
			echo "<td>Module</td>\n";
			echo "<td>Equipement</td>\n";
			echo "<td>Alerte</td>\n";
			echo "<td>Seuil</td>\n";
			echo "<td>Actions</td>\n";
			
		echo "</tr>\n";
		
		echo $contenu_tab_app;
		
		echo "</table>\n";
	}
	
?>

</div>
</body>
</html>

<!--<table class='display_list2' cellpadding=0 cellspacing=0 border=0>
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
</table>-->

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