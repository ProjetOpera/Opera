<?php
	/* ******************************** */
	/* ***** Météo Virtualisation ***** */
	/* ******************************** */

	$test_meteoVirtuSNP1_N3 = 0;
	$test_meteoVirtuSNP2_N3 = 0;
	$test_meteoVirtu_N2 = 0;
	$test_meteoVirtu_N2_SNP1 = 0;
	$test_meteoVirtu_N2_SNP2 = 0;
	$test_datacenter_Virtu = 0;
	
	$capacity = array();
	$SNP1_Clusters = array();
	
	if ($sql = $ressourceBDD_appli->query("SELECT DISTINCT Cluster from inv_datacenter.inv_vcenter_cp WHERE DataCenter='SNP1' AND Cluster NOT LIKE 'VSPGEO%' ORDER BY Cluster ASC"))
	{
		while ($temp = $sql->fetch())
		{
			$SNP1_Clusters[] = $temp['Cluster'];
		}
	}
	
	foreach ($SNP1_Clusters as $Cluster)
	{
		${'test_meteoVirtu_AmpereN2_'.$Cluster} = 0;
	}
	
	$SNP2_Clusters = array();
	
	if ($sql = $ressourceBDD_appli->query("SELECT DISTINCT Cluster from inv_datacenter.inv_vcenter_cp WHERE DataCenter='SNP2' ORDER BY Cluster ASC"))
	{
		while ($temp = $sql->fetch())
		{
			$SNP2_Clusters[] = $temp['Cluster'];
		}
	}
	
	foreach ($SNP2_Clusters as $Cluster)
	{
		${'test_meteoVirtu_FranklinN2_'.$Cluster} = 0;
	}
	
	/* ******************** */
	/* ***** CPU SNP1 ***** */
	/* ******************** */
	
	//$test_meteoVirtu_AmpereN2 = 0;
	//$test_meteoVirtu_FranklinN2 = 0;

	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='CPU utilisé (%)' AND Site='AMPERE'"))
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
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom11, Custom12, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='AMP' AND Custom3='$Cluster' GROUP BY Custom3, Custom11, Custom12 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom12'] / $temp['Custom11'] * 100;
			}
		}
		else
		{
			//$capacity = 0;
		}
	}
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	/* ******************** */
	/* ***** CPU SNP2 ***** */
	/* ******************** */
	
	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='CPU utilisé (%)' AND Site='FRANKLIN'"))
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
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom11, Custom12, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='FKL' AND Custom3='$Cluster' GROUP BY Custom3, Custom11, Custom12 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom12'] / $temp['Custom11'] * 100;
			}
		}
		else
		{
			$capacity = 0;
		}
	}
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	/* ******************** */
	/* ***** HDD SNP1 ***** */
	/* ******************** */
	
	//$test_meteoVirtu_AmpereN2 = 0;
	//$test_meteoVirtu_FranklinN2 = 0;
	//$test_meteoVirtu_N3 = array();

	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='Occupation disque (%)' AND Site='AMPERE'"))
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
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom13, Custom14, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='AMP' AND Custom3='$Cluster' GROUP BY Custom3, Custom13, Custom14 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom14'] / $temp['Custom13'] * 100;
			}
		}
		else
		{
			$capacity = 0;
		}
	}
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	/* ******************** */
	/* ***** HDD SNP2 ***** */
	/* ******************** */
	
	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='Occupation disque (%)' AND Site='FRANKLIN'"))
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
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom13, Custom14, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='FKL' AND Custom3='$Cluster' GROUP BY Custom3, Custom13, Custom14 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom14'] / $temp['Custom13'] * 100;
			}
		}
		else
		{
			$capacity = 0;
		}
	}
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	/* ******************** */
	/* ***** RAM SNP1 ***** */
	/* ******************** */
	
	//$test_meteoVirtu_AmpereN2 = 0;
	//$test_meteoVirtu_FranklinN2 = 0;
	//$test_meteoVirtu_N3 = array();

	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='RAM dispo' AND Site='AMPERE'"))
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
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom9, Custom10, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='AMP' AND Custom3='$Cluster' GROUP BY Custom3, Custom9, Custom10 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom10'] / $temp['Custom9'] * 100;
			}
		}
		else
		{
			$capacity = 0;
		}
	}
	foreach ($SNP1_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_AmpereN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	/* ******************** */
	/* ***** HDD SNP2 ***** */
	/* ******************** */
	
	//$capacity = 0;
	$seuil = 0;
	$alerte = 0;
	$i = 0;
	
	if ($sql = $ressourceBDD_appli->query("SELECT Seuil, Alerte from capacityplanning.parametres WHERE Module_concerne='Virtu' AND Label='Occupation disque (%)' AND Site='FRANKLIN'"))
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
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($sql = $ressourceBDD_appli->query("SELECT Custom3, Custom9, Custom10, MAX(Date_Releve) from capacityplanning.vueglobale WHERE Prevision=1 AND Environnement='Virtualisation' AND Site='FKL' AND Custom3='$Cluster' GROUP BY Custom3, Custom9, Custom10 ORDER BY Custom3 ASC"))
		{
			while ($temp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				$capacity[] = $temp['Custom10'] / $temp['Custom9'] * 100;
			}
		}
		else
		{
			$capacity = 0;
		}
	}
	foreach ($SNP2_Clusters as $Cluster)
	{
		if ($alerte != 0 || $seuil != 0 || $capacity != 0)
		{
			if ($capacity[i] < $seuil)
			{
				
			}
			if ($capacity[i] >= $seuil && $capacity < $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/nuageux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			if ($capacity[i] >= $alerte)
			{
				//$meteoTSMBandes_Ampere = "<img src='images/pluvieux.png'>";
				${'test_meteoVirtu_FranklinN2_'.$Cluster}++;
				//$test_meteoTSM_AmpereN2++;
			}
			$i++;
		}
		else
		{
			//$meteoTSMBandes_Ampere = "<img src='images/soleil.png'>";
		}
	}
	
	foreach ($SNP1_Clusters as $Cluster)
	{
		if (${'test_meteoVirtu_AmpereN2_'.$Cluster} == 0)
		{
			${'meteoVirtu_AMPERE_'.$Cluster} = "<img src='images/soleil.png'>";
		}
		else if (${'test_meteoVirtu_AmpereN2_'.$Cluster} == 1)
		{
			${'meteoVirtu_AMPERE_'.$Cluster} = "<img src='images/nuageux.png'>";
			$test_meteoVirtuSNP1_N3++;
		}
		else if (${'test_meteoVirtu_AmpereN2_'.$Cluster} >= 2)
		{
			${'meteoVirtu_AMPERE_'.$Cluster} = "<img src='images/pluvieux.png'>";
			$test_meteoVirtuSNP1_N3++;
		}
	}
	
	foreach ($SNP2_Clusters as $Cluster)
	{
		if (${'test_meteoVirtu_FranklinN2_'.$Cluster} == 0)
		{
			${'meteoVirtu_FRANKLIN_'.$Cluster} = "<img src='images/soleil.png'>";
		}
		else if (${'test_meteoVirtu_FranklinN2_'.$Cluster} == 1)
		{
			${'meteoVirtu_FRANKLIN_'.$Cluster} = "<img src='images/nuageux.png'>";
			$test_meteoVirtuSNP2_N3++;
		}
		else if (${'test_meteoVirtu_FranklinN2_'.$Cluster} >= 2)
		{
			${'meteoVirtu_FRANKLIN_'.$Cluster} = "<img src='images/pluvieux.png'>";
			$test_meteoVirtuSNP2_N3++;
		}
	}
	
	if ($test_meteoVirtuSNP1_N3 == 0)
	{
		$meteoVirtu_Ampere_N2 = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoVirtuSNP1_N3 >= 1 && $test_meteoVirtuSNP1_N3 <= 3)
	{
		$meteoVirtu_Ampere_N2 = "<img src='images/nuageux.png'>";
		$test_meteoVirtu_N2_SNP1++;
		$test_meteoVirtu_N2++;
	}
	else if ($test_meteoVirtuSNP1_N3 > 3)
	{
		$meteoVirtu_Ampere_N2 = "<img src='images/pluvieux.png'>";
		$test_meteoVirtu_N2_SNP1++;
		$test_meteoVirtu_N2++;
	}
	
	if ($test_meteoVirtuSNP2_N3 == 0)
	{
		$meteoVirtu_Franklin_N2 = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoVirtuSNP2_N3 >= 1 && $test_meteoVirtuSNP1_N3 <= 3)
	{
		$meteoVirtu_Franklin_N2 = "<img src='images/nuageux.png'>";
		$test_meteoVirtu_N2_SNP1++;
		$test_meteoVirtu_N2++;
	}
	else if ($test_meteoVirtuSNP2_N3 > 3)
	{
		$meteoVirtu_Franklin_N2 = "<img src='images/pluvieux.png'>";
		$test_meteoVirtu_N2_SNP1++;
		$test_meteoVirtu_N2++;
	}
	
	if ($test_meteoVirtu_N2 == 0)
	{
		$meteoVirtu = "<img src='images/soleil.png'>";
	}
	else if ($test_meteoVirtu_N2 == 1)
	{
		$meteoVirtu = "<img src='images/nuageux.png'>";
		$test_datacenter_Virtu++;
	}
	else if ($test_meteoVirtu_N2 > 1)
	{
		$meteoVirtu = "<img src='images/pluvieux.png'>";
		$test_datacenter_Virtu++;
	}
?>