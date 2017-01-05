<?php
$var_ajout_menu = "Ajouter un menu";
$select_menu = "Selectionnez une application";
$liste_libelles = "Libelles";
$liste_id_textuel = "Identifiant Textuel";
$liste_url = "URL";
$liste_level = "Niveau";
$liste_ordre = "Ordre";
$supprimer = "Supprimers";
$liste_default = "Page par d&eacute;faut";

// INSERTION FICHIER AJOUT/MODIF/SUPPR EN BASE DE DONNEES
include_once("menus_bdd.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/librairie.inc.php");
// require_once("{$_SERVER['DOCUMENT_ROOT']}/commun/inc/debug.inc.php");

// MISE EN VARIABLE DE ID APPLICATION
$var_appli = (isset($_GET['appli'])) ? $_GET['appli'] : "";
$id_menu = (isset($_GET['id_menu'])) ? $_GET['id_menu'] : $__commun_id_menu;


// LISTE DES APPLICATIONS *************************
$sql_appli = "
	SELECT id,nom_appli
	FROM applications
	ORDER BY nom_appli";
$req_appli = $ressourceBDD_appli->query($sql_appli) or ErrorPdo (__FILE__, __LINE__, $sql_appli, $ressourceBDD_appli);

?>
<?php echo $select_menu;?> :&nbsp;&nbsp;&nbsp;
<select onchange='window.location.href = ("id_menu=<?php echo $id_menu;?>&appli="+this.value);'>
<option></option>
<?php
while ($line_appli = $req_appli->fetch(PDO::FETCH_ASSOC)) {
	$selected = ($var_appli==$line_appli['id']) ? "selected='selected'": "" ; 
	echo "<option value='{$line_appli['id']}' ".($var_appli==$line_appli['id'] ? "selected='selected'": "").">{$line_appli['nom_appli']}</option>";
}
?>
</select>
<br />
<br />
<?php




// LISTE MENUS ************************************************
if ($var_appli != "") {
	
	
	function recursive_menu($id_parent,$indentation,$couleur,$ressourceBDD_appli) {
		
		global $var_appli;
		global $id_menu;
		$sql0 = "
			SELECT 	menus.id, 
					IF (menus.id_textuel = CONCAT('NULL', menus.id), '', menus.id_textuel) id_textuel,
					menus.url, 
					libelles_trad.traduction, 
					menus.ordre, 
					menus.parent, 
					menus.defaut, 
					level_access.level,
					libelles.code,
					libelles.description
			FROM menus, libelles, libelles_trad, applications, lookup_values, level_access
			WHERE   menus.code_libelle = libelles_trad.id_libelle
				AND menus.code_libelle = libelles.id
				AND applications.id = $var_appli
				AND menus.id_applications = applications.id
				AND libelles_trad.id_lookup_values = lookup_values.id
				AND lookup_values.value='FR'
				AND lookup_values.type='langue'
				AND parent= $id_parent
				AND id_level=level_access.id
			ORDER BY ordre";
		$req0 = $ressourceBDD_appli->query($sql0) or ErrorPdo (__FILE__, __LINE__, $sql0, $ressourceBDD_appli);
		
		while ($line0 = $req0->fetch(PDO::FETCH_ASSOC)) {
			$titre=
"<b>Code du libellé</b> : {$line0['code']}
<b>Description de libellé</b> : $chaine";
			$titre = str_replace("\r\n", "<BR>", $titre); //Remplacer CR-LF par <BR> si non infobulle ne marche pas !!!!
			$titre = str_replace("\\", "\\\\", $titre); //Escaper l'antislashsi non infobulle ne marche pas !!!!
			$titre = htmlentities($titre, ENT_QUOTES, 'UTF-8');

			// affichage menu
?>
			<tr class='<?php echo $couleur;?>'>
				<td><?php echo $indentation;?>&nbsp;|--&nbsp;&nbsp;<a href='include/applications/menus_gestion.php?type=modif&id=<?php echo $line0['id'];?>&id_appli=<?php echo $var_appli;?>&id_menu=<?php echo $_GET['id_menu'];?>' class='various1' onmouseover='montre("<?php echo $titre;?>");' onmouseout='cache();'><?php echo $line0['traduction'];?></a></td>
				<td><?php echo $line0['id_textuel'];?></td>
				<td><?php echo $line0['url'];?></td>
				<td><?php echo $line0['level'];?></td>
<?php
			// page par defaut
			$png = ($line0['defaut']==1) ? "star_yellow.png" : "star_grey.png" ;
?>
				<td style='text-align:center'><a href='include/applications/menus_defaut.php?id_menu=<?php echo $id_menu;?>&appli=<?php echo $var_appli;?>&id=<?php echo $line0['id'];?>'><img src='../../portailv2/images/<?php echo $png;?>' /></a></td>

				<td style='text-align:center'>
					<a class='desc' href='include/applications/menus_ordre.php?sens=1&id_menu=<?php echo $id_menu;?>&id=<?php echo $line0['id'];?>&appli=<?php echo $var_appli;?>&ordre=<?php echo ($line0['ordre']-1);?>&p=<?php echo $line0['parent'];?>'></a>
					<a class='asc' href='include/applications/menus_ordre.php?sens=-1&id_menu=<?php echo $id_menu;?>&id=<?php echo $line0['id'];?>&appli=<?php echo $var_appli;?>&ordre=<?php echo ($line0['ordre']+1);?>&p=<?php echo $line0['parent'];?>'></a>
				</td>
				<td><a class='delete various1' style='margin-left:20px' href='include/applications/menus_gestion.php?type=suppr&id=<?php echo $line0['id'];?>&appli=<?php echo $_GET['appli'];?>'></a></td>
			</tr>
<?php
			recursive_menu($line0['id'],$indentation.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','line1',$ressourceBDD_appli);
		}
	}

?>
	<a href="include/applications/menus_gestion.php?type=ajout&id_menu=<?php echo $_GET['id_menu']; ?>&id_appli=<?php echo $var_appli; ?>" class="various1"><?php echo $var_ajout_menu; ?></a>
	<br /><br />
	
	
	<table class='display_list2' cellpadding="0" cellspacing="0" border="0"><tbody>
	<tr class='table_line'>
		<td><?php echo $liste_libelles; ?></td>
		<td><?php echo $liste_id_textuel; ?></td>
		<td><?php echo $liste_url; ?></td>
		<td><?php echo $liste_level; ?></td>
		<td style='text-align:center;width:90px;'><?php echo $liste_default; ?></td>
		<td style='width:60px;'>&nbsp;<?php echo $liste_ordre; ?></td>
		<td style='text-align:center;width:70px'></td>
	</tr>
	
<?php	
	recursive_menu(-1,'','line0',$ressourceBDD_appli);
}
?>	
	
	

</tbody></table>

<!-- Pour affichage des infobulles -->
<div id='curseur' style='position:absolute; visibility:hidden; border:1px solid black; padding:10px; font:normal 8pt tahoma; background-color:#FFFFCC;'></div>

<script type="text/javascript">
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
