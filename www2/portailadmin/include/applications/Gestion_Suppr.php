<?php

	// connexion base APPLIS
	// *******************************************************
	session_start();
	require_once("../../../portailv2/functions/functions.php");
	$ressourceBDD_appli = connexion_externe('../../../portailv2/');

	
	//////////////
	// libelles //
	//////////////

	$formSupprApp_text = "&Ecirc;tes-vous s&ucirc;r de vouloir supprimer cette application ?";
	$formSupprApp_text_oui = "Oui";
	$formSupprApp_text_non = "Non";
	$formSupprSubmit_text = "Valider";
	
	// ENTETE HTML
	header_top('');
?>

</head>

<body>
<div style='text-align: center'>
<?php
	$m=isset($_GET['m'])?$_GET['m']:1;
	$sm=isset($_GET['sm'])?$_GET['sm']:1;
	$ssm=isset($_GET['ssm'])?$_GET['ssm']:1;
	
	$id_app = mysql_escape_string($_GET['id']);
	echo "<form method='post' action=''>\n";

	echo "<p>".$formSupprApp_text."</p>\n";
	echo "<p>";
	echo "<input type='radio' name='formSupprApp' value='".$id_app."'>".$formSupprApp_text_oui;
	echo "<input type='radio' name='formSupprApp' value=''checked>".$formSupprApp_text_non;
	echo "</p>";
	echo "<input type='submit' value='".$formSupprSubmit_text."'/>\n";
	
	echo "</form>\n";
	
?>
</div>

</body>

</html>
