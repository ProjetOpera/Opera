<?php
/***********************************************************
*                                                          *
*   Module de définition de function d'affichage de debug  *
*                                                          *
************************************************************/

define ('DEBUG', '');

/*******************************************
*  Affichage de tableaux avec indentation  *
********************************************/
function print_array($s) {
	echo '<pre>';
	print_r ($s);
	echo '</pre>';
}

function debug(){
	if (!defined ('DEBUG')) return;
	$backtrace = debug_backtrace ();
?>
		<div style='text-align:left; background:lightgreen; border-color:blue; border-width:1px 1px 1px 1px;'> 
		<span style="color: #3366FF"><b><?php echo basename($backtrace[0]['file']).'</b> : Line <b>'.$backtrace[0]['line'] ?></b></span>
<?php
	if (($nb = count($backtrace[0]['args'])) % 2) {
?>
		<pre><span style="color: red">Erreur d'appel à debug </span>
		<span style="color: black">
	usage debug (nom_variable, valeur_variable[,nom_variable, valeur_variable, [..,..]]<BR/>
	Les argument de debug doivent être un couple (nom_variable, valeur_variable)
		</span></pre>
<?php
		return;
	}
	
	for ($i=0; $i < count($backtrace[0]['args']); $i++) {
		$nomvariable = $backtrace[0]['args'][$i++];
		$value = $backtrace[0]['args'][$i];
		if (isset($value)) {
			if(is_array($value))
				$chaine = '<B>'.$nomvariable.'</B> = '.print_r ($value, true);
			else if(is_bool($value))
				$chaine = '<B>'.$nomvariable.'</B> = (bool)"'.($value? 'true' : 'false').'"';
			else if(is_string($value))
				$chaine = '<B>'.$nomvariable.'</B> = (string('.strlen($value).'))"'.htmlentities($value).'"';
			else if(is_numeric($value))
				$chaine = '<B>'.$nomvariable.'</B> = (int)"'.$value.'"';
			else
				$chaine = '<B>'.$nomvariable.'</B> existe mais pas sûr de l\'afficher correctement. Sa valeur est '.print_r ($value, true);
?>
			<SPAN STYLE="COLOR: black"><PRE><?php echo $chaine?></PRE></SPAN>
<?php
		}
		else{
?>
			<br/><b><?php echo $nomvariable?> = <span style="color: red">NOT SET </span></b>
<?php
			// echo "<div class = 'debug'><b>La variable $".$nomvariable." n'est pas définie!<>/div>";
		}
	}
?>
	</div>
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