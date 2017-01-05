<?php

/////////////
// require //
/////////////

//require_once("../../connect.php");

//////////////
// libelles //
//////////////

$ajout_libelle_text = "Ajouter";

// libelle tableau app
$tab_header_code_libelle = "Code";
$tab_header_description_libelle = "Description";
$tab_header_valeur_libelle = "Valeur";

$tab_header_save_libelle = "Enregistrer";
$tab_header_suppr_libelle = "Supprimer";

// libelle form recherche
$form_recherche_lib_text = "Code";
$form_recherche_lib_button_text = "Rechercher";
$form_recherche_lib_alert = "Veuillez saisir un code";

// Supression libelles
//////////////////////

if(isset($_POST['form_suppr_lib_confirm']) && $_POST['form_suppr_lib_confirm']=="oui")
{
	$id_lib_suppr=$_POST['form_suppr_id'];
	$sql_suppr_lib="DELETE FROM libelles WHERE id='".$id_lib_suppr."'";
	$ressourceBDD_appli->query($sql_suppr_lib);
	$sql_suppr_lib_trad="DELETE FROM libelles_trad WHERE id_libelle='".$id_lib_suppr."'";
	$ressourceBDD_appli->query($sql_suppr_lib_trad);
}


// Recuperation des langues
///////////////////////////

// flag modif
$flag_modif_form=(isset($_POST['modif_flag_libelle']) && $_POST['modif_flag_libelle']=="OK") ? true : false;
// flag ajout
$flag_ajout_form=(isset($_POST['formAjoutLibelleFlag']) && $_POST['formAjoutLibelleFlag']=="OK") ? true : false;
// modification libelle (nom,description)
if($flag_modif_form==true)
{
	$modif_id_lib=mysql_escape_string($_POST['modif_id_libelle']);
	$modif_code_lib=  $_POST['modif_code_libelle'];
	$modif_desc_lib=  $_POST['modif_description_libelle'];
	
	$sql_modif_nom_description="UPDATE libelles SET code='".$modif_code_lib."', description='".$modif_desc_lib."' WHERE id='".$modif_id_lib."'";
	$ressourceBDD_appli->query($sql_modif_nom_description);
}


$lang=array();
$i=0;
$tab_header_valeur="";
$contenu_form_hidden="";
$contenu_js="";
$contenu_js2="";
$contenu_form_ajout="";

// Ajout libelle
if ($flag_ajout_form==true)
{
	$ajout_code_lib= $_POST['formAjoutLibelleCode'];
	$ajout_description_lib= $_POST['formAjoutLibelleDescription'];
	
	// ajout lib
	$sql_ajout_lib="INSERT INTO libelles(code,description) values('".$ajout_code_lib."','".$ajout_description_lib."')";
	$ressourceBDD_appli->query($sql_ajout_lib);
	
	// recup id lib ajout
	$sql_ajout_lib_recup_id="SELECT id FROM libelles WHERE code='".$ajout_code_lib."'";
	$result_ajout_lib_recup_id=$ressourceBDD_appli->query($sql_ajout_lib_recup_id);
	$ajout_lib_recup_id=$result_ajout_lib_recup_id->fetch(PDO::FETCH_COLUMN,0);	
}

$sql_recup_lang="SELECT id,value FROM lookup_values WHERE type='langue' ORDER BY upper(value)";
$result_recup_lang=$ressourceBDD_appli->query($sql_recup_lang);
while($row_recup_lang=$result_recup_lang->fetch(PDO::FETCH_BOTH))
{
	$lang[$i]=$row_recup_lang['value'];
	$tab_header_valeur.="<td>".$tab_header_valeur_libelle." (".$lang[$i].")</td>\n";
	
	// contenu_form_hidden
	$contenu_form_hidden.="<input id='modif_lang_id_libelle_".$lang[$i]."' name='modif_lang_id_libelle_".$lang[$i]."' type='hidden' value=''/>\n";
	$contenu_form_hidden.="<input id='modif_valeur_libelle_".$lang[$i]."' name='modif_valeur_libelle_".$lang[$i]."' type='hidden' value=''/>\n";

	// contenu js
	$contenu_js.= "document.getElementById('modif_lang_id_libelle_".$lang[$i]."').value = document.getElementById('formSauvLibelleValeur_id_".$lang[$i]."_'+num_form).value\n";
	$contenu_js.= "document.getElementById('modif_valeur_libelle_".$lang[$i]."').value = document.getElementById('formSauvLibelleValeur_".$lang[$i]."_'+num_form).value\n";
	
	// modification libelle (traduction)
	if($flag_modif_form==true)
	{
		$modif_id_lib_trad=mysql_escape_string($_POST['modif_lang_id_libelle_'.$lang[$i]]);
		$modif_valeur_lib=  mysql_escape_string($_POST['modif_valeur_libelle_'.$lang[$i]]);
		if($modif_id_lib_trad=="")
		{
			$sql_modif_valeur_no_ex="INSERT INTO libelles_trad(id_libelle,traduction,id_lookup_values) values('".$modif_id_lib."','".$modif_valeur_lib."','".$row_recup_lang['id']."')";
			$ressourceBDD_appli->query($sql_modif_valeur_no_ex);
		}
		else
		{
			$sql_modif_valeur_ex="UPDATE libelles_trad SET traduction='".$modif_valeur_lib."' WHERE id=".$modif_id_lib_trad;
			$ressourceBDD_appli->query($sql_modif_valeur_ex);
		
		}
	}
		
	// Ajout libelle (traduction)
	if ($flag_ajout_form==true && isset($_POST['formAjoutLibelleValeur_'.$lang[$i]]))
	{
		$ajout_val_lib=  $_POST['formAjoutLibelleValeur_'.$lang[$i]];
		$sql_ajout_valeur="INSERT INTO libelles_trad(id_libelle,traduction,id_lookup_values) values('".$ajout_lib_recup_id."','".$ajout_val_lib."','".$row_recup_lang['id']."')";
		$ressourceBDD_appli->query($sql_ajout_valeur);
	}	
	
	$i++;
} 




// Creation du tableau

$where_rech_code = (isset($_REQUEST['formRechLib_code'])) ? "WHERE code LIKE '%".mysql_escape_string($_POST['formRechLib_code'])."%' " : "";
$sql_recup_code="SELECT id,code,description FROM libelles ".$where_rech_code."ORDER BY upper(code)";

    
$result_recup_code=$ressourceBDD_appli->query($sql_recup_code);


$contenu_form_libelles_id="";
$contenu_tab_libelles = "";
$nb_ligne=0;
while($row_recup_code=$result_recup_code->fetch(PDO::FETCH_BOTH))
{
	$query = "SELECT DISTINCT nom_appli 
				FROM applications
				LEFT JOIN Menus on Menus.id_applications = applications.id
				WHERE Menus.code_libelle = {$row_recup_code['id']}";
	$result=$ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $sql_appli, $ressourceBDD_appli);
	
	if ($result->rowCount()) {
		$libelleUtiliseDans = "<b>Libell&eacute utilis&eacute dans les menus des applications suivantes :</b>";
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$libelleUtiliseDans .= "<br>- {$row['nom_appli']}";
		}
	}
	else {
		$libelleUtiliseDans = "<b>Libell&eacute; non utils&eacute;</b>";
	}
	$contenu_tab_libelles .= "<tr class='line".(($nb_ligne+1)%2)."'>\n";
	$contenu_tab_libelles .= "<td>\n";
	$contenu_tab_libelles .= "	<input id='formSauvLibelleId".$nb_ligne."' name='formSauvLibelleId".$nb_ligne."' type='hidden' value='".$row_recup_code['id']."'/>\n";
	$contenu_tab_libelles .= "	<input id='formSauvLibelleCode_".$nb_ligne."' name='formSauvLibelleCode_".$nb_ligne."' type='text' value='".$row_recup_code['code']."' onmouseover='montre(\"$libelleUtiliseDans\");' onmouseout='cache();'/></td>\n";
	$contenu_tab_libelles .= "</td>\n";
	$contenu_tab_libelles .= "<td><input id='formSauvLibelleDescription_".$nb_ligne."' name='formSauvLibelleDescription_".$nb_ligne."' type='text' value='".  $row_recup_code['description']."'/></td>\n";
		 
	for($j=0;$j<$i;$j++)
	{
		$sql_recup_libelle_trad="SELECT lt.id, lt.traduction 
								FROM libelles_trad lt, lookup_values lv 
								WHERE lv.value='".$lang[$j]."' 
									AND lt.id_libelle='".$row_recup_code['id']."' 
									AND lt.id_lookup_values=lv.id 
									AND lv.type='langue'";	
                
		$result_recup_libelle_trad=$ressourceBDD_appli->query($sql_recup_libelle_trad);
                $traduction=array();
                while ($l=$result_recup_libelle_trad->fetch(PDO::FETCH_ASSOC)){
                    $traduction[]=$l;
                }
		$nb_ligne_trad=$result_recup_libelle_trad->rowCount();
		if($nb_ligne_trad==0)
		{
			$contenu_tab_libelles .= "<td>\n";
			$contenu_tab_libelles .= "	<input id='formSauvLibelleValeur_id_".$lang[$j]."_".$nb_ligne."' name='formSauvLibelleValeur_id_".$lang[$j]."_".$nb_ligne."' type='hidden' value=''/>\n";
			$contenu_tab_libelles .= "	<input id='formSauvLibelleValeur_".$lang[$j]."_".$nb_ligne."' name='formSauvLibelleValeur_".$lang[$j]."_".$nb_ligne."' type='text' value=''/>\n";
			$contenu_tab_libelles .= "</td>\n";
		}
		else
		{
			$contenu_tab_libelles .=  "<td>\n";
			$contenu_tab_libelles .= "	<input id='formSauvLibelleValeur_id_".$lang[$j]."_".$nb_ligne."' na?e='formSauvLibelleValeur_id_".$lang[$j]."_".$nb_ligne."' type='hidden' value='".$traduction[0]['id']."'/>\n";
			$contenu_tab_libelles .= "	<input id='formSauvLibelleValeur_".$lang[$j]."_".$nb_ligne."' name='formSauvLibelleValeur_".$lang[$j]."_".$nb_ligne."' type='text' value='".$traduction[0]['traduction']."'/>\n";
			$contenu_tab_libelles .= "</td>\n";
		}
	}
	$contenu_tab_libelles .=  "<td><img src='../commun/images/save.png' onclick='init_form_sauv(".$nb_ligne.");'/></td>\n";
	$contenu_tab_libelles .=  "<td><a class='various1 delete' href='include/libelles/Libelles_Suppr.php?id=".$row_recup_code['id']."'></a></td>\n";
	
	$contenu_tab_libelles .= "</tr>\n";
	 
	$nb_ligne++;
} 



// formulaire recherche

$form_rech_code_value_POST = (isset($_POST['formRechLib_code'])) ? $_POST['formRechLib_code'] : "";
$form_rech_code_value_GET = (isset($_GET['formRechLib_code'])) ? $_GET['formRechLib_code'] : "";
$form_rech_code_value = ($form_rech_code_value_POST != "") ? $form_rech_code_value_POST: $form_rech_code_value_GET;
echo "<p>\n";
	echo "<form method='POST' action='' id='formRechLib' name='formRechLib'>\n";
	echo $form_recherche_lib_text." : <input id='formRechLib_code' name='formRechLib_code' type='text' value='".$form_rech_code_value."'/>\n";
	echo "<input onclick='verifRechLib();' type='button' value='".$form_recherche_lib_button_text."'/>\n";
	echo "</form>\n";
echo "</p>\n";

// lien ajout
echo "<a class='various1' href='include/libelles/Libelles_Ajout.php'>+ ".$ajout_libelle_text."</a>\n";
echo "<br/>\n";
echo "<br/>\n";
// form
echo "<form id='formLibelleSauv' name='formLibelleSauv'>\n";
// form hidden
echo $contenu_form_libelles_id;
//table
echo "<table class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
echo "<tr class='table_line'>\n";
echo "	<td>".$tab_header_code_libelle."</td>\n";
echo "	<td>".htmlentities($tab_header_description_libelle, ENT_QUOTES, "UTF-8")."</td>\n";
echo 	$tab_header_valeur;
echo "	<td>".$tab_header_save_libelle."</td>\n";
echo "	<td>".$tab_header_suppr_libelle."</td>\n";
echo "</tr>\n";

// modif
echo $contenu_tab_libelles;

echo "</table>\n";
echo "</form>\n";

echo "<form id='modif_form_libelle' name='modif_form_libelle' method='POST' action=''>\n";


echo "	<input id='modif_flag_libelle' name='modif_flag_libelle' type='hidden' value=''/>\n";
echo "	<input id='modif_id_libelle' name='modif_id_libelle' type='hidden' value=''/>\n";
echo "	<input id='modif_code_libelle' name='modif_code_libelle' type='hidden' value=''/>\n";
echo "	<input id='modif_description_libelle' name='modif_description_libelle' type='hidden' value=''/>\n";
echo $contenu_form_hidden;


echo "</form>\n";



?>
<!-- Pour affichage des infobulles -->
<div id='curseur' style='position:absolute; visibility:hidden; border:1px solid black; padding:10px; font:normal 8pt tahoma; background-color:#FFFFCC;'></div>

<script type='text/javascript'>

function init_form_sauv(num_form)
{
	document.getElementById('modif_flag_libelle').value = "OK";
	document.getElementById('modif_id_libelle').value = document.getElementById('formSauvLibelleId'+num_form).value;
	document.getElementById('modif_code_libelle').value = document.getElementById('formSauvLibelleCode_'+num_form).value;
	document.getElementById('modif_description_libelle').value = document.getElementById('formSauvLibelleDescription_'+num_form).value;
	<?php
		echo $contenu_js;
	?>
	document.getElementById('modif_form_libelle').submit();
}
function verifRechLib()
{
	if(document.getElementById('formRechLib_code').value=="")
	{
		alert('<?php echo $form_recherche_lib_alert; ?>');
	}
	else
	{
		document.getElementById('formRechLib').submit();
	}
}

/****************************************************/
/*            Pour affichage des InfoBulles         */
/****************************************************/

var visible=false; // Variable qui nous dit si la bulle est visible ou non
 
function montre(text) {
	if (text == '') return;
  if (visible==false) {
	  document.getElementById('curseur').style.visibility='visible'; // Si il est cache (la verif n'est qu'une securité) on le rend visible.
	  document.getElementById('curseur').innerHTML = text; // on copie notre texte dans l'élément html
	  visible=true;
  }
}

function cache() {
	if(visible==true) {
		document.getElementById('curseur').style.visibility='hidden'; // Si la bulle est visible on la cache
		visible=false;
	}
}

document.onmousemove=function(e) { // dès que la souris bouge, on appelle la fonction move pour mettre à jour la position de la bulle.
	if (visible) {  // Si la bulle est visible, on calcul en temps reel sa position ideale
		if (navigator.appName!='Microsoft Internet Explorer') { // Si on est pas sous IE
			document.getElementById('curseur').style.left=e.pageX + 5+'px';
			document.getElementById('curseur').style.top=e.pageY + 10+'px';
		}
		else { 
			e = window.event;
			if(document.documentElement.clientWidth>0) {
				document.getElementById('curseur').style.left=20+e.x+document.documentElement.scrollLeft+'px';
				document.getElementById('curseur').style.top=10+e.y+document.documentElement.scrollTop+'px';
			} 
			else {
				document.getElementById('curseur').style.left=20+e.x+document.body.scrollLeft+'px';
				document.getElementById('curseur').style.top=10+e.y+document.body.scrollTop+'px';
			}
		}
	}
}


</script>
































