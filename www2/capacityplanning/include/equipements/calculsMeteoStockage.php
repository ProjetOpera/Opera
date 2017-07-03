<?php
	/***************************************
			CALCULS METEO Stockage
	***************************************/
   
	$test_meteoStockage = 0;
			
	//Calcul taux d'utilisation Stockage AMPERE
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Taux util' AND Site='AMPERE'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='Stockage' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoStockageTaux_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoStockageTaux_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoStockage++;
		}
		if ($capacity >= $alerte)
		{
			$meteoStockageTaux_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoStockage++;
		}
	}
	else
	{
		$meteoStockageTaux_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul taux d'utilisation Stockage FRANKLIN
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Taux util' AND Site='FRANKLIN'"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$seuil = $temp['Seuil'];
			$alerte = $temp['Alerte'];
		}
	}
	else
	{
		$seuil = 0;
		$alerte = 0;
	}
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='Stockage' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity < $seuil)
		{
			$meteoStockageTaux_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoStockageTaux_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoStockage++;
		}
		if ($capacity >= $alerte)
		{
			$meteoStockageTaux_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoStockage++;
		}
	}
	else
	{
		$meteoStockageTaux_Franklin = "<img src='images/soleil.png'>";
	}
	
	if ($test_meteoStockage == 0)
	{
		$meteoStockage = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoStockage == 1)
	{
		$meteoStockage = "<img src='images/nuageux.png'>";
	}
	else if ($test_meteoStockage >= 2)
	{
		$meteoStockage = "<img src='images/pluvieux.png'>";
	}
	
	/*if ($test_meteoStockage_FranklinN2 == 0)
	{
		$meteoStockage_FRANKLIN = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoStockage_FranklinN2 == 1)
	{
		$meteoStockage_FRANKLIN = "<img src='images/nuageux.png'>";
		$test_meteoStockage_N3++;
	}
	else if ($test_meteoStockage_FranklinN2 >= 2)
	{
		$meteoStockage_FRANKLIN = "<img src='images/pluvieux.png'>";
		$test_meteoStockage_N3++;
	}*/
			
	/*if ($test_meteoStockage_N3 == 0)
	{
		$meteoStockage = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoStockage_N3 == 1)
	{
		$meteoStockage = "<img src='images/nuageux.png'>";
	}
	else if ($test_meteoStockage_N3 >= 2)
	{
		$meteoStockage = "<img src='images/pluvieux.png'>";
	}*/
?>