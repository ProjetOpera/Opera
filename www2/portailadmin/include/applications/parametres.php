<?php


// INSERTION FICHIER AJOUT/MODIF/SUPPR EN BASE DE DONNEES
include("../".$line_tum['url_appli']."/include/applications/parametres_bdd.php");

$select_menu = "Selectionnez une application";
$var_ajout_param = "Ajouter un parametre";
$liste_libelles = "Libelles";
$liste_code_param = "Code";
$liste_val_int = "Valeur (INT)";
$liste_val_char = "Valeur (CHAR)";
$liste_val_date = "Valeur (DATE)";
$bouton_suppr = "Suppression";

// MISE EN VARIABLE DE ID APPLICATION
$var_appli = (isset($_GET['appli'])) ? $_GET['appli'] : "";


// LISTE DES APPLICATIONS ***************************
$sql_appli = "
	SELECT id,nom_appli
	FROM applications
	ORDER BY nom_appli";
$req_appli = $ressourceBDD_appli->query($sql_appli);

echo "$select_menu :&nbsp;&nbsp;&nbsp;";
echo "<select onchange='window.location.href = (\"index.php?id_menu=".$_GET['id_menu']."&appli=\"+this.value);'><option></option>";
while ($line_appli = $req_appli->fetch(PDO::FETCH_ASSOC)) {
	$selected = ($var_appli==$line_appli['id']) ? "selected='selected'": "" ; 
	echo "<option value='".$line_appli['id']."' $selected>".$line_appli['nom_appli']."</option>";
}
echo "</select><br /><br />";


if ($var_appli != "") {
	?>
		
	<a href="include/applications/parametres_gestion.php?type=ajout&id_menu=<?php echo $_GET['id_menu']; ?>&id_appli=<?php echo $var_appli; ?>" class="various1"><?php echo $var_ajout_param; ?></a>
	<br /><br />
	
	
	<table class='display_list2' cellpadding="0" cellspacing="0" border="0"><tbody>
	<tr class='table_line'>
		<td><?php echo $liste_code_param; ?></td>
		<td><?php echo $liste_val_int; ?></td>
		<td><?php echo $liste_val_char; ?></td>
		<td><?php echo $liste_val_date; ?></td>
		<td style='text-align:center;width:70px'></td>
	</tr>
	
	
	<?php
	$sql0 = "
		SELECT id, code_param, type_param, valeur_param_int, valeur_param_varchar, valeur_param_date
		FROM param_appli
		WHERE id_applications = $var_appli
		ORDER BY code_param";
	$req0 = $ressourceBDD_appli->query($sql0);
	
	$num=0;
	while ($line0 = $req0->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr class='line".(($num+1)%2)."'>";		
		echo "	<td><a class='various1' href='include/applications/parametres_gestion.php?type=modif&id_menu=".$_GET['id_menu']."&id_appli=".$var_appli."'>".$line0['code_param']."</a></td>";
		echo "	<td>".$line0['valeur_param_int']."</td>";
		echo "	<td>".$line0['valeur_param_varchar']."</td>";
		echo "	<td>".$line0['valeur_param_date']."</td>";
		echo "	<td><a class='delete'></a></td>";
		echo "</tr>";
		$num++;
	}
	?>
	
	</tbody></table>
	
<?php
}
?>