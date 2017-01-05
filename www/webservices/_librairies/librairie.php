<?php

// Correction sur la récupération des noms des biens ( barcode au lieu de la caractéristique DNS ) - fait le 03/12/09 SR
	
$refresh = 60*5;	

function message($texte,$type)
{
	echo "<center><div class='message_$type'>";
	echo $texte;
	echo "</div></center>";
}

function oraConnexionTNS2($tns,$user,$password)
{
	$conn = null;
	try
	{
		$conn = new PDO("oci:dbname=".$tns.";charset=UTF8",$user,$password);
	}
	catch(PDOException $e)
	{
		echo ($e->getMessage());
	}
	return $conn;
}


	
// creation pour les connexions au RAC oracle
function oraConnexionTNS($db,$user,$password) {
   $conn = oci_connect($user,$password,$db);
   if (!$conn) {
     $e = oci_error();
     echo htmlentities($e['message']);
	 return null;
	}

   return $conn;
 } 	
	

// ********************************************************************************** 
function oraConnexion($host,$port,$sid,$user,$password) {
   $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port)))(CONNECT_DATA=(SID=$sid)))";
   $conn = oci_connect($user,$password,$db);
   if (!$conn) {
     $e = oci_error();
     echo htmlentities($e['message']);
	 return null;
   }

   return $conn;
 } 

 
 // ********************************************************************************** 
 function mysqlConnexion($dbhost, $dbport , $dbuser, $dbpass,$dbname) {
 	
	$conn = null;
	try
	{
		$conn = new PDO("mysql:host=".$dbhost.";dbport=".$dbport.";dbname=".$dbname,$dbuser,$dbpass);
		$conn-> exec('SET NAMES utf8');
	}
	catch(PDOException $e)
	{
		echo ($e->getMessage());
	}
	return $conn;
	
 }
 
 // ********************************************************************************** 
 function myConnexion() {
 	include("parametres.inc.php");
 	$link = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die("Impossible de se connecter sur " & $dbname);
	return $link;
 }

/****************************************************************
*   Fonction : Afficher une erreur SQL avec la connexion PDO    *
*****************************************************************
*  Format d'appel : ErrorPdo (__FILE__, __LINE__, $query, $linkPdo, $soap)
*
*  L'argument facultatif $soap, s'il existe, represente un object du serveur SAOP
*/
function ErrorPdo ($fileName, $noLine, $query, $linkPdo, $soap=null) {
	$err = $linkPdo->errorInfo ();
	$query = print_r($query, true);
	$msg = "<br/>Error SQL in file <b>\"$fileName\"</b> on Ligne <b>$noLine</b><br/><br/>Query = $query<br/><br/>$err[2]<br/>";
	// $msg = "Error SQL in file \"$fileName\" on Ligne $noLineQuery = $query ".$err[2];
	if ($soap) {
		$soap->fault (500, $msg);
		return;
	}
	die ($msg);
}


/***************************************
*   Fonction : Afficher une erreur SQL *
****************************************
*  Format d'appel : ErreurSql (__FILE__, __LINE__, $query, $link->error)
*/
function ErreurMySql ($fileName, $noLine, $query, $err) {
	$err = $linkPdo->errorInfo ();
	$query = print_r($query, true);
	$msg = "<br/>Error SQL in file <b>\"$fileName\"</b> on Ligne <b>$noLine</b><br/><br/>Query = $query<br/><br/>$err<br/>";
	// $msg = "Error SQL in file \"$fileName\" on Ligne $noLineQuery = $query ".$err[2];
	if ($soap) {
		$soap->fault (500, $msg);
		return;
	}
	die ($msg);
}

/**********************************************************
*   Fonction : Afficher sous format HTML des erreurs SOAP *
***********************************************************
*  Format d'appel : AfficheSoapFault ($err)
*/
function AfficheSoapFault ($fault) {
	echo $fault->faultstring;
	trigger_error("SOAP Fault: (faultcode: {$fault->faultcode})", E_USER_ERROR);
}

// Tableau-coin-ouvrant =======================================================
function tableau_coin_ouvrant($titre,$full=false) {
	/* Affichage en plein écran si $full=true */
	echo "<table align=center ".($full?"style='width:100%'":"").">\n";

	/* Cellules haut */
	echo "<tr>\n";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/sbhead-l.gif) no-repeat top left;'></td>\n";
	echo "<td style='width:auto; color: white; margin: 0; padding-top: 17; padding-bottom:3; height:30; text-align: center; background: url(images/haut.gif) repeat-x top left;'>\n";
	echo "<font class=normal><b>".$titre."</font>\n";
	echo "</td>\n";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/sbhead-r.gif) no-repeat top right;'></td>\n";
	echo "</tr>";

	/* Cellules milieu */
	echo "<tr>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/gauche.gif) repeat-y top left;'></td>\n";
	echo "<td style='width:auto;  margin: 0; padding: 2; text-align: center; background-color: #e5e5e5;'>\n";
}

// Tableau-coin-fermant =======================================================
function tableau_coin_fermant($titre) {
	echo "</td>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/droite.gif) repeat-y bottom right;'></td>\n";
	echo "</tr>";

	/* Cellules bas */
	echo "<tr>";
	echo "<td style='width: 30px; height:30; margin: 0; padding: 0; background: url(images/sbbody-l.gif) repeat-y bottom left;'></td>\n";
	echo "<td style='width:auto;  height:30; margin: 0; padding: 0; padding-top:5; padding-bottom:20; text-align: center; background: url(images/bas.gif) repeat-x bottom left;'>\n";
	echo $titre;
	echo "</td>\n";
	echo "<td style='width: 30px; height:30; margin: 0; padding: 0; background: url(images/sbbody-r.gif) repeat-y bottom right;'></td>\n";
	echo "</tr>\n";

	echo "</table>\n";
}

// ********************************************************************************** 
function tableau($link,$type,$query,$titre,$lien,$bcsv=TRUE) {
	$msdeb=microtime(true);
	
	$dark_color = "lightyellow"; // "#B0C0B0";
	$light_color = "#e5e5e5"; //"#FAFAFA";
	
//	echo "<p align=center>";

	$result = mysqli_query($link, $query);
	$num_rows = mysqli_num_rows($result);
	switch ($num_rows) {
		case 0:    // Liste vide
//			echo "<font class=small><br>".($titre<>""?$titre.": ":"")."Liste vide";
			break;
		case ($num_rows > 1000): // Liste contenant plus de 1000 réponses 
			echo "<font class=normal>Résultat supérieur à 1000 lignes (".$num_rows.").<br>Merci de revoir votre filtre...<br><br>";
			break;
		default:
		
			// Début tableau
			tableau_coin_ouvrant($titre);
		
			echo "<table class=tableau>";
			
			while ($finfo = mysqli_fetch_field($result)) {
				$column_name = $finfo->name;
				echo "<th class=tableau>";
				echo $column_name;
				echo "</th>";
			}
			while ($row = mysqli_fetch_row($result)) {
//				echo "<tr bgcolor=".$light_color.">";
				echo "<tr onmouseover=\"this.bgColor='".$dark_color."'\" onmouseout=\"this.bgColor='".$light_color."'\" bgColor='".$light_color."'>";
				$first=true;
				$today=0;
				foreach ($row as $item) {
					if (strpos($item, "/"))	if (date("d/m/Y")==substr($item, 0, 10)) $today=1;
					switch ($item) {
						case "MD": // 
							$bgcolor="#00AAAA style='text-align:center;'"; $color="#FFFFFF"; break;
						case "CO": // 
							$bgcolor="#00AAAA style='text-align:center;'"; $color="#FFFFFF"; break;
						case "AN": // Blanc sur fond Noir
							$bgcolor="#000000 style='text-align:center;'"; $color="#FFFFFF"; break;
						case "EC": // Vert Clair sur Fond vert sombre
							$bgcolor="#00AA00 style='text-align:center;'"; $color="#00FF00"; break;
						case "CL": // Blanc sur fond Gris
							$bgcolor="#AAAAAA style='text-align:center;'"; $color="#FFFFFF"; break;
						case "PL": // Blanc sur fond Jaune
							$bgcolor="#AAAA00 style='text-align:center;'"; $color="#FFFFFF"; break;
						case "CR": // Noir sur fond Blanc
							$bgcolor="#FFFFFF style='text-align:center;'"; $color="#000000"; break;
						case "AT": // Noir sur fond Gris
							$bgcolor="#DDDDDD style='text-align:center;'"; $color="#000000"; break;
						case "VP": // Noir sur fond Gris
							$bgcolor="#DDDDDD style='text-align:center;'"; $color="#000000"; break;
						case "TE": //  sur fond 
							$bgcolor="#AAAAEE style='text-align:center;'"; $color="#000000"; break;
						default:
							$bgcolor=$color=""; //$light_color; 
//							if ($today==1) $bgcolor="#EEEE55"; //$dark_color;
							if ($today==1) $bgcolor=$dark_color;
					}		
					echo "<td class=tableau ".(is_numeric($item)?"align=right":"")." bgcolor=".$bgcolor.">";
					echo "<font color=".$color.">";
					if ($first && $lien<>"") echo (isset($_SESSION["user"])?"<a href=".$lien.(strpos($lien,"?")?"&":"?")."id=".urlencode($item).">":"")."<b>";
					if (substr($item, 0, 3)=="RET") {
						$item=substr($item, 3);
//						echo "<img title='".abs($item)."' src='images/".($item>0?"puce_rouge.gif":"puce_verte.gif")."' height=12>";
						echo "<img title='".abs($item)."' src='images/".($item>0?"unhappy.gif":"happy.gif")."' height=12>&nbsp;";
					} else if (substr($item, 0, 6)=="PPVMEX") {
						$item=substr($item, 6);
						echo "<img src='images/".($item>=1?"12-em-check.png":"12-em-pencil.png")."'>&nbsp;&nbsp;";
					}
					echo ($item?$item:'&nbsp;');
					
					if ($first && $lien<>"") { echo "</a>"; $first=false; }
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			$msfin=microtime(true);

			// Fin tableau
			if ($bcsv==TRUE) {
			$sbuffer="<font color=#555555><b>";
			$sbuffer.="<a href='export_csv.php?requete=".urlencode(preg_replace('/\s\s+/', ' ', $query))."'><img src='images/xls.jpg' height=13 title='Extraction CSV'></a>";
			$sbuffer.="&nbsp;".$num_rows." ligne".($num_rows>1?"s":"")." retournée".($num_rows>1?"s":""); //." en ".sprintf("%01.3f",$msfin-$msdeb)."s.";
			} else $sbuffer="";
			tableau_coin_fermant($sbuffer);
	}
//	echo "<br>";
//	echo "</p>";
	mysqli_free_result($result);
}
 
// ********************************************************************************** 

function liste($link,$type,$query,$titre) {
	$dark_color = "lightyellow"; // "#B0C0B0";
	$light_color = "#e5e5e5"; //"#FAFAFA";
	
	// Début tableau
	tableau_coin_ouvrant($titre);
			
	echo "<table class=tableau>";
	
	$result = mysqli_query($link, $query);
	if (mysqli_num_rows($result)) {
		
		$row = mysqli_fetch_row($result);
		$fields = mysqli_fetch_fields($result);
  
		for ($Ind = 0; $Ind < count($fields); $Ind++) {
			echo "<tr>";
			echo "<th class=tableau>";
			echo $fields[$Ind]->name."&nbsp&nbsp";
//			echo "(".$fields[$Ind]->type.")&nbsp&nbsp";
			echo "</th>\n";
			
			switch ($row[$Ind]) {
				case "MD": // 
					$bgcolor="#00AAAA style='text-align:center;'"; $color="#FFFFFF"; break;
				case "CO": // 
					$bgcolor="#00AAAA style='text-align:center;'"; $color="#FFFFFF"; break;
				case "AN": // Blanc sur fond Noir
					$bgcolor="#000000 style='text-align:center;'"; $color="#FFFFFF"; break;
				case "EC": // Vert Clair sur Fond vert sombre
					$bgcolor="#00AA00 style='text-align:center;'"; $color="#00FF00"; break;
				case "CL": // Blanc sur fond Gris
					$bgcolor="#AAAAAA style='text-align:center;'"; $color="#FFFFFF"; break;
				case "PL": // Blanc sur fond Jaune
					$bgcolor="#AAAA00 style='text-align:center;'"; $color="#FFFFFF"; break;
				case "CR": // Noir sur fond Blanc
					$bgcolor="#FFFFFF style='text-align:center;'"; $color="#000000"; break;
				case "AT": // Noir sur fond Gris
					$bgcolor="#DDDDDD style='text-align:center;'"; $color="#000000"; break;
				case "VP": // Noir sur fond Gris
					$bgcolor="#DDDDDD style='text-align:center;'"; $color="#000000"; break;
				case "TE": //  sur fond 
					$bgcolor="#AAAAEE style='text-align:center;'"; $color="#000000"; break;
				default:
					$bgcolor=$light_color; $color="";
//					$bgcolor=$light_color." STYLE='filter:alpha(style=0,opacity=80)'"; $color="";
			}			
	
			echo "<td class=tableau width=400 bgcolor=".$bgcolor.">";
			echo "<font color=".$color.">";
/*			if ($fields[$Ind]->type == 252) { // BLOB pour la photographie d'un acteur
				$src = ($row[$Ind]==''?"images/inconnu.jpg":"image.php?id=".$row[0]);
				echo "<img height=100 src='".$src."'>"; 
			} else */echo $row[$Ind];
			echo "</td>";
			echo "</tr>";
		}
	} else echo "<tr><td><font class=normal>Liste vide<br><br></font></td></tr>";
	echo "</table>";

	// Fin tableau
	tableau_coin_fermant('');
	

	mysqli_free_result($result);
}

// ********************************************************************************** 

// ********************************************************************************** 

// ============================================================================
function affiche_csv($file, $server,$champ=-1) {
	$file = "fichiers/Inventaire de PROD en liste 2008-06-02 V1.csv";
	$handle = @fopen($file, "r");
	if ($handle) {
		while (!feof($handle)) {
			$buffer = explode(";",fgets($handle));
			if ($buffer[0]==$server) {
			if ($champ==-1) {
					for ($indice = 1;$indice<count($buffer);++$indice) {
						echo $buffer[$indice]." / ";
					}
					} else { echo $buffer[$champ]; }
				echo "<br>";
			}
		}
		fclose($handle);
	}
}


// ********************************************************************************** 
 function ora_tableau($conn,$query,$titre,$bcsv) 
 {
   $stmt = oci_parse($conn,$query);
   $r = oci_execute($stmt,OCI_DEFAULT);
//   echo "<table border=1 align=center bordercolor=#B0C0B0 cellspacing=0 cellpadding=1 rules=cols>";
   
//   if ($titre) echo "<caption><font class=titre>".$titre."</font></caption>";

	tableau_coin_ouvrant($titre);
   
	echo "<table class=tableau>";

   $ncols = oci_num_fields($stmt);
   echo "<th class=tableau>";
   echo "<tr>";
   for ($i = 1; $i <= $ncols; $i++) {
     echo "<td><b>(".$i.")</b></td>";
   }
   echo "</tr>\n";
   echo "<tr>";
   for ($i = 1; $i <= $ncols; $i++) {
     $column_name = oci_field_name($stmt, $i);
//     $column_type = oci_field_type($stmt, $i);
//     $column_size = oci_field_size($stmt, $i);
     echo "<td><b>".$column_name."</b></td>";
   }
   echo "</th>\n";
   echo "</tr>\n";
   while ($row = oci_fetch_row($stmt))
   {
     $num_rows = oci_num_rows($stmt);
     if ($num_rows > 1000) {  // Liste contenant plus de 1000 réponses 
			echo "<i class='erreur'><br>Résultat supérieur à 1000 lignes.<br><br>Merci de revoir votre filtre...<br><br></i>";
			break;
			}
     
        //gestion du retard
       $retard=$row[1]?$row[1]:'&nbsp;';;
       if ( $retard <= 0 )
       {
     		  $classretard="class='retard'";
       }
       elseif ( $retard <= 6 )
       {
     		  $classretard="class='delai6'";
       }
       elseif ( $retard <= 24 )
       {
     		  $classretard="class='delai24'";
       }
       else 
       {
     		  $classretard="";
       }
     echo "<tr ".$classretard.">";
     // la premiere colonne est la reference de la fiche 
     echo "<td class=tableau><a href='detailFiche.php?fiche=".$row[0]."' target='_blank'>".$row[0]."</a></td>\n";
     for ($i = 1; $i < $ncols; $i++) {
       echo "<td class=tableau>".($row[$i]?htmlentities($row[$i]):'&nbsp;')." &nbsp</td>";
     }
     
     //foreach ($row as $item) {
     //  echo "<td class=tableau>".($item?htmlentities($item):'&nbsp;')." &nbsp</td>";
     //}
     echo '</tr>';
   }
   echo '</table>';
	// Fin tableau
			$sbuffer="<font color=#555555><b>";
	if ($bcsv==TRUE) 
	{
			$sbuffer.="<a href='export_ora_csv.php?requete=".urlencode(preg_replace('/\s\s+/', ' ', $query))."'><img src='images/xls.jpg' height=13 title='Extraction CSV'></a>";
	}
			$sbuffer.="&nbsp;".$num_rows." ligne".($num_rows>1?"s":"")." retournée".($num_rows>1?"s":"");
	
	
	tableau_coin_fermant($sbuffer);
   
   
   echo "<font class=small>".$query."</font>";
   echo "<br><br>";
   
   oci_free_statement($stmt);
 }
 
 // ********************************************************************************** 
 function ora_tableau_simple($conn,$query,$titre,$bcsv) 
 {
   $stmt = oci_parse($conn,$query);
   $r = oci_execute($stmt,OCI_DEFAULT);
//   echo "<table border=1 align=center bordercolor=#B0C0B0 cellspacing=0 cellpadding=1 rules=cols>";
   
//   if ($titre) echo "<caption><font class=titre>".$titre."</font></caption>";

	tableau_coin_ouvrant($titre);
   
	echo "<table class=tableau>";

   $ncols = oci_num_fields($stmt);
   echo "<th class=tableau>";
   echo "<tr>";
   for ($i = 1; $i <= $ncols; $i++) {
     echo "<td><b>(".$i.")</b></td>";
   }
   echo "</tr>\n";
   echo "<tr>";
   for ($i = 1; $i <= $ncols; $i++) {
     $column_name = oci_field_name($stmt, $i);
     echo "<td><b>".$column_name."</b></td>";
   }
   echo "</th>\n";
   echo "</tr>\n";
   while ($row = oci_fetch_row($stmt))
   {
     $num_rows = oci_num_rows($stmt);
     if ($num_rows > 1000) {  // Liste contenant plus de 1000 réponses 
			echo "<i class='erreur'><br>Résultat supérieur à 1000 lignes.<br><br>Merci de revoir votre filtre...<br><br></i>";
			break;
			}
     

     // la premiere colonne est la reference de la fiche 
     for ($i = 0; $i < $ncols; $i++) {
       echo "<td class=tableau>".($row[$i]?htmlentities($row[$i]):'&nbsp;')." &nbsp</td>";
     }
     
     //foreach ($row as $item) {
     //  echo "<td class=tableau>".($item?htmlentities($item):'&nbsp;')." &nbsp</td>";
     //}
     echo '</tr>';
   }
   echo '</table>';
	// Fin tableau
			$sbuffer="<font color=#555555><b>";
	if ($bcsv==TRUE) 
	{
			$sbuffer.="<a href='export_ora_csv.php?requete=".urlencode(preg_replace('/\s\s+/', ' ', $query))."'><img src='images/xls.jpg' height=13 title='Extraction CSV'></a>";
	}
			$sbuffer.="&nbsp;".$num_rows." ligne".($num_rows>1?"s":"")." retournée".($num_rows>1?"s":"");
	
	
	tableau_coin_fermant($sbuffer);
   
   
   echo "<font class=small>".$query."</font>";
   echo "<br><br>";
   
   oci_free_statement($stmt);
 }
 
 // ********************************************************************************** 
 function ora_tableau_url($conn,$query,$titre,$selected) {

   $stmt = oci_parse($conn,$query);
   $r = oci_execute($stmt,OCI_DEFAULT);

   echo "<table align=center bordercolor=#B0C0B0 cellspacing=0 cellpadding=1 rules=none>";
//   echo "<caption>".$title."</caption>";
   echo "<caption><font class=titre>".$titre."</font>".(isset($_COOKIE['affquery'])?"<br><font class=requete>".$query."</font>":"")."</caption>";
   echo "<tr>";
   $ncols = oci_num_fields($stmt);
   for ($i = 1; $i <= $ncols; $i++) {
     $column_name = oci_field_name($stmt, $i);
     $column_type = oci_field_type($stmt, $i);
     $column_size = oci_field_size($stmt, $i);
     echo "<td class=tableau>";
     echo "<b>".$column_name."</b><br>";
     echo "</td>";
   }
   echo "</tr>";

   while ($row = oci_fetch_row($stmt)) {
     $boucle = 0;
     echo '<tr>';
     foreach ($row as $item) {
	   $boucle = $boucle + 1 ;
	   $valeur = ($item?htmlentities($item):'&nbsp;');
	   if ($boucle == 1 and $valeur != $selected) {$valeur = "<a href='".$_SERVER['PHP_SELF']."?tablespace=".$valeur."'>".$valeur."</a>";}
       echo "<td class=tableau>".$valeur."</td>";
     }
     echo '</tr>';
   }
   echo '</table>';
   echo '<br>';

   oci_free_statement($stmt);
 }
 
 
 
 function afficherAide($fichier,$tabAide)
 {
	echo "<center>";
	echo "<table border=1 cellpadding=2 cellspacing=0>";
	echo "<tr>";
	echo "<td colspan=2 style='background-color:blue' align=center><h2>Webservice ".(basename(preg_replace('/\.php$/', '', $fichier)))."</h2></td>";
	echo "</tr>";
	if ( is_array($tabAide))
	{
		ksort($tabAide);
		foreach ( $tabAide as $key => $val )
		{
			echo "<tr>";
			echo "<td width=200px valign='top'><b>$key</b></td>";
			echo "<td>$val</td>";
			echo "</tr>";
		}
	}
	echo "</center>";
 }
 
 
 function array2xml($array, $xml = false, $top = "node"){
    if($xml === false){
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><'.$top.'s></'.$top.'s>');
    }
	
	$node= dom_import_simplexml($xml); 
	$no = $node->ownerDocument; 
	
    foreach($array as $key => $value){
	
		if ( is_numeric($key) ) { $key=$top; }
		if(is_array($value)){
            array2xml($value, $xml->addChild($key),$top);
        }else{
			
            
			if ( mb_detect_encoding($value) != "UTF-8" ) { $value=utf8_encode($value); }
			$child = $xml->addChild($key);
			if ( $child != NULL)
			{
				$node = dom_import_simplexml($child);
				$no   = $node->ownerDocument;
				$node->appendChild($no->createCDATASection($value));
			}
		}
    }
    return $xml->asXML();
}

function array2json($datas)
{
	return json_encode($datas);
}

function array2csv($datas,$affichageColonne = "Y", $sep=";")
{
	/*
	$date=date("Ymd_His"); 
	header("Content-type: text/csv;charset=utf-8");
	header("Content-Disposition: attachment; filename=export_$date.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	*/
	$csv="";
	$colonnes="";
	
	if ( is_array($datas) && count($datas)>0 )
	{
		for ( $i=0; $i < count($datas) ; $i++ )
		{
			$ligne=$datas[$i];
			
			foreach ( $ligne as $key => $val)
			{
				if ( $affichageColonne == "Y" && $i == 0 ) //affichage entete
				{
					$enc=mb_detect_encoding($key); if ( $enc == "UTF-8" ) { $key = utf8_decode($key); }
					$colonnes.=$key.$sep;
				}
				$enc=mb_detect_encoding($val); if ( $enc == "UTF-8" ) { $val = utf8_decode($val); }
				$csv.=$val.$sep;
			}
			$csv.="\n";
		}
		if ( ! empty($colonnes) ) { $colonnes.="\n";}
	}
	
	
	return $colonnes.$csv;
}

function array2html($datas,$filtreAffichage,$titre)
{
	include_once ("../../_librairies/librairie.php");
	include_once ("../_librairies/parametres.inc.php");
	
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta charset=\"UTF-8\">";
	echo "<title>$titre</title>\n";
	echo "<link rel='stylesheet' type='text/css' href='../../portailv2/CSS/template.css' />\n";
	echo "<link rel='stylesheet' type='text/css' href='../_librairies/style.css' />\n";
	echo "</head>\n";
	echo "<body>\n";
	
	
	echo "<div class='enteteWS'>$titre</div>";
	echo "<table width=100% border=0 cellspacing=10 cellpadding=1 >";
	echo "<tr><td>";
	
	
	if ( is_array($datas) && count($datas)>0 && is_array($filtreAffichage) )
	{
		
		echo "<table class='display_list2' cellspacing=0 cellpadding=3 border=1>\n";
		
		//head
		echo "<thead>\n";
		foreach ( $filtreAffichage as $key => $val)
		{
			echo "<th class='table_line'>".$key."</th>";
		}
		echo "</thead>";
		
		for ( $i=0; $i < count($datas) ; $i++ )
		{
			echo "<tr>\n";
			foreach ( $filtreAffichage as $key => $val)
			{
				if ( $filtreAffichage[$key] == 1 )
				{
									
					$data="&nbsp";
					if ( array_key_exists($key,$datas[$i]) )
					{
						$data= $datas[$i][$key];
						if ( $key == "FICHE" ) //lien vers la fiche
						{
							$data="<a href='".str_replace("&fiche&",$data,$url_detailFiche)."' target='_blank'>$data</a>";
						}
					}
					if ( empty($data) ) { $data="&nbsp"; }
					echo "<td>$data</td>";
				}
			}
			echo "</tr>\n";
			
		}
		echo "<table>\n";
	}
		else
	{
		message("Aucune donn&eacute;e correspondante &agrave; votre recherche","info");
	}
	
	echo "</td></tr>";
	echo "</table>";
	echo "</body>\n";
	echo "</html>\n";
}

/**************************************************************************
 *    Encoder un tableau (array) en fonction du type de sortie demandee   *
 **************************************************************************/
function encodeSortie ($array, $sortie="json") {
	switch (strtolower($sortie)) {
		case "xml" :  return array2xml  ($array, false, "resultat");
		case "html" : return array2html ($array);
		//Type de sortie par defaut : JSON
		default : return array2json ($array);
	}
	return;
}

/***************************************************************************
 *    Calcul du nombre de jours ouvrees entre 2 dates au format DateTime   *
 ***************************************************************************/
function nbJoursOuvresEtFeriesEntre2Dates ($startDate, $endDate) {
	$diff = $endDate->diff($startDate);
	$dureeTotale = $diff->days + 1;
	$resteDivPar7 = $dureeTotale % 7;
	$numWeekDay = (int)($dureeTotale/7) * 5;
	
	//Si le reste de la division du nombre de jour par 7 est non nul ==> il faut le tenir compte
	//en fonction du jour de la semaine du jour de fin et celui du jour du debut
	if ($resteDivPar7) {
		//Si le jour de la semaine du jour de fin est apres que celui du jour du debut
		if ($endDate->format('w') >= $startDate->format('w'))
			//Prendre en compte le reste des jours
			$numWeekDay += $resteDivPar7;
		//Si le jour de la semaine du jour de fin est avant que celui du jour du debut ==> il y a le week end dans le reste des jours
		//Enlever les 2 jours du week end dans le reste des jours
		else
			$numWeekDay += $resteDivPar7 - 2;
	}
	return $numWeekDay;
	

}

?>