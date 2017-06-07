<?php
	/* ***************************************
		CALCULS METEO Stockage
   ***************************************/
   
	$test_meteoStockage_AmpereN2 = 0;
	$test_meteoStockage_FranklinN2 = 0;
	$test_meteoStockage_N3 = 0;
			
	//Calcul Volumétrie Stockage AMPERE
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Volumétrie (%)' AND Site='AMPERE'"))
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
			$test_meteoStockage_AmpereN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoStockageTaux_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoStockage_AmpereN2++;
		}
	}
	else
	{
		$meteoStockageTaux_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licences Stockage AMPERE
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Licences dispo' AND Site='AMPERE'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='Stockage' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom3'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoStockageLicence_Ampere = "<img src='images/soleil.png'>";
		}
		/*if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoStockageLicence_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoStockage_AmpereN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoStockageLicence_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoStockage_AmpereN2++;
		}
	}
	else
	{
		$meteoStockageLicence_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Volumétrie Stockage FRANKLIN
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Volumétrie (%)' AND Site='FRANKLIN'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1, Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='Stockage' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom1'] / $temp['Custom2'] * 100;
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
			$test_meteoStockage_FranklinN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoStockageTaux_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoStockage_FranklinN2++;
		}
	}
	else
	{
		$meteoStockageTaux_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licences Stockage FRANKLIN
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Stockage' AND Label='Licences dispo' AND Site='FRANKLIN'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='Stockage' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
	{
		while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $temp['Custom3'];
		}
	}
	else
	{
		$capacity = 0;
	}
	if ($alerte != 0 || $seuil != 0 || $capacity != 0)
	{
		if ($capacity > $seuil)
		{
			$meteoStockageLicence_Franklin = "<img src='images/soleil.png'>";
		}
		/*if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoStockageLicence_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoStockage_FranklinN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoStockageLicence_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoStockage_FranklinN2++;
		}
	}
	else
	{
		$meteoStockageLicence_Franklin = "<img src='images/soleil.png'>";
	}
	
	if ($test_meteoStockage_AmpereN2 == 0)
			{
				$meteoStockage_AMPERE = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoStockage_AmpereN2 == 1)
			{
				$meteoStockage_AMPERE = "<img src='images/nuageux.png'>";
				$test_meteoStockage_N3++;
			}
			else if ($test_meteoStockage_AmpereN2 >= 2)
			{
				$meteoStockage_AMPERE = "<img src='images/pluvieux.png'>";
				$test_meteoStockage_N3++;
			}
			
			if ($test_meteoStockage_FranklinN2 == 0)
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
			}
			
			if ($test_meteoStockage_N3 == 0)
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
			}
?>