<?php

	//////////////
	// libelles //
	//////////////

	$ajout_categorie_text = "Ajouter";

	// libelle tableau app
	$tab_header_categorie_nom = "Nom";
	$tab_header_categorie_couleur = "Couleur";
	$tab_header_categorie_modifier = "Modifier";
	$tab_header_categorie_supprimer = "Supprimer";

	
	// Ajout Categorie
	$formAjoutCatFlag = (isset($_POST['formAjoutCatFlag']) && $_POST['formAjoutCatFlag']=="OK") ? true : false;
	if($formAjoutCatFlag==true)
	{
                $nom_ajoutcat=  $_POST['formAjoutCatNom'];
		$couleur_ajoutcat=$_POST['formAjoutCatCouleur'];
		$sql_ajoutCat = "INSERT INTO categories(nom_categorie,couleur_categorie) VALUES('".$nom_ajoutcat."','".$couleur_ajoutcat."')";
		$ressourceBDD_appli->query($sql_ajoutCat);
	}
	
	//Modif Categorie
	
	$formModifCatFlag = (isset($_POST['formModifCatFlag'])) ? $_POST['formModifCatFlag'] : false;
	if($formModifCatFlag!=false)
	{
		$nom_modifcat=  $_POST['formModifCatNom'];
		$couleur_modifcat=$_POST['formModifCatCouleur'];
		$sql_modifCat = "UPDATE categories SET nom_categorie='".$nom_modifcat."',couleur_categorie='".$couleur_modifcat."' WHERE id=".$formModifCatFlag;
		$ressourceBDD_appli->query($sql_modifCat);
	}
	
	
	// Suppression Categorie
	$formSupprCatConfirm = (isset($_POST['formSupprCatConfirm']) && $_POST['formSupprCatConfirm']!="") ? $_POST['formSupprCatConfirm'] : false;
	
	if($formSupprCatConfirm!=false)
	{
		$sql_supprCat = "DELETE FROM categories WHERE id='".$formSupprCatConfirm."'";
		$ressourceBDD_appli->query($sql_supprCat);
	}
	
	
	
	$sql_recup_cat="SELECT id,nom_categorie, couleur_categorie FROM categories";
	$result_recup_cat=$ressourceBDD_appli->query($sql_recup_cat);
	
	echo "<a class='various1' href='include/categories/Categories_Ajout.php'>+ ".$ajout_categorie_text."</a>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	echo "<table class='display_list2' cellpaddin=0 cellspacing=0 border=0>\n";
	
	echo "<tr class='table_line'>\n";
	echo "	<td>".$tab_header_categorie_nom."</td>\n";
	echo "	<td>".$tab_header_categorie_couleur."</td>\n";
	echo "	<td>".$tab_header_categorie_modifier."</td>\n";
	echo "	<td>".$tab_header_categorie_supprimer."</td>\n";
	echo "</tr>\n";
	
	
	$nb_line=0;
	while($row_recup_cat=$result_recup_cat->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr class='line".(($nb_line+1)%2)."'>\n";
		echo "	<td>".$row_recup_cat['nom_categorie']."</td>\n";
		echo "	<td style='color:#".$row_recup_cat['couleur_categorie'].";'>".$row_recup_cat['couleur_categorie']."</td>\n";
		echo "	<td><a class='various1 modify' href='include/categories/Categories_Modif.php?id=".$row_recup_cat['id']."'></a></td>\n";
		echo "	<td><a class='various1 delete' href='include/categories/Categories_Suppr.php?id=".$row_recup_cat['id']."'></a></td>\n";
		echo "</tr>\n";
		$nb_line++;
	}
	echo "</table>\n";
?>