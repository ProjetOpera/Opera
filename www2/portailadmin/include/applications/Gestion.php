<?php

	//////////////
	// libelles //
	//////////////
	
	$lienAjoutApp="Ajouter";
	
	// libelle tableau app
	
	$tab_header_NomApp = "Nom";
	$tab_header_UrlApp = "Url";
	$tab_header_nom_InterneApp = "Interne";
	$tab_header_nom_ServeurApp = "Serveur base";
	$tab_header_type_ServeurApp = "Type base";
	$tab_header_nom_NomBaseApp = "Nom base";
	$tab_header_nom_IdentifiantApp = "Identifiant";
	$tab_header_nom_CategorieApp = "Categorie";
	$tab_header_modifier = "Modifier";
	$tab_header_supprimer = "Supprimer";
	
	///////////////
	// Ajout app //
	///////////////
	
	if ( 
		isset($_POST['formAjoutAppNom'])
		&& isset($_POST['formAjoutAppURL'])
		&& isset($_POST['formAjoutAppCategorie'])		
		&& isset($_POST['formAjoutAppServeur'])
		&& isset($_POST['formAjoutAppTypeServeur'])
		&& isset($_POST['formAjoutAppNomBase'])
		&& isset($_POST['formAjoutAppIdentifiant'])
		&& isset($_POST['formAjoutAppMotDePasse'])
	)
	{
	
		$insert_NomApp=mysql_escape_string($_POST['formAjoutAppNom']);
		$insert_UrlApp=mysql_escape_string($_POST['formAjoutAppURL']);
		$insert_CategorieApp=$_POST['formAjoutAppCategorie'];
		$insert_InterneApp= (isset($_POST['formAjoutAppInterne']))? 1 : 0; 
		$insert_ServeurApp=($insert_InterneApp == 1 ? mysql_escape_string($_POST['formAjoutAppServeur']) : "");
		$insert_TypeServeurApp=($insert_InterneApp == 1 ? mysql_escape_string($_POST['formAjoutAppTypeServeur']) : "");
		$insert_NomBaseApp=($insert_InterneApp == 1 ? mysql_escape_string($_POST['formAjoutAppNomBase']) : "");
		$insert_IdentifiantApp=($insert_InterneApp == 1 ? mysql_escape_string($_POST['formAjoutAppIdentifiant']) : "");
		$insert_MotDePasseApp=($insert_InterneApp == 1 ? mysql_escape_string($_POST['formAjoutAppMotDePasse']) : "");
		
		
		
		$sql_ajoutApp="INSERT INTO 
		applications(
			nom_appli,
			url_appli,
			interne,
			serveur_bdd,
			type_serveur_bdd,
			nom_bdd,
			user_bdd,
			password,
			id_categories
		) 
		VALUES(
			'".$insert_NomApp."',
			'".$insert_UrlApp."',
			'".$insert_InterneApp."',
			'".$insert_ServeurApp."',
			'".$insert_TypeServeurApp."',
			'".$insert_NomBaseApp."',
			'".$insert_IdentifiantApp."',
			'".$insert_MotDePasseApp."',
			'".$insert_CategorieApp."'		
		)";
		$ressourceBDD_appli->query($sql_ajoutApp);
	}
	///////////////
	// Modif app //
	///////////////
	
	if (
		isset($_POST['formModifAppId'])
		&& isset($_POST['formModifAppNom'])
		&& isset($_POST['formModifAppURL'])
		&& isset($_POST['formModifAppCategorie'])		
		&& isset($_POST['formModifAppServeur'])
		&& isset($_POST['formModifAppTypeServeur'])
		&& isset($_POST['formModifAppNomBase'])
		&& isset($_POST['formModifAppIdentifiant'])
		&& isset($_POST['formModifAppMotDePasse'])
	)
	{
		$update_IdApp=mysql_escape_string($_POST['formModifAppId']);
		$update_NomApp=mysql_escape_string($_POST['formModifAppNom']);
		$update_UrlApp=mysql_escape_string($_POST['formModifAppURL']);
		$update_CategorieApp=$_POST['formModifAppCategorie'];
		$update_InterneApp= (isset($_POST['formModifAppInterne']))? 1 : 0; 
		$update_ServeurApp= ($update_InterneApp == 1 ? mysql_escape_string($_POST['formModifAppServeur']) : "");
		$update_TypeServeurApp= ($update_InterneApp == 1 ? mysql_escape_string($_POST['formModifAppTypeServeur']) : "");;
		$update_NomBaseApp= ($update_InterneApp == 1 ? mysql_escape_string($_POST['formModifAppNomBase']) : "");
		$update_IdentifiantApp= ($update_InterneApp == 1 ? mysql_escape_string($_POST['formModifAppIdentifiant']) : "");
		$update_MotDePasseApp= ($update_InterneApp == 1 ? mysql_escape_string($_POST['formModifAppMotDePasse']) : "");
		$isModifyPwd = $_POST['isModifyPwd'];
		
		
		$update_pass=($isModifyPwd == 'true') ? "password='".$update_MotDePasseApp."'," : "";

		$sql_modifApp=" UPDATE applications
						SET nom_appli='".$update_NomApp."',
							url_appli='".$update_UrlApp."',
							interne='".$update_InterneApp."',
							serveur_bdd='".$update_ServeurApp."',
							type_serveur_bdd='".$update_TypeServeurApp."',
							nom_bdd='".$update_NomBaseApp."',
							user_bdd='".$update_IdentifiantApp."',
							".$update_pass."
							id_categories='".$update_CategorieApp."'
						WHERE id=".$update_IdApp;
		$ressourceBDD_appli->query($sql_modifApp);
	}
	
	///////////////
	// Suppr app //
	///////////////
	
	if(isset($_POST['formSupprApp']) && $_POST['formSupprApp']!="")
	{
		$delete_IdApp=$_POST['formSupprApp'];
		$sql_deleteApp="DELETE FROM applications WHERE id=".$delete_IdApp;
		$ressourceBDD_appli->query($sql_deleteApp);
	}
	
	///////////////////////////
	// Affichage tableau app //
	///////////////////////////
	
	$sql_recup_app="SELECT a.id, 
				a.nom_appli, 
				a.url_appli, 
				a.interne, 
				a.serveur_bdd, 
				a.type_serveur_bdd, 
				a.nom_bdd, 
				a.user_bdd, 
				c.nom_categorie
			FROM applications a, categories c
			WHERE	c.id=a.id_categories
			ORDER BY upper(a.nom_appli),upper(c.nom_categorie)";
	$result_recup_app = $ressourceBDD_appli->query($sql_recup_app);
	
	echo "<a class='various1' href='include/applications/Gestion_Ajout.php' >+ ".$lienAjoutApp."</a>";
	echo "<br/>\n";
	echo "<br/>\n";
	
	$contenu_tab_app = "";
	$nb_ligne=0;
	
	while ($row_recup_app = $result_recup_app->fetch(PDO::FETCH_ASSOC))
	{
		$recup_IdApp=$row_recup_app['id'];
		$recup_NomApp=  $row_recup_app['nom_appli'];
		$recup_UrlApp=$row_recup_app['url_appli'];
		$recup_InterneApp=$row_recup_app['interne'];
		$recup_ServeurApp=$row_recup_app['serveur_bdd'];
		$recup_TypeServeurApp=$row_recup_app['type_serveur_bdd'];
		$recup_NomBaseApp=$row_recup_app['nom_bdd'];
		$recup_UserApp=$row_recup_app['user_bdd'];
		$recup_CategorieNomApp=  $row_recup_app['nom_categorie'];
		
		$contenu_tab_app .= "<tr class='line".(($nb_ligne+1)%2)."'>\n";
			$contenu_tab_app .= "<td>".$recup_NomApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_UrlApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_CategorieNomApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_InterneApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_ServeurApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_TypeServeurApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_NomBaseApp."</td>\n";
			$contenu_tab_app .= "<td>".$recup_UserApp."</td>\n";
			$contenu_tab_app .= "<td><a class='various1 modify' href='include/applications/Gestion_Modif.php?id=".$recup_IdApp."'></a></td>\n";
			$contenu_tab_app .= "<td><a class='various1 delete' href='include/applications/Gestion_Suppr.php?id=".$recup_IdApp."'></a></td>\n";			
		$contenu_tab_app .= "</tr>\n";
		$nb_ligne++;
	}
	if($nb_ligne!=0)
	{	
		echo "<table class='display_list2' cellpadding=0 cellspacing=0 border=0>\n";
		
		echo "<tr class='table_line'>\n";
		
			echo "<td>".$tab_header_NomApp."</td>\n";
			echo "<td>".$tab_header_UrlApp."</td>\n";
			echo "<td>".$tab_header_nom_CategorieApp."</td>\n";
			echo "<td>".$tab_header_nom_InterneApp."</td>\n";
			echo "<td>".$tab_header_nom_ServeurApp."</td>\n";
			echo "<td>".$tab_header_type_ServeurApp."</td>\n";
			echo "<td>".$tab_header_nom_NomBaseApp."</td>\n";
			echo "<td>".$tab_header_nom_IdentifiantApp."</td>\n";
			echo "<td>".$tab_header_modifier."</td>\n";
			echo "<td>".$tab_header_supprimer."</td>\n";
			
		echo "</tr>\n";
		
		echo $contenu_tab_app;	
		
		echo "</table>\n";
	}


?>

