<?php
	if ($type == "lib_util") {
		echo $site;
?>
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
		var chart = AmCharts.makeChart(
			"chartdiv", {
			    "type": "serial",
			    "theme": "light",
			    "dataProvider": [{
			        "lineColor": "#2980b9",
			        "date": "2012-01-01",
			        "value": 51
			    }, {
			        "lineColor": "#2980b9",
			        "date": "2012-01-02",
			        "value": 57
			    }, {
			        "lineColor": "#2980b9",
			        "date": "2012-01-03",
			        "value": 60
			    }, {
			        "lineColor": "#e67e22",
			        "date": "2012-01-04",
			        "value": 70
			    }, {
			        "lineColor": "#e67e22",
			        "date": "2012-01-05",
			        "value": 78
			    }, {
			        "lineColor": "#c0392b",
			        "date": "2012-01-06",
			        "value": 80
			    }, {
			        "lineColor": "#c0392b",
			        "date": "2012-01-07",
			        "value": 84
			    }],
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