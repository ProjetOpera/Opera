<style>
	#chartdiv {
		width	: 73%;
		margin-left: 26%;
		top: 28%;
		float: left;
		height: 350px;
    	position: absolute;
	}																		
</style>

<script src="amcharts/amcharts.js"></script>
	<script src="amcharts/serial.js"></script>
	<script src="amcharts/export.min.js"></script>
	<link rel="stylesheet" href="amcharts/export.css" type="text/css" media="all" />
	<script src="amcharts/light.js"></script>
	
	<script>
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [
			    <?php
					if ($_GET['data'] == 'CPU')
					{
						$sql = "SELECT DISTINCT(Date_Releve), Custom11 AS Total, Custom12 AS Util FROM capacityplanning.vueglobale WHERE Custom3 = '".$sav_cluster."' ORDER BY Date_Releve";
					}
					
					if ($_GET['data'] == 'RAM')
					{
						$sql = "SELECT DISTINCT(Date_Releve), Custom9 AS Total, Custom10 AS Util FROM capacityplanning.vueglobale WHERE Custom3 = '".$sav_cluster."' ORDER BY Date_Releve";
					}
					
					if ($_GET['data'] == 'HDD')
					{
						$sql = "SELECT DISTINCT(Date_Releve), Custom13 AS Total, Custom14 AS Util FROM capacityplanning.vueglobale WHERE Custom3 = '".$sav_cluster."' ORDER BY Date_Releve";
					}

					$result = $ressourceBDD_appli->query($sql);
		
					while ($row = $result->fetch(PDO::FETCH_ASSOC))
					{		
						$taux_util = $row['Util'] / $row['Total'] * 100;
						
						if ($row['Custom10'] < $seuil) {
							$color = '#c0392b';
						}
						if ($row['Custom10'] >= $seuil) {
							$color = '#e67e22';
						}
						if ($row['Custom10'] >= $alerte) {
							$color = '#2980b9';
						}

						$date = date_create($row['Date_Releve']);
				?>
					{
	    				"lineColor": "<?=$color?>",
	    				"date": "<?=date_format($date, 'd-m-Y')?>",
	    				"value": <?=round($taux_util)?>
					},
				<?php
					}
				?>
				],
			    "valueAxes": [{
			        "axisAlpha": 0,
			        "position": "left",
			        "guides": [{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Seuil",
			            "lineAlpha": 1,
			            "color": "#e67e22",
			            "lineColor": "#e67e22",
			            "value": <?=$seuil?>
			        },{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Alerte",
			            "lineAlpha": 1,
			            "color": "#c0392b",
			            "lineColor": "#c0392b",
			            "value": <?=$alerte?>
			        }],
			    }],
			    "graphs": [{
			        "id":"g1",
			        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
			        "bulletSize": 8,
			        "lineColorField": "lineColor",
			        "lineThickness": 2,
			        "type": "smoothedLine",
			        "valueField": "value"
			    }],
			    "chartCursor": {
			        "categoryBalloonDateFormat": "DD/MM/YYYY",
			        "cursorAlpha": 0,
			        "valueLineEnabled":true,
			        "valueLineBalloonEnabled":true,
			        "valueLineAlpha":0.5,
			        "fullWidth":true
			    },
			    "dataDateFormat": "DD/MM/YYYY",
			    "categoryField": "date",
			    "categoryAxis": {
			        "dateFormats": [{
			            "period": "DD",
			            "format": "DD"
			        }, {
			            "period": "WW",
			            "format": "MMM DD"
			        }, {
			            "period": "MM",
			            "format": "MMM"
			        }, {
			            "period": "YYYY",
			            "format": "YYYY"
			        }],
			        "parseDates": true,
			        "autoGridCount": true,
			        "axisColor": "#555555",
			        "gridAlpha": 0,
			        "gridCount": 50
			    },
			    "creditsPosition": "bottom-right"
			}
		);
	</script>

	<!-- HTML -->
	<div id="chartdiv"></div>