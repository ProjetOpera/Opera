<?php

	//////////////
	// libelles //
	//////////////
	
	$ajout_categorie_text="Ajouter";
	
	// header tab
	$header_colonne_groupe_nom = "Nom";
	$header_colonne_groupe_description = "Description";
	$header_colonne_groupe_suppression = "Supprimer";
	
	///////////////
	// fonctions //
	///////////////
	function creationTabGroupe($id_parent,$indent,$tiret)
	{
                global $ressourceBDD_appli;

		$sql2="SELECT id,nom,description FROM groupes WHERE id_parent='".$id_parent."' ORDER BY upper(nom)";
	
		$result2=$ressourceBDD_appli->query($sql2);
		
		$indent.="&nbsp&nbsp";
		$tiret.="-";
		while($row2=$result2->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr class='line1'>\n";

			echo "	<td>".$indent."|".$tiret." <a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=".$row2['id']."'>".$row2['nom']."</a></td>\n";
			echo "	<td>".$row2['description']."</td>\n";
			echo "	<td><a href='include/groupesusers/Gestion_Suppr.php?id=".$row2['id']."' class='delete various1'/></td>\n";
			
			echo "</tr>\n";
			creationTabGroupe($row2['id'],$indent,$tiret);
		}
	}
	
	/////////
	// BDD //
	/////////
	
	// ajout
	if(isset($_POST['formAjoutGroupeFlag']) && $_POST['formAjoutGroupeFlag']=="OK")
	{
		$nom = $_POST['formAjoutGroupeNom'];
		$description = $_POST['formAjoutGroupeDescription'];
		$parent = $_POST['formAjoutGroupeParent'];
		
		$sql_insert = "INSERT INTO groupes(nom,description,id_parent) VALUES ('".$nom."','".$description."','".$parent."')";
		$ressourceBDD_appli->query($sql_insert);
	}
	// modif
	if(isset($_POST['formModifGroupeFlag']))
	{
		$id = $_POST['formModifGroupeFlag'];
		$nom = $_POST['formModifGroupeNom'];
		$description = $_POST['formModifGroupeDescription'];
		$parent = $_POST['formModifGroupeParent'];
		
		$sql_update = "UPDATE groupes 
						SET nom='".$nom."',
							description='".$description."',
							id_parent='".$parent."'
						WHERE id='".$id."'";
		$ressourceBDD_appli->query($sql_update);
	}
	// suppr
	if(isset($_POST['formSupprGroupeRadio']) && $_POST['formSupprGroupeRadio']!="non")
	{
		$id = $_POST['formSupprGroupeRadio'];
		
		$sql_delete = "DELETE FROM groupes WHERE id='".$id."'";
		$ressourceBDD_appli->query($sql_delete);
	}
	
	// suppr
	
	
	
	///////////////////////
	// Affichage tableau //
	///////////////////////
	
	
	$sql1="SELECT id,nom,description FROM groupes WHERE id_parent='-1' ORDER BY upper(nom)";
	
	$result1=$ressourceBDD_appli->query($sql1);
	$indent="";
	$tiret="";

	echo "<a class='various1' href='include/groupesusers/Gestion_Ajout.php'>+ ".$ajout_categorie_text."</a>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	echo "<table class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
	
	echo "<tr class='table_line'>\n";

	echo "	<td>".$header_colonne_groupe_nom."</td>\n";
	echo "	<td>".$header_colonne_groupe_description."</td>\n";
	echo "	<td>".$header_colonne_groupe_suppression."</td>\n";
	
	echo "</tr>\n";
	
	
	while($row1=$result1->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr class='line0'>\n";

		echo "	<td><a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=".$row1['id']."'>".$row1['nom']."</a></td>\n";
		echo "	<td>".$row1['description']."</td>\n";
		echo "	<td><a href='include/groupesusers/Gestion_Suppr.php?id=".$row1['id']."' class='delete various1'/></td>\n";
		
		echo "</tr>\n";
		
		creationTabGroupe($row1['id'],$indent,$tiret);
	}

	echo "</table>\n"
?>