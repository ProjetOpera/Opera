<?php
	
	// Liste des types de champs MySQL
	//   0 = "DECIMAL",
	//   1 = "TINYINT"
	//   2 = "SMALLINT"
	//   3 = "INTEGER"
	//   4 = "FLOAT"
	//   5 = "DOUBLE"
	//   7 = "TIMESTAMP"
	//   8 = "BIGINT"
	//   9 = "MEDIUMINT"
	//  10 = "DATE"
	//  11 = "TIME"
	//  12 = "DATETIME"
	//  13 = "YEAR"
	//  14 = "DATE"
	//  16 = "BIT"
	// 246 = "DECIMAL"
	// 247 = "ENUM"
	// 248 = "SET"
	// 249 = "TINYBLOB"
	// 250 = "MEDIUMBLOB"
	// 251 = "LONGBLOB"
	// 252 = "BLOB"
	// 253 = "VARCHAR"
	// 254 = "CHAR"
	// 255 = "GEOMETRY"
	
$refresh = 60*5;
$Env_Teledif = "Télédiffusion";
$Env_Packaging = "Packaging";
$Env_Int_Pdt = "Intégration Pdt";
$Env_Int_Srv = "Intégration Srv";
$Env_ProdSrv = "Pré-Production;Production;Secours;Pra;Recette";
$Env_Pdt = $Env_Int_Pdt.";".$Env_Packaging.";".$Env_Teledif;
$Env_Srv = $Env_Int_Srv.";".$Env_ProdSrv;


//***********************************************************************************
function isEnvTeledif ($env) {
	global $Env_Teledif;
	return ($env == $Env_Teledif);
}

	
//***********************************************************************************
function isEnvPdt ($env) {
	global $Env_Pdt;

	foreach (explode (";", $Env_Pdt) as $unEnv)
		if ($env == $unEnv ) return (true);
	return false;
}

	
//***********************************************************************************
function isEnvSrv ($env) {
	global $Env_Srv;

	foreach (explode (";", $Env_Srv) as $unEnv)
		if ($env == $unEnv ) return (true);
	return false;
}

	
//***********************************************************************************
function isAuthentify () {
	// redirection vers la liste des acteurs
	if (!isset($_SESSION["acteur"])) {
		header("location: index.php");
		exit;
	}
}

	
// ********************************************************************************** 
function oraConnexion($host,$port,$sid,$user,$password) {
//	echo "Connexion ".$host."/".$sid;

   $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$host.")(PORT = ".$port.")))(CONNECT_DATA=(SID=".$sid.")))";
   $conn = oci_connect($user,$password,$db);
   if (!$conn) {
     $e = oci_error();
     echo htmlentities($e['message']);
     exit;
   }

   return $conn;
 } 

 // ********************************************************************************** 
 function myConnexion() {
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'fjMk2y6L';
//	$dbpass =  '' ;
	$dbname = 'CPIO';

	$link = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die("Impossible de se connecter sur " & $dbname);
	return $link;
 }


// Tableau-coin-ouvrant =======================================================
function tableau_coin_ouvrant($titre,$full=false) {
	/* Affichage en plein écran si $full=true */
	echo "<table ".($full?"style='width:100%'":"").">";

	/* Cellules haut */
	echo "<tr>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/sbhead-l.gif) no-repeat top left;'></td>";
	echo "<td style='width:auto; color: white; margin: 0; padding-top: 17; padding-bottom:3; height:30; text-align: center; background: url(images/haut.gif) repeat-x top left;'>";
	echo "<font class=normal><b>".$titre."</font>";
	echo "</td>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/sbhead-r.gif) no-repeat top right;'></td>";
	echo "</tr>";

	/* Cellules milieu */
	echo "<tr>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/gauche.gif) repeat-y top left;'></td>";
	echo "<td style='width:auto;  margin: 0; padding: 2; text-align: center; background-color: #e5e5e5;'>";
}

// Tableau-coin-fermant =======================================================
function tableau_coin_fermant($titre) {
	echo "</td>";
	echo "<td style='width: 30px; margin: 0; padding: 0; background: url(images/droite.gif) repeat-y bottom right;'></td>";
	echo "</tr>";

	/* Cellules bas */
	echo "<tr>";
	echo "<td style='width: 30px; height:30; margin: 0; padding: 0; background: url(images/sbbody-l.gif) repeat-y bottom left;'></td>";
	echo "<td style='width:auto;  height:30; margin: 0; padding: 0; padding-top:5; padding-bottom:20; text-align: center; background: url(images/bas.gif) repeat-x bottom left;'>";
	echo $titre;
	echo "</td>";
	echo "<td style='width: 30px; height:30; margin: 0; padding: 0; background: url(images/sbbody-r.gif) repeat-y bottom right;'></td>";
	echo "</tr>";

	echo "</table>";
}

// ********************************************************************************** 
function tableau($link, $type, $query, $titre, $lien, $bcsv=TRUE, $windowname = "", $windowsize="", $afficheListeVide = false) {

	$msdeb=microtime(true);
	
	$dark_color = "lightyellow"; // "#B0C0B0";
	$light_color = "#e5e5e5"; //"#FAFAFA";
	
//	echo "<p align=center>";
	$result = mysqli_query($link, $query) or die ("<br>".$query."<br>".mysqli_error($link));
	$num_rows = mysqli_num_rows($result);
	switch ($num_rows) {
		case 0:    // Liste vide
			if ($afficheListeVide == true) {
				// Début tableau
				tableau_coin_ouvrant($titre);
				echo "<font class=normal><br>Liste vide";
				tableau_coin_fermant($sbuffer);
			}
			break;
//		case ($num_rows > 1000): // Liste contenant plus de 1000 réponses 
//			echo "<font class=normal>Résultat supérieur à 1000 lignes ($num_rows).<br>Merci de revoir votre filtre...<br><br>";
//			break;
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
						case "AR": //  Chocolat sur fond Jaune
							$bgcolor="#4C1B1B style='text-align:center;'"; $color="#FFFFFF"; break;
						case "DA": //  Jaune sur fond Chocolat
							$bgcolor="#FFFFFF style='text-align:center;'"; $color="#4C1B1B"; break;
						default:
							$bgcolor=$color=""; //$light_color; 
//							if ($today==1) $bgcolor="#EEEE55"; //$dark_color;
							if ($today==1) $bgcolor=$dark_color;
					}		
					echo "<td class=tableau ".(is_numeric($item)?"align=right":"")." bgcolor=".$bgcolor.">";
					echo "<font color=".$color.">";
					if (($first) && ($lien != "")) {
						echo "<a HREF=".$lien.(strpos($lien,"?")?"&":"?")."id=".urlencode($item);
						if ($windowname) {
							echo " onClick='w=window.open(this.href,\"$windowname\",\"$windowsize\"); w.document.close(); w.focus(); return false'";
						}
						echo ">";
						echo "<b>";
					}
					if (substr($item, 0, 3)=="RET") {
						$item=substr($item, 3);
//						echo "<img title='".abs($item)."' src='images/".($item>0?"puce_rouge.gif":"puce_verte.gif")."' height=12>";
						echo "<img title='".abs($item)."' src='images/".($item>0?"unhappy.gif":"happy.gif")."' height=12>&nbsp;";
					} else if (substr($item, 0, 6)=="PPVMEX") {
						$item=substr($item, 6);
						echo "<img src='images/".($item>=1?"12-em-check.png":"12-em-pencil.png")."'>&nbsp;&nbsp;";
					}
					echo ($item?$item:'&nbsp;');
					
					if ($first && $lien<>"") { echo "</A>"; $first=false; }
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			$msfin=microtime(true);
			// Fin tableau
			if ($bcsv==TRUE) {
				list ($usec, $sec) = explode(" ", microtime());
				list ($zero, $usec) = explode(".", $usec);
				$formName = "AfficheExcel_$usec";
				echo "<FORM NAME='$formName' METHOD='POST' ACTION='export_csv.php'>";
				echo "<INPUT TYPE='HIDDEN' NAME='requete' VALUE='".rawurlencode(preg_replace('/\s\s+/', ' ', $query))."'>";
				$sbuffer="<font color=#555555><b>";
//				$sbuffer.="<a HREF='export_csv.php?requete=".rawurlencode(preg_replace('/\s\s+/', ' ', $query))."'><img src='images/xls.jpg' height=13 title='Extraction CSV'></A>";
				if (isset($_SESSION["user"]))
					$sbuffer.="<A HREF='JAVASCRIPT:$formName.submit()'><IMG SRC='images/xls.jpg' height=13 title='Extraction CSV'></A>";
				$sbuffer.="&nbsp;".$num_rows." ligne".($num_rows>1?"s":"")." retournée".($num_rows>1?"s":""); //." en ".sprintf("%01.3f",$msfin-$msdeb)."s.";
				echo "</FORM>";
			} 
			else 
				$sbuffer="";
			tableau_coin_fermant($sbuffer);
	}
//	echo "<br>";
//	echo "</p>";
	mysqli_free_result($result);
}
 
// ********************************************************************************** 

function liste_dt($link, $type, $query, $titre, $afficheListeVide = false) {
	tableau($link, $type, $query, $titre, "dt_fiche.php", true, "DTFiche_Window", "width=900, height=650, left=0, top=0, scrollbars=1, resizable=1", $afficheListeVide);
}
// ********************************************************************************** 

function liste($link,$type,$query,$titre) {
	$dark_color = "lightyellow"; // "#B0C0B0";
	$light_color = "#e5e5e5"; //"#FAFAFA";
	
	// Début tableau
	tableau_coin_ouvrant($titre);
			
	echo "<table class=tableau>";
	
	($result = mysqli_query($link, $query))  or die ("<br> ERROR Line ".__LINE__." in File ".__FILE__." : ".$query."<br>".mysqli_error($link));
	if (mysqli_num_rows($result)) {
		
		$row = mysqli_fetch_row($result);
		$fields = mysqli_fetch_fields($result);
  
		for ($Ind = 0; $Ind < count($fields); $Ind++) {
			echo "<tr>";
			echo "<th class=tableau>".$fields[$Ind]->name."&nbsp&nbsp</th>";
			
			$mot = explode (" ", $row[$Ind]);
			$etat = $mot [0];
			switch ($etat) {
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
	
			echo "<td class=tableau width=420 bgcolor=".$bgcolor.">";
			echo "<font color=".$color.">";
			echo $row[$Ind];
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
function historique($link,$Objet,$idObjet,$Etat,$Description) {
	// OBJET: RFC, DT
	// TYPE
	// CR: Création
	// PL: Planification
	// MD: Modification + Description
	// EC: En cours (dans les créneaux de date OU au moins une DT en cours...)
	// AT: En attente (on arrête temporairement de décompter la typologie)
	// TE: Terminé
	// CL: Clos
	
	$Nom = $_SESSION["acteur"];
	$DateModif = date("Y/m/d H:i:s");
	while (1) {
		$stmt = mysqli_prepare($link, "insert into HISTORIQUE (DateModif, Objet, idobjet, Etat, Nom, Description) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssisss', $DateModif, $Objet, $idObjet, $Etat, $Nom, $Description);
		$res= $stmt->execute();
		mysqli_stmt_free_result($stmt);
		if ($res) break;
		$date = $DateModif;
		while (($DateModif = date("Y/m/d H:i:s")) == $date) {
			usleep (100);
		}
	}
}

// ********************************************************************************** 
function entete($titre, $test=FALSE) {
	$version = "2.1.1";
	
	// redirection vers la liste des acteurs
	if (!$test && !isset($_SESSION["acteur"])) {
		header("location: index.php");
		exit;
	}

	echo "<table class=bordure_bas>";

	// Colonne Image
	echo "<tr>";
	echo "<td width=101 height=51>";
//	echo "<img src='images/logo_little.gif'>";
	echo "<img src='images/Atos_new_logo.gif'>";
	echo "</td>";
	
	// Colonne Titre
	$fin_HREF = (isset($_SESSION["user"]) || isset($_SESSION["admin"]) ? "</A> - " : "<font color=#E0E0E0> - </font>");
	echo "<td nowrap>";
	echo "<font class=titre>";
	echo "<b>GESTION DES CHANGEMENTS</b> v".$version;
	echo "<br>";
	echo "<A TARGET='_top' HREF='affaire_liste.php' TITLE='Liste dea affaires'><B><font color=#F0B0B0>AFFAIRE</font></B></A>";
	if (isset($_SESSION["admin"]))
		echo " <A TARGET='_top' HREF='affaire_saisie.php' onClick='w=window.open(this.href, \"AffaireSaisie_Window\", \"width=700, height=550, left=0, top=0, scrollbars=1, resizable=1\"); w.document.close(); w.focus(); return false'><img src='./images/new.jpg' align=middle border=0 title='Nouvelle Affaire'></A>";
	echo " - <A TARGET='_top' HREF='dt_liste.php' TITLE='Liste dea DT'><B><font color=#000000>DT</font></B></A>";
	if (isset($_SESSION["admin"]))
		echo " <A TARGET='_top' HREF='#' ONCLICK = 'OpenSasieDtWindow (\"dt_saisie.php\")'><img src='./images/new.jpg' align=middle border=0 title='Nouvelle DT'></A>";
	if (isset($_SESSION["user"]))
		echo " - <A TARGET='_top' HREF='/para/index.php' target='_blank'><font color=#F0B0F0>EXPLOITATION</font></A>";
	/************/
	/* PLANNING */
	/************/
	$annee = date("Y");
	echo " - PLANNING (";
	//Planning journalier
	if (isset($_SESSION["user"]))
		echo "<A TARGET='_top' HREF='planning.php?type=jour&jour=".date("d")."&mois=".date("m")."&année=$annee'><font color=#B0C0B0>Journalier</font></A> - ";
	//Planning Hebdomadaire
	echo "<A TARGET='_top' HREF='planning.php?type=semaine&semaine=".date("W")."&année=$annee'><font color=#B0C0B0>Hebdomadaire</font></A>";
	if (isset($_SESSION["user"])) {
		//Planning Week End
//		echo " - <A TARGET='_top' HREF='planning.php?type=week_end&mois=".date("m")."&année=$annee'><font color=#B0C0B0>Week-End</font></A>";
		//Planning Mensuel
		echo " - <A TARGET='_top' HREF='planning.php?type=mois&mois=".date("m")."&année=$annee'><font color=#B0C0B0>Mensuel</font></A>";
		//Planning annuel
		echo " - <A TARGET='_top' HREF='planning.php?type=année'><font color=#B0C0B0>Annuel</font></A>";
		//Planning annuel glissant
		echo " - <A TARGET='_top' HREF='planning.php?type=année_glissante'><font color=#B0C0B0> Annuel glissant</font></A>";
	}
	echo ")";
	if (isset($_SESSION["user"])) {
		//Reporting
		echo " - <A TARGET='_top' HREF='reporting.php'><font color=#B0C0B0>REPORTING</font></A>";
		//PARAMETRES
		echo " - <A TARGET='_top' HREF='parametres.php'><font color=#C0C090>PARAMETRES</font></A>";
	}
	//Actions
	//echo "<A TARGET='_top' HREF='actions_liste.php'><font color=#C0C090>":"<font color=#E0E0E0>")."*</font></A>";
	echo "</font>";
	echo "<font class=normal><br>> ".$titre."</font>";
	echo "</td>";

	echo "<td valign=middle width=50 nowrap><A TARGET='_top' HREF='index.php?Disconnect'>Déconnexion</A></td>";

/*	echo "<td>";
	echo (isset($_SESSION["user"])?"<A TARGET='_top' HREF='../wiki/index.php/Accueil' target='_blank' title='Wiki'><img src='./images/36px-Wiki_letter_w.svg.png' border=0></A>":"");
	echo "</td>";*/
	
	echo "<td align=center width=50 nowrap>";
	setlocale(LC_TIME, "fr");	
	$jour    = ucfirst(strftime("%d"));
	$mois    = ucfirst(strftime("%B"));
	$année   = ucfirst(strftime("%Y"));
	$semaine = date("W");
	echo "<div title='Semaine ".$semaine."'><font size=4><b>".$jour."</b><br><font size=1 STYLE='text-decoration:overline'>".$mois."</font><br><font size=1><b>".$année."</div>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	if (isset($_SESSION["acteur"])) { lst_sessions(); }
}

// ********************************************************************************** 
function lst_sessions()
{
	if (isset($_SESSION["user"]))  $role="Acteur";
	if (isset($_SESSION["admin"])) $role="Admin";

	$dir_name = ini_get("session.save_path");
	$max_time = ini_get("session.gc_maxlifetime");
	$dir = opendir($dir_name); 

	list ($usec, $sec) = explode(" ", microtime());
	list ($zero, $usec) = explode(".", $usec);
	$tempfile = "$dir_name/tempfile_".$_SESSION["acteur"].$usec;

	while ($file_name = readdir($dir)) {
		$file = "$dir_name/$file_name";
		$difference = mktime() - filemtime($file); 
		if (!is_file($file) || ($difference >= $max_time)) continue;
		
		if (($buf = file_get_contents ($file)) == "") {
			//Cas où le file est locké, on ne peut pas lire directement le fichier avec "file_get_contents"
			//Il faut passer par une copie puis lire le fichier copié
			copy ($file, $tempfile);
			$buf = file_get_contents ($tempfile);
		}

		//Si le fichier ne contient pas de cahine "acteur" ==> RAF
		if (($pos_acteur = strpos ($buf, "acteur")) === false) continue;

		//La structure du buffeur est <acteur|s:xxx:"NomActeur";>
		$pos_pointVirgule = strpos ($buf, ";", $pos_acteur);
		if ($pos_pointVirgule === false) $pos_pointVirgule = strlen ($buf);
		$buf_acteur = substr ($buf, $pos_acteur, $pos_pointVirgule-$pos_acteur);

		list ($type, $lg, $acteur) = explode (":", $buf_acteur);
		// Supprimer les ""
		$acteur = substr ($acteur, 1, $lg);
		if (!isset ($acteurList ["$acteur"]))
			$acteurList ["$acteur"] = 1;
		else
			$acteurList ["$acteur"] ++;
	}
	closedir($dir);
	if (is_file($tempfile)) unlink ($tempfile);

	if (is_array  ($acteurList)) {
		ksort ($acteurList);
		$lst_connectés = '';
		$nbUtilisateur = 0;
		foreach ($acteurList as $acteur => $nb) {
			if ($lst_connectés != "") $lst_connectés .= ",";
			if ($acteur == $_SESSION["acteur"]) {
				if (isset($_SESSION["user"]))  $role="Acteur";
				if (isset($_SESSION["admin"])) $role="Admin";
				$aff = "<A HREF='index.php' title='Déconnexion'><B TITLE='$role'>$acteur".($nb == 1 ? "" : "($nb)")."</B></A>";
			}
			else
				$aff = "$acteur".($nb == 1 ? "" : "($nb)");
			$lst_connectés .= $aff;
			$nbUtilisateur += $nb;
		}
	}
	echo "<FONT CLASS=small>$nbUtilisateur utilisateur".($nbUtilisateur > 1 ? "s" : "")." connecté".($nbUtilisateur > 1 ? "s" : "")." : $lst_connectés</font>";
}   
 
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
function isJourFérié($yyyymmdd) {
	$année=substr($yyyymmdd,0,4);
    $jour = 3600*24;

//    $vendredi_saint     = $année."-".date("m",easter_date($année)- 2*$jour)."-".date("d",easter_date($année)- 2*$jour);
    $lundi_de_paques    = $année."-".date("m",easter_date($année)+ 1*$jour)."-".date("d",easter_date($année)+ 1*$jour);
    $jeudi_ascension    = $année."-".date("m",easter_date($année)+39*$jour)."-".date("d",easter_date($année)+39*$jour);
    $lundi_de_pentecote = $année."-".date("m",easter_date($année)+50*$jour)."-".date("d",easter_date($année)+50*$jour);

	return ($yyyymmdd==$année.'-01-01'  ||	// Jour de l'an
	        $yyyymmdd==$année.'-11-01'  ||	// Toussaint
	        $yyyymmdd==$année.'-11-11'  ||	// Armistice 14-18
	        $yyyymmdd==$année.'-08-15'  ||	// Assomption
	        $yyyymmdd==$année.'-05-01'  ||	// Fête du travail
	        $yyyymmdd==$année.'-05-08'  ||	// Armistice 39-45
	        $yyyymmdd==$année.'-07-14'  ||	// Fête nationale
	        $yyyymmdd==$année.'-12-25'  ||	// Noël
//			$yyyymmdd==$vendredi_saint  ||	// Vendredi Saint
			$yyyymmdd==$lundi_de_paques ||	// Lundi de Pâques
			$yyyymmdd==$jeudi_ascension ||	// Jeudi de l'Ascension
			$yyyymmdd==$lundi_de_pentecote	// Lundi de Pentecôte
			);
}	


//ECRIT PAR NANOGROM_OM 
//MODIFIE PAR AYTAC GUNTAC 
//LE 21/07/2006 
  
// ********************************************************************************** 
function mir__elapsed_days($date_debutCP, $date_finCP) { 
	$tDeb = explode("/", $date_debutCP); 
	$tFin = explode("/", $date_finCP); 

	$diff = mktime(0, 0, 0, $tFin[1], $tFin[0], $tFin[2]) - mktime(0, 0, 0, $tDeb[1], $tDeb[0], $tDeb[2]); 

	return(($diff / 86400)+1); 
} 
  
// SERVANT AU CALCUL DES JOURS OUVRABLES 
// Fonction retournant le nombre de jour fériés samedis et 
// dimanches entre 2 dates entrées en timestamp 
// ********************************************************************************** 
function mir__holidays($date_debutCP, $date_finCP,$valeur_retour) { 
	$tDeb = explode("/", $date_debutCP); 
	$tFin = explode("/", $date_finCP);   

	$timestampStart = mktime(0, 0, 0, $tDeb[1], $tDeb[0], $tDeb[2]);
	$timestampEnd = mktime(0, 0, 0, $tFin[1], $tFin[0], $tFin[2]); 

    // Initialisation de la date de début 
    $nbFerie = 0; 
    $nbFerie2 = 0; 
    while ($timestampStart <= $timestampEnd) 
    { 
            // Calul des samedis et dimanches 
            $jour_julien = unixtojd($timestampStart); 
            $jour_semaine = jddayofweek($jour_julien, 0); 
            if($jour_semaine == 0 || $jour_semaine == 6) 
            { 
             $nbFerie++;//Samedi (6) et dimanche (0) 
            } 
            else
            { 
     $jour = date("d", $timestampStart); 
     $mois = date("m", $timestampStart); 
        $annee = date("Y", $timestampStart); 
        
         // Définition des dates fériées fixes 
        if($jour == 01 && $mois == 01) $nbFerie2++; // 1er janvier 
        if($jour == 01 && $mois == 05) $nbFerie2++; // 1er mai 
        if($jour == 08 && $mois == 05) $nbFerie2++; // 5 mai 
        if($jour == 21 && $mois == 07) $nbFerie2++; // 21 juillet 
        if($jour == 15 && $mois == 08) $nbFerie2++; // 15 aout 
        if($jour == 01 && $mois == 11) $nbFerie2++; // 1 novembre 
        if($jour == 11 && $mois == 11) $nbFerie2++; // 11 novembre 
        if($jour == 25 && $mois == 12) $nbFerie2++; // 25 décembre 
  
         // Calcul du jour de Pâques 
         $date_paques = easter_date($annee); 
         $jour_paques = date("d", $date_paques); 
         $mois_paques = date("m", $date_paques); 
         if($jour_paques == $jour && $mois_paques == $mois) $nbFerie2++; 
         // Pâques 
         
         // Calcul du Lundi de Pâques (1er jour après Pâques)
         $date_paques = $date_paques + 86400; 
         $jour_paques = date("d", $date_paques); 
         $mois_paques = date("m", $date_paques); 
         if($jour_paques == $jour && $mois_paques == $mois) $nbFerie2++; 
         // Pâques 

         // Calcul du jour de l'Ascension (39ème jour après Pâques) 
   $date_ascension = $date_paques + (39 * 86400);
         $jour_ascension = date("d", $date_ascension); 
         $mois_ascension = date("m", $date_ascension); 
         if($jour_ascension == $jour && $mois_ascension == $mois) $nbFerie2++; 
         // Ascension 

         // Calcul du jour de la Pentecôte (49ème jour après Pâques) 
   $date_pentecote = $date_paques + (49 * 86400);
         $jour_pentecote = date("d", $date_pentecote); 
         $mois_pentecote = date("m", $date_pentecote); 
         if($jour_pentecote == $jour && $mois_pentecote == $mois) $nbFerie2++; 
         // Pentecote 
  
         // Calcul du Lundi de la Pentecôte (1er jour après Pentecôte) 
   $date_pentecote = $date_pentecote + (86400);
         $jour_pentecote = date("d", $date_pentecote); 
         $mois_pentecote = date("m", $date_pentecote); 
         if($jour_pentecote == $jour && $mois_pentecote == $mois) $nbFerie2++; 
         // Lundi de la Pentecôte 
  
            } 
  
            $timestampStart=$timestampStart+86400;
    } 
	switch ($valeur_retour) {
		case '1':
			return $nbFerie;
			break;
		case '2':
			return $nbFerie2;
			break;
		default:
			return $nbFerie+$nbFerie2; 
			break;
	}
}//Fin de la fonction


// ********************************************************************************** 
 function ora_tableau($conn,$query,$titre) {
   $stmt = oci_parse($conn,$query);
   $r = oci_execute($stmt,OCI_DEFAULT);
//   echo "<table border=1 align=center bordercolor=#B0C0B0 cellspacing=0 cellpadding=1 rules=cols>";
   
//   if ($titre) echo "<caption><font class=titre>".$titre."</font></caption>";

	tableau_coin_ouvrant($titre);
   
	echo "<table class=tableau>";
//   echo "<caption>".$titre.(isset($_COOKIE['affquery'])?"<br><font class=requete>".$query."</font></caption>":"")."</caption>";

   echo "<tr>";
   $ncols = oci_num_fields($stmt);
   for ($i = 1; $i <= $ncols; $i++) {
     $column_name = oci_field_name($stmt, $i);
//     $column_type = oci_field_type($stmt, $i);
//     $column_size = oci_field_size($stmt, $i);
     echo "<th class=tableau>";
     echo "<b>".$column_name."</b><br>";
     echo "</th>";
   }
   echo "</tr>";

   while ($row = oci_fetch_row($stmt)) {
     echo '<tr>';
     foreach ($row as $item) {
       echo "<td class=tableau>".($item?htmlentities($item):'&nbsp;')."</td>";
     }
     echo '</tr>';
   }
   echo '</table>';
   
	// Fin tableau
	tableau_coin_fermant('');
   
   
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
	   if ($boucle == 1 and $valeur != $selected) {$valeur = "<a HREF='".$_SERVER['PHP_SELF']."?tablespace=".$valeur."'>".$valeur."</A>";}
       echo "<td class=tableau>".$valeur."</td>";
     }
     echo '</tr>';
   }
   echo '</table>';
   echo '<br>';

   oci_free_statement($stmt);
 }
 
 // ============================================================================
function get_from_week($week,$year,$nbOfDay)
{
	// Remarque : 86400 = 60*60*24
	if(date("W",mktime(0,0,0,01,01,$year))==1)
		$mon_mktime = mktime(0,0,0,01,(01+(($week-1)*7)),$year);
	else
		$mon_mktime = mktime(0,0,0,01,(01+(($week)*7)),$year);

	if(date("N",$mon_mktime)>1) $decalage = ((date("N",$mon_mktime)-1)*60*60*24);
	$lun = $mon_mktime - $decalage;
	$mar = $lun + 86400;
	$mer = $mar + 86400;
	$jeu = $mer + 86400;
	$ven = $jeu + 86400;
	$sam = $ven + 86400;
	$dim = $sam + 86400;
	if ($nbOfDay == 7) 
		return array(date("Y-m-d",$lun),date("Y-m-d",$mar),date("Y-m-d",$mer),date("Y-m-d",$jeu),date("Y-m-d",$ven),date("Y-m-d",$sam),date("Y-m-d",$dim));
	else
		return array(date("Y-m-d",$lun),date("Y-m-d",$mar),date("Y-m-d",$mer),date("Y-m-d",$jeu),date("Y-m-d",$ven));
}

 // ============================================================================
function get_BgColor_Etat ($item)
{
	switch ($item) {
		case "MD": // 
			$bgcolor="#00AAAA"; $color="#FFFFFF"; break;
		case "CO": // 
			$bgcolor="#00AAAA"; $color="#FFFFFF"; break;
		case "AN": // Blanc sur fond Noir
			$bgcolor="#000000"; $color="#FFFFFF"; break;
		case "EC": // Vert Clair sur Fond vert sombre
			$bgcolor="#00AA00"; $color="#00FF00"; break;
		case "CL": // Blanc sur fond Gris
			$bgcolor="#AAAAAA"; $color="#FFFFFF"; break;
		case "PL": // Blanc sur fond Jaune
			$bgcolor="#AAAA00"; $color="#FFFFFF"; break;
		case "CR": // Noir sur fond Blanc
			$bgcolor="#FFFFFF"; $color="#000000"; break;
		case "AT": // Noir sur fond Gris
			$bgcolor="#DDDDDD"; $color="#000000"; break;
		case "VP": // Noir sur fond Gris
			$bgcolor="#DDDDDD"; $color="#000000"; break;
		case "TE": //  sur fond 
			$bgcolor="#AAAAEE"; $color="#000000"; break;
		default:
			$bgcolor=$color=""; //$light_color; 
		}
	return array($bgcolor, $color);
}

?>