<?php include 'header.php'; ?>

<script type="text/javascript">
	var Groupes = new Array();
	var IDGroupes = new Array();
</script>

<?php
	if (isset($_GET['annee']))
	{
		$Annee_Choisi = $_GET['annee'];
	}
	else
	{
		$Annee_Choisi = date("Y");
	}

	OuvConnect_CDE();
	
	$groupe = $MaConnect_CDE->query("SELECT DISTINCT(g.ID_Groupe) AS ID_Groupe, g.Libelle AS Libelle, g.Couleur AS Couleur FROM groupe g, enfant e WHERE e.ID_Groupe = g.ID_Groupe AND g.Libelle != 'Congés'");
	
	while ($donnees_groupe = $groupe -> fetch())
	{
?>
	
<script type="text/javascript">
	var NB_Enfant_Date_Groupe_<?=$donnees_groupe['ID_Groupe']?> = new Array();

	IDGroupes.push(<?=$donnees_groupe['ID_Groupe']?>);
	
	Groupes.push({
	    ID_Groupe: <?=$donnees_groupe['ID_Groupe']?>,
	   	Libelle: "<?=$donnees_groupe['Libelle']?>",
	   	Couleur: "<?=$donnees_groupe['Couleur']?>"
	});
</script>

<?php
	}
	
	$date1lundi = date($Annee_Choisi.'-01-01');
	
	$today = date('Y-m-d');

	if ($_GET['annee'] == date("Y"))
	{
		$nb_jour = ((strtotime($today)-strtotime($date1lundi)) / 86400 + 1) / 7;
	}
	else
	{
		$nb_jour = 365 / 7;
	}
	
	for ($i=0; $i<$nb_jour; $i++) {
		$datetraitement = date('Y-m-d', strtotime($date1lundi.'+'.$i.' week'));
		
		$groupe_nb_enfant = $MaConnect_CDE->query("SELECT g.ID_Groupe, COUNT(e.ID_Enfant) AS NB_Enfant FROM enfant e, groupe g WHERE e.ID_Groupe = g.ID_Groupe AND g.Libelle != 'Congés' AND Date_Arrivee <= '".$datetraitement."' AND Date_Depart >= '".$datetraitement."' GROUP BY ID_Groupe");
	
		while ($donnees_groupe_nb_enfant = $groupe_nb_enfant -> fetch())
		{
?>
	
	<script type="text/javascript">	
		NB_Enfant_Date_Groupe_<?=$donnees_groupe_nb_enfant['ID_Groupe']?>["<?=$datetraitement?>"] = <?=$donnees_groupe_nb_enfant['NB_Enfant']?>;
	</script>

<?php
		}
	}
?>

<html>
  	<body>
        <script>
            var chart;
            var chartData = [];
            var chartCursor;
            
            AmCharts.ready(function () {
                generateChartData();

                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = chartData;
                chart.categoryField = "semaine";
                chart.language = "fr";

                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true;
                categoryAxis.minPeriod = "DD";
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.twoLineMode = true;
                categoryAxis.dateFormats = [{
                    period: 'fff',
                    format: 'JJ:NN:SS'
                }, {
                    period: 'ss',
                    format: 'JJ:NN:SS'
                }, {
                    period: 'mm',
                    format: 'JJ:NN'
                }, {
                    period: 'hh',
                    format: 'JJ:NN'
                }, {
                    period: 'DD',
                    format: 'DD'
                }, {
                    period: 'WW',
                    format: 'DD'
                }, {
                    period: 'MM',
                    format: 'MMM'
                }, {
                    period: 'YYYY',
                    format: 'YYYY'
                }];

                categoryAxis.axisColor = "#DADADA";

                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                var legend = new AmCharts.AmLegend();
                legend = new AmCharts.AmLegend();
                legend.position = "bottom";
                legend.align = "center";
                legend.markerType = "square";
                legend.labelText = "[[title]]";
                legend.valueText = "[[value]]";
				chart.addLegend(legend);

                for (var i = 0; i < Groupes.length; i++) {
	                var graph = new AmCharts.AmGraph();
		            graph.title = Groupes[i]['Libelle'];
		            graph.valueField = "nb_enfants_"+Groupes[i]['ID_Groupe'];
		            graph.bullet = "round";
		            graph.balloonText = "[[title]]: <b>[[value]]</b>"
		            graph.bulletBorderColor = Groupes[i]['Couleur'];
		            graph.bulletBorderThickness = 2;
		            graph.bulletBorderAlpha = 1;
		       	    graph.lineThickness = 2;
		            graph.lineColor = Groupes[i]['Couleur'];
		            graph.negativeLineColor = Groupes[i]['Couleur'];
		            graph.hideBulletsCount = 15;
		            chart.addGraph(graph);
                }

	            chartCursor = new AmCharts.ChartCursor();
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "bottom-right";

                chart.write("graphique_nb_enfant");
            });

            function generateChartData() {
                var date1lundi = new Date();
                date1lundi.setYear(<?=$Annee_Choisi?>);
                date1lundi.setDate('1');
                date1lundi.setMonth('0');

                var today = new Date();


            	if (<?=$Annee_Choisi?> == today.getFullYear())
            	{
    				var nb_jour = ((today.getTime() - date1lundi.getTime())/1000/60/60/24 + 1) / 7;
            	}
            	else
            	{
    				var nb_jour = 365 / 7;
            	}
				
                for (var i = 0; i < nb_jour; i++) {
                    var datetraitement = new Date(date1lundi);
                    datetraitement.setDate(datetraitement.getDate() + i*7);

                    var Jour = datetraitement.getDate();
                    if (Jour < 10)
                    {
                    	Jour = '0'+Jour;
                    }
                    
                    var Mois = datetraitement.getMonth()+1;
                    if (Mois < 10)
                    {
                    	Mois = '0'+Mois;
                    }
					
                    chartData.push({
                        semaine: datetraitement,
                        nb_enfants_1: NB_Enfant_Date_Groupe_1[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_2: NB_Enfant_Date_Groupe_2[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_3: NB_Enfant_Date_Groupe_3[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_4: NB_Enfant_Date_Groupe_4[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_9: NB_Enfant_Date_Groupe_9[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_9: NB_Enfant_Date_Groupe_10[datetraitement.getFullYear()+'-'+Mois+'-'+Jour],
                        nb_enfants_9: NB_Enfant_Date_Groupe_15[datetraitement.getFullYear()+'-'+Mois+'-'+Jour]
					});
             	}
            }
        </script>  

		<div class="col-sm-12">
			<div class="col-sm-10">
				<div id="titre" style="text-align: left;">Statistiques pour l'année <font color="#5bc0de"><?=$Annee_Choisi?></font></div>
			</div>

			<div class="form-group col-sm-2">
				<script type="text/javascript">
					function changement_annee()
					{
						document.location.href='stats.php?annee=' + document.getElementById('annee').value;
					}							
				</script>
				<select class="form-control" name="annee" id="annee" onchange="changement_annee();">
				<?php 
					OuvConnect_CDE();
						
					$liste_annee = $MaConnect_CDE->query("SELECT DISTINCT(YEAR(Fin)) AS Annee FROM groupe_utilisateur");
								
					while ($donnees_annee = $liste_annee -> fetch())
					{
						if ($donnees_annee['Annee'] == $Annee_Choisi)
						{
							echo '<option value="'.$donnees_annee['Annee'].'" selected="selected">'.$donnees_annee['Annee'].'</option>';
						}
						else 
						{
				?>
					<option value="<?=$donnees_annee['Annee']?>" onclick="document.location.href='stats.php?annee=<?=$donnees_annee['Annee']?>'"><?=$donnees_annee['Annee']?></option>';
				<?php
						}									
					}
				?>
				</select>
			</div>
		</div>
		
		<div class="col-sm-12"><br>
			<div class="panel panel-primary">
			    <div class="panel-heading">
			      <h3 class="panel-title" style="font-size: 18px;">Effectif enfants par groupe</h3>
			    </div>
        		<div id="graphique_nb_enfant" style="width: 100%; height: 400px;"></div>
        	</div>
        </div>
  	</body>
</html>

<?php include 'footer.php'; ?>