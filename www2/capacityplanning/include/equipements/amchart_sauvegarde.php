<?php
	if ($type == "bandes") {	
?>
	<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
	</style>

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<script>
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [
			    <?php
					$sql = "SELECT DISTINCT(Date_Releve), Custom1 FROM capacityplanning.vueglobale WHERE Site = '".$site."'";

					$result = $ressourceBDD_appli->query($sql);
		
					while ($row = $result->fetch(PDO::FETCH_ASSOC))
					{
				?>
					{
	    				"lineColor": "#2980b9",
	    				"date": "<?=$row['Date_Releve']?>",
	    				"value": <?=$row['Custom1']?>
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
			            "label": "Seuil alerte",
			            "lineAlpha": 1,
			            "color": "#e67e22",
			            "lineColor": "#e67e22",
			            "value": 70
			        },{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Seuil critique",
			            "lineAlpha": 1,
			            "color": "#c0392b",
			            "lineColor": "#c0392b",
			            "value": 80
			        }],
			    }],
			    "graphs": [{
			        "id":"g1",
			        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
			        "bullet": "round",
			        "bulletSize": 8,
			        "lineColorField": "lineColor",
			        "lineThickness": 2,
			        "type": "smoothedLine",
			        "valueField": "value"
			    }],
			    "chartCursor": {
			        "categoryBalloonDateFormat": "YYYY-MM-DD",
			        "cursorAlpha": 0,
			        "valueLineEnabled":true,
			        "valueLineBalloonEnabled":true,
			        "valueLineAlpha":0.5,
			        "fullWidth":true
			    },
			    "dataDateFormat": "YYYY-MM-DD",
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
			        "autoGridCount": false,
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
<?php
	}
?>

<?php
	if ($type == "bd") {	
?>
	<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
	</style>

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<script>
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [
			    <?php
					$sql = "SELECT DISTINCT(Date_Releve), Custom2 FROM capacityplanning.vueglobale WHERE Site = '".$site."'";

					$result = $ressourceBDD_appli->query($sql);
		
					while ($row = $result->fetch(PDO::FETCH_ASSOC))
					{
				?>
					{
	    				"lineColor": "#2980b9",
	    				"date": "<?=$row['Date_Releve']?>",
	    				"value": <?=$row['Custom2']?>
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
			            "label": "Seuil alerte",
			            "lineAlpha": 1,
			            "color": "#e67e22",
			            "lineColor": "#e67e22",
			            "value": 70
			        },{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Seuil critique",
			            "lineAlpha": 1,
			            "color": "#c0392b",
			            "lineColor": "#c0392b",
			            "value": 80
			        }],
			    }],
			    "graphs": [{
			        "id":"g1",
			        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
			        "bullet": "round",
			        "bulletSize": 8,
			        "lineColorField": "lineColor",
			        "lineThickness": 2,
			        "type": "smoothedLine",
			        "valueField": "value"
			    }],
			    "chartCursor": {
			        "categoryBalloonDateFormat": "YYYY-MM-DD",
			        "cursorAlpha": 0,
			        "valueLineEnabled":true,
			        "valueLineBalloonEnabled":true,
			        "valueLineAlpha":0.5,
			        "fullWidth":true
			    },
			    "dataDateFormat": "YYYY-MM-DD",
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
			        "autoGridCount": false,
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
<?php
	}
?>

<?php
	if ($type == "lib_util") {	
?>
	<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
	</style>

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<script>
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [
			    <?php
					$sql = "SELECT DISTINCT(Date_Releve), Custom3 FROM capacityplanning.vueglobale WHERE Site = '".$site."'";

					$result = $ressourceBDD_appli->query($sql);
		
					while ($row = $result->fetch(PDO::FETCH_ASSOC))
					{
				?>
					{
	    				"lineColor": "#2980b9",
	    				"date": "<?=$row['Date_Releve']?>",
	    				"value": <?=$row['Custom3']?>
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
			            "label": "Seuil alerte",
			            "lineAlpha": 1,
			            "color": "#e67e22",
			            "lineColor": "#e67e22",
			            "value": 70
			        },{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Seuil critique",
			            "lineAlpha": 1,
			            "color": "#c0392b",
			            "lineColor": "#c0392b",
			            "value": 80
			        }],
			    }],
			    "graphs": [{
			        "id":"g1",
			        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
			        "bullet": "round",
			        "bulletSize": 8,
			        "lineColorField": "lineColor",
			        "lineThickness": 2,
			        "type": "smoothedLine",
			        "valueField": "value"
			    }],
			    "chartCursor": {
			        "categoryBalloonDateFormat": "YYYY-MM-DD",
			        "cursorAlpha": 0,
			        "valueLineEnabled":true,
			        "valueLineBalloonEnabled":true,
			        "valueLineAlpha":0.5,
			        "fullWidth":true
			    },
			    "dataDateFormat": "YYYY-MM-DD",
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
			        "autoGridCount": false,
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
<?php
	}
?>

<?php
	if ($type == "stock_vierges") {	
?>
	<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
	</style>

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

	<script>
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [
			    <?php
					$sql = "SELECT DISTINCT(Date_Releve), Custom4 FROM capacityplanning.vueglobale WHERE Site = '".$site."'";

					$result = $ressourceBDD_appli->query($sql);
		
					while ($row = $result->fetch(PDO::FETCH_ASSOC))
					{
				?>
					{
	    				"lineColor": "#2980b9",
	    				"date": "<?=$row['Date_Releve']?>",
	    				"value": <?=$row['Custom4']?>
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
			            "label": "Seuil alerte",
			            "lineAlpha": 1,
			            "color": "#e67e22",
			            "lineColor": "#e67e22",
			            "value": 70
			        },{
			            "dashLength": 6,
			            "inside": true,
			            "label": "Seuil critique",
			            "lineAlpha": 1,
			            "color": "#c0392b",
			            "lineColor": "#c0392b",
			            "value": 80
			        }],
			    }],
			    "graphs": [{
			        "id":"g1",
			        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
			        "bullet": "round",
			        "bulletSize": 8,
			        "lineColorField": "lineColor",
			        "lineThickness": 2,
			        "type": "smoothedLine",
			        "valueField": "value"
			    }],
			    "chartCursor": {
			        "categoryBalloonDateFormat": "YYYY-MM-DD",
			        "cursorAlpha": 0,
			        "valueLineEnabled":true,
			        "valueLineBalloonEnabled":true,
			        "valueLineAlpha":0.5,
			        "fullWidth":true
			    },
			    "dataDateFormat": "YYYY-MM-DD",
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
			        "autoGridCount": false,
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
<?php
	}
?>