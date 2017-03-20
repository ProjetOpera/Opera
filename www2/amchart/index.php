<style>
	#chartdiv {
		width	: 100%;
		height	: 500px;
	}																		
</style>

<script src="amcharts/amcharts.js"></script>
<script src="amcharts/serial.js"></script>

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
if(chart.zoomChart){
	chart.zoomChart();
}

function zoomChart(){
    chart.zoomToIndexes(0, Math.round(chart.dataProvider.length));
}
</script>

<!-- HTML -->
<br>
<div id="chartdiv"></div>