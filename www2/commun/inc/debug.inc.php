<?php
/***********************************************************
*                                                          *
*   Module de définition de function d'affichage de debug  *
*                                                          *
************************************************************/

// define ('DEBUG', '');

/*******************************************
*  Affichage de tableaux avec indentation  *
********************************************/
function print_array($s) {
	echo '<pre>';
	print_r ($s);
	echo '</pre>';
}

/*****************************************
*  Affichage de le contenu d'un tableau  *
******************************************
*  Appel :                               *
*    debug (arg1, arg2, ...)             *
*******************************************
*/
function debug(){
	if (!defined ('DEBUG')) return;
	$backtrace = debug_backtrace ();
?>
		<DIV STYLE='TEXT-ALIGN:left; BACKGROUND:lightgreen; BORDER-COLOR:blue; BORDER-WIDTH:1px 1px 1px 1px;'> 
		<SPAN STYLE="COLOR: #3366FF"><B><?php echo basename($backtrace[0]['file']).'</b> : Line <b>'.$backtrace[0]['line'] ?></b></SPAN>
<?php
	if (($nb = count($backtrace[0]['args'])) % 2) {
?>
		<PRE><SPAN STYLE="COLOR: red">Erreur d'appel à debug </SPAN>
		<SPAN STYLE="COLOR: black">
	usage debug (nom_variable, valeur_variable[,nom_variable, valeur_variable, [..,..]]<BR>
	Les argument de debug doivent être un couple (nom_variable, valeur_variable)
		</SPAN></PRE>
<?php
		return;
	}
	
	for ($i=0; $i < count($backtrace[0]['args']); $i++) {
		$nomvariable = $backtrace[0]['args'][$i++];
		$value = $backtrace[0]['args'][$i];
		if (isset($value)) {
			$chaine = "<B>$nomvariable</B> = ";
			if (is_array($value))
				$chaine .= print_r ($value, true);
			else if(is_bool($value))
				$chaine .= '(bool)"'.($value? 'true' : 'false').'"';
			else if(is_string($value))
				$chaine .= '(string('.strlen($value).'))"'.$value.'"';
			else if(is_numeric($value))
				$chaine .= '(int)"'.$value.'"';
			else
				$chaine .= print_r ($value, true);
?>
			<SPAN STYLE="COLOR: black"><PRE><?php echo $chaine?></PRE></SPAN>
<?php
		}
		else{
?>
			<BR><B>$<?php echo $nomvariable?> = <SPAN STYLE="COLOR: red">NOT SET </B></SPAN>
<?php
			// echo "<div class = 'debug'><b>La variable $".$nomvariable." n'est pas définie!<>/div>";
		}
	}
?>
	</DIV>
<?php
}

/********************************************
*  Affichage du stack d'appel de fonctions  *
*********************************************/
function debug_stack () {
	if (!defined ('DEBUG')) return;
	echo '<br><SPAN STYLE="COLOR: #3366FF">Debug <b>BackTrace (stack pointer)</b></SPAN>';
	print_array(debug_backtrace());
	echo '<br>';
}

/*****************************
*  Fin d'exéctuion si DEBUG  *
******************************
* Appel : debug_exit         *
******************************/
function debug_exit () {
	if (!defined ('DEBUG')) return;
	$backtrace = debug_backtrace ();
	echo '<br><SPAN STYLE="COLOR: #3366FF"><b>Exit called at <B>'.basename($backtrace[0]['file']).' : '.$backtrace[0]['line'].'</b></SPAN>';
	exit;
}


?>