<?php
	/* ***************************************
		CALCULS METEO VEEAM
   ***************************************/
   
	$test_meteoVEEAM_AmpereN2 = 0;
	$test_meteoVEEAM_FranklinN2 = 0;
	$test_meteoVEEAM_N3 = 0;
			
	//Calcul Volumétrie VEEAM AMPERE
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='AMPERE'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1, Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
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
			$meteoVEEAMVolume_Ampere = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMVolume_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoVEEAMVolume_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
	}
	else
	{
		$meteoVEEAMVolume_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licences VEEAM AMPERE
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='AMPERE'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='AMPERE' AND Date_Releve=CURDATE()"))
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
			$meteoVEEAMLicence_Ampere = "<img src='images/soleil.png'>";
		}
		/*if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoVEEAMLicence_Ampere = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoVEEAMLicence_Ampere = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_AmpereN2++;
		}
	}
	else
	{
		$meteoVEEAMLicence_Ampere = "<img src='images/soleil.png'>";
	}
	
	//Calcul Volumétrie VEEAM FRANKLIN
	$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Volumétrie (%)' AND Site='FRANKLIN'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom1, Custom2 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
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
			$meteoVEEAMVolume_Franklin = "<img src='images/soleil.png'>";
		}
		if ($capacity >= $seuil && $capacity < $alerte)
		{
			$meteoVEEAMVolume_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
		if ($capacity >= $alerte)
		{
			$meteoVEEAMVolume_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
	}
	else
	{
		$meteoVEEAMVolume_Franklin = "<img src='images/soleil.png'>";
	}
	
	//Calcul Licences VEEAM FRANKLIN
	$capacity = 99999;
	$seuil = 0;
	$alerte = 0;
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='VEEAM' AND Label='Licences dispo' AND Site='FRANKLIN'"))
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
	if ($sql = $ressourceBDD_appli->query("SELECT Custom3 from capacityplanning.vueglobale WHERE Prevision=0 AND Environnement='VEEAM' AND Site='FRANKLIN' AND Date_Releve=CURDATE()"))
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
			$meteoVEEAMLicence_Franklin = "<img src='images/soleil.png'>";
		}
		/*if ($capacity <= $seuil && $capacity > $alerte)
		{
			$meteoVEEAMLicence_Franklin = "<img src='images/nuageux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}*/
		if ($capacity <= $alerte)
		{
			$meteoVEEAMLicence_Franklin = "<img src='images/pluvieux.png'>";
			$test_meteoVEEAM_FranklinN2++;
		}
	}
	else
	{
		$meteoVEEAMLicence_Franklin = "<img src='images/soleil.png'>";
	}
	
	if ($test_meteoVEEAM_AmpereN2 == 0)
			{
				$meteoVEEAM_AMPERE = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_AmpereN2 == 1)
			{
				$meteoVEEAM_AMPERE = "<img src='images/nuageux.png'>";
				$test_meteoVEEAM_N3++;
			}
			else if ($test_meteoVEEAM_AmpereN2 >= 2)
			{
				$meteoVEEAM_AMPERE = "<img src='images/pluvieux.png'>";
				$test_meteoVEEAM_N3++;
			}
			
			if ($test_meteoVEEAM_FranklinN2 == 0)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_FranklinN2 == 1)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/nuageux.png'>";
				$test_meteoVEEAM_N3++;
			}
			else if ($test_meteoVEEAM_FranklinN2 >= 2)
			{
				$meteoVEEAM_FRANKLIN = "<img src='images/pluvieux.png'>";
				$test_meteoVEEAM_N3++;
			}
			
			if ($test_meteoVEEAM_N3 == 0)
			{
				$meteoVEEAM = "<img src='images/soleil.png'>";
			}
			else if ($test_meteoVEEAM_N3 == 1)
			{
				$meteoVEEAM = "<img src='images/nuageux.png'>";
			}
			else if ($test_meteoVEEAM_N3 >= 2)
			{
				$meteoVEEAM = "<img src='images/pluvieux.png'>";
			}
?>