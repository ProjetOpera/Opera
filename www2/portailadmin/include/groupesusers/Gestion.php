<?php
	/**********************************************************
	 * Session_start() et les "require_once" ci-dessous       *
	 * sont necessairepour l'appel de JAVAX                   *
	 **********************************************************/
	session_start();
	require_once("{$_SERVER[DOCUMENT_ROOT]}/portailv2/functions/functions.php");
	require_once("{$_SERVER[DOCUMENT_ROOT]}/portailadmin/variables_".$_SESSION['PORTAIL\lang'].".php");
	require_once("{$_SERVER[DOCUMENT_ROOT]}/portailadmin/variables.php");
	require_once("{$_SERVER[DOCUMENT_ROOT]}/commun/inc/librairie.inc.php");
	// require_once("{$_SERVER[DOCUMENT_ROOT]}/commun/inc/debug.inc.php");

	//////////////
	// libelles //
	//////////////
	
	$ajout_groupe_text="Ajouter un groupe...";
	$ajout_level_text="Ajouter un niveau d'accès...";
	$ajout_utilisateur_text="Ajouter un utilisateur...";
	
	// header tab
	$header_colonne_suppression = "Supprimer";
	//--groupes--
	$header_colonne_groupe_nom = "Nom";
	$header_colonne_groupe_description = "Description";
	//--levels--
	$header_colonne_niveau = "Niveau";
	$header_colonne_niveau_description ="Description";
	//--utilisateurs--
	$header_colonne_login="Login";
	$header_colonne_nom="Nom";
	$header_colonne_prenom="Prénom";
	
	///////////////
	// fonctions //
	///////////////
	
	function creationTabGroupe($id_parent,$indent)
	{
		global $ressourceBDD_appli, $__commun_id_menu;
		$sql2="SELECT g.id,g.nom,g.description 
				FROM groupes g, associations_groupes ag
				WHERE ag.id_groupe_parent='".$id_parent."' 
					AND ag.id_groupe=g.id
				ORDER BY upper(nom)";
	
		$result2=$ressourceBDD_appli->query($sql2);
		
		$indent.="&nbsp&nbsp";
		while($row2=$result2->fetch(PDO::FETCH_ASSOC))
		{
?>
			<tr class='line1'>

				<td><?php echo $indent;?>&nbsp;|--&nbsp;&nbsp;<a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=<?php echo $row2['id'];?>&id_menu=<?php echo $__commun_id_menu;?>'><?php echo $row2['nom'];?></a></td>
				<td STYLE="PADDING-LEFT:5px;PADDING-RIGHT:5px;"><?php echo htmlspecialchars($row2['description'], ENT_QUOTES, "UTF-8");?></td>
				<td><a href='include/groupesusers/Gestion_Suppr.php?id=<?php echo $row2['id'];?>&id_menu=<?php echo $__commun_id_menu;?>' class='delete various1' /></td>
				<td STYLE="PADDING-RIGHT:10px;"><a href='javascript:listeGroupe(<?php echo $row2['id'];?>)'>info</a></td>
			</tr>
<?php
			creationTabGroupe($row2['id'],$indent.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		}
	}
		
//*********************************************************************************************************************************************************************************************************************************		

	/********************
	 *     Appel JAVAX  *
	 ********************/
	if (isset($_POST['InfoGroupe'])) {
		$ressourceBDD_appli = connexion_externe("{$_SERVER[DOCUMENT_ROOT]}/portailv2/");
		
		$id=$_POST['idGroupe'];
		if ( empty($id) ) { return; }

		//Rechercher le nom du groupe
		$query="SELECT 	Groupes.nom nom_groupe
				  FROM  Groupes
				  WHERE Groupes.id = $id";

		$result = $ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
		$line = $result->fetch(PDO::FETCH_ASSOC);
?>
		<fieldset style='FLOAT:left; margin-bottom:10px; margin-left:20px; padding:10px'> <legend>Applications du groupe <SPAN STYLE="COLOR:red;"><B><?php echo $line['nom_groupe'];?></B></legend>
	<!--	<table STYLE="float:left; BORDER-WIDTH:0px; BORDER-COLLAPSE:Separate; Padding:10px">
		<TR>
		<TD>-->
		<table class='display_list2' cellpadding='0' cellspacing='0' border='0'>
<?php
		//Rechercher les applications et le niveau d'acces du groupe
		$query="SELECT 	Applications.nom_appli,
						Level_Access.level level
				  FROM  Group_Has_Level_Acces
				  LEFT JOIN Groupes ON Groupes.id = Group_Has_Level_Acces.id_groupes
				  LEFT JOIN Applications ON Applications.id = Group_Has_Level_Acces.id_applications
				  LEFT JOIN Level_Access ON Level_Access.id = Group_Has_Level_Acces.id_level_access
				  WHERE Groupes.id = $id AND Applications.id IS NOT NULL
				  ORDER BY Applications.nom_appli";

		$result = $ressourceBDD_appli->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
		if ($result->rowCount() == 0) {
?>
			<tr>
				<td COLSPAN=2 STYLE="TEXT-ALIGN:Center;"><?php echo $label_aucuneApplication;?></td>
			</tr>
<?php
		}
		else {
?>
			<tr class='table_line'>
			<td>Application</td>
			<td STYLE="PADDING-LEFT:5px;PADDING-RIGHT:5px;"><?php echo $label_level_acces;?></td>
			</tr>
<?php
			for ($i = 1; $line = $result->fetch(PDO::FETCH_ASSOC); $i++) {
?>
				<tr class="line<?php echo ($i%2);?>">
				<td><?php echo $line['nom_appli'];?></td>
				<td STYLE="text-align:center; PADDING-LEFT:5px;PADDING-RIGHT:5px;"><?php echo $line['level'];?></td>
				</tr>
<?php
			}
		}
		$result->closeCursor();
?>
		</table>
		</fieldset>
<?php
	}
	else {
		/**************************************
		 * Affichage tableau niveau d'acces	  *
		 **************************************/
?>
		<!--lien ajout d'un groupe -->
		<DIV STYLE="display:block;">
		<fieldset style='float:left; margin-bottom:10px; margin-left:20px; padding:10px'> <legend>Niveau d'accès</legend>
		<a class='various1' href='include/groupesusers/Gestion_Ajout_level.php?id_menu=<?php echo $__commun_id_menu;?>'>+ <?php echo $ajout_level_text;?></a>
		<br/>
		<br/>
		<!-- tableau -->
		<table class='display_list2' cellpadding='0' cellspacing='0' border='0'>
		<tbody>
		<tr class='table_line'>
			<td><?php echo $header_colonne_niveau;?></td>
			<td STYLE="padding-left:5px;padding-right:5px;"><?php echo $header_colonne_niveau_description;?></td>
			<td STYLE='text-align:center; padding-right:10px;'><?php echo $header_colonne_suppression;?></td>
		</tr>
<?php
		$req_niveau_acces = "select id, level, description from level_access";
		$result_level_access = $ressourceBDD_appli->query($req_niveau_acces) or ErrorPdo (__FILE__, __LINE__, $req_niveau_acces, $ressourceBDD_appli);
		for ($num=1; $row = $result_level_access->fetch(PDO::FETCH_ASSOC); $num++) {
?>
		<tr class='line".($num%2)."'>
			<td><?php echo $row['level'];?></td>
			<td STYLE="PADDING-LEFT:5px;PADDING-RIGHT:5px;"><?php echo $row['description'];?></td>
			<td STYLE="PADDING-RIGHT:10px;"><a href='include/groupesusers/Gestion_Suppr_level.php?id=<?php echo $row['id'];?>id_menu=<?php echo $__commun_id_menu;?>' class='delete various1'/></td>
			</tr>
<?php
			
			}
		$result_level_access->closeCursor();
?>
		</tbody>
		</table>
		</fieldset>
	<!--*********************************************
		** Affichage tableau groupe d'utilisateurs **
		********************************************* -->

		<!-- lien ajout d'un groupe -->
			<fieldset STYLE='float:left; margin-bottom:10px; margin-left:20px; padding:10px'> <legend>Groupes d'utilisateurs</legend>
			<a class='various1' href='include/groupesusers/Gestion_Ajout.php?id_menu=<?php echo $__commun_id_menu;?>'>+ <?php echo $ajout_groupe_text;?></a>
			<br/>
			<br/>

			<!-- tableau contenat les groupes -->
			<table class='display_list2' STYLE="float:left; border-width: 0px; border-collapse: Collapse; Padding:0px">
			
			<tr class='table_line'>
				<td><?php echo $header_colonne_groupe_nom;?></td>
				<td STYLE="padding-left:5px;padding-right:5px;"><?php echo $header_colonne_groupe_description;?></td>
				<td STYLE='text-align: center'><?php echo $header_colonne_suppression;?></td>
				<TD></TD>
			</tr>
<?php
		$sql1="SELECT g.id,g.nom,g.description 
				FROM groupes g
				WHERE NOT EXISTS
				(
					SELECT 1 
					FROM associations_groupes ag
					WHERE ag.id_groupe=g.id	
				)
				ORDER BY upper(g.nom)
		";
		
		
		$result1=$ressourceBDD_appli->query($sql1) or ErrorPdo (__FILE__, __LINE__, $sql1, $ressourceBDD_appli);
		$indent="";

		for ($num=1; $row1=$result1->fetch(PDO::FETCH_ASSOC); $num++)
		{
	?>
			<tr class='line<?php echo ($num%2);?>'>

				<td><a class='various1'  href='include/groupesusers/Gestion_Modif.php?id=<?php echo $row1['id'];?>&id_menu=<?php echo $__commun_id_menu;?>'><?php echo $row1['nom'];?></a></td>
				<td STYLE="padding-left:5px;padding-right:5px;"><?php echo htmlspecialchars($row1['description'], ENT_QUOTES, "UTF-8");?></td>
				<td><a href='include/groupesusers/Gestion_Suppr.php?id=<?php echo $row1['id'];?>&id_menu=<?php echo $__commun_id_menu;?>' class='delete various1'/></td>
				<td STYLE="padding-right: 10px; margin-rigth: 10px"><a href='javascript:listeGroupe(<?php echo $row1['id'];?>)'>info</a></td>

			</tr>
<?php
			creationTabGroupe($row1['id'],$indent);
		}
		$result1->closeCursor();
?>
			</TABLE>
			</fieldset>
			<DIV id='ListGroupe'></DIV>
		</DIV>

		<SCRIPT TYPE="text/javascript">
			function listeGroupe(id)
			{
				var xhr_object = null; 
			 
				if(window.XMLHttpRequest) // Firefox 
					xhr_object = new XMLHttpRequest(); 
				else if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
					alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
					return; 
				} 
				 
				xhr_object.open("POST", "include/groupesusers/Gestion.php", true); 
				
				xhr_object.onreadystatechange = function() { 
					if(xhr_object.readyState == 4) {
						document.getElementById("ListGroupe").innerHTML=xhr_object.responseText;
					}
				} 
				
								
				xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
				var data = "InfoGroupe=1&idGroupe="+id; 
				xhr_object.send(data);
			}
		</SCRIPT>
<?php
	}
?>
