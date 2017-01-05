<!---------------------------------------script pour autocompletion des champs de recherche--------------------------------------------------------->
<script type='text/javascript'>
	$(document).ready(function()
	{
      $( 'input#equipe').autocomplete(
	  {
          source: 'include/commun/chercher_equipe.php',
          minLength: 2,
		  select: function(event, ui) 
		  { 
			post_formulaire("RECHERCHER_EQUIPE","equipe","exact",ui.item.label); 
		  }
	});
	  
	});
	
	$(document).ready(function()
	{
      $( 'input#contact').autocomplete(
	  {
          source: 'include/commun/chercher_contact.php',
          minLength: 2,
		  select: function(event, ui) 
		  { 
			document.getElementById('id_collaborateur').value = ui.item.id; 
		  }		  
	});
	  
	});	
	
	function post_formulaire(action,champ,recherche,valeur)
	{
		document.getElementById('action').value = action;
		document.getElementById('champ').value = champ;
		document.getElementById('recherche').value = recherche;
		
		if ( action == "RECHERCHER_EQUIPE" && valeur != "" )
		{
			document.getElementById("equipe").value=valeur;
		}
		document.getElementById('formulaire_recherche').submit();
	}
	
	function afficher_message(message,type)
	{
		if ( message != "")
		{
			classe="message_"+type;
			$("#zone_message").attr("class", classe);
			$("#zone_message").html(message);
			$("#zone_message").animate({opacity: 1.0}, 5000).fadeOut();
		}
	}
	
	function  detruire_equipe(id)
	{
		nom_equipe = document.getElementById('nom_equipe').value;
		reponse = confirm("!!! Voulez-vous vraiment supprimer l'équipe " + nom_equipe + " ? !!!");
		if ( reponse )
		{
			document.getElementById('action_saisie').value = "DETRUIRE_EQUIPE";
			document.getElementById('formulaire_saisie').submit();
		}
	}
	
	function  ajouter_membre_equipe(id)
	{
		contact = document.getElementById('contact').value;
		id = document.getElementById('id_collaborateur').value;
		nom_equipe = document.getElementById('nom_equipe').value;
			if (contact == "")
				{ alert("Merci de spécifier un collaborateur avant de l'ajouter à l'équipe !");
				return false;
				}
			if (id == "")
				{ alert("Ce collaborateur n'existe pas !");
				return false;
				}				
		reponse = confirm("Voulez-vous vraiment ajouter " + contact + " à l'équipe " + nom_equipe + " ?");
		if ( reponse )
		{
			document.getElementById('action_saisie').value = "AJOUTER_MEMBRE_EQUIPE";
			document.getElementById('formulaire_saisie').submit();
		}
	}	
	
	function detail_equipe(equipe)
	{
		document.getElementById('equipe').value = equipe;
		post_formulaire('RECHERCHER_EQUIPE','equipe','regex','')
	}
	
	function tous_les_equipes()
	{
		document.getElementById('equipe').value = "";
		post_formulaire('','','','');
	}
	
</script>


<style>
	.message_erreur
	{
		padding:10px;
		background-color:red;
		color : white;
		margin : 5px auto;
		text-align : center;
		width : 50%;
	}
	.message_ok
	{
		padding:10px;
		background-color:green;
		color : white;
		margin : 5px auto;
		text-align : center;
		width : 50%;
	}
	
	.message_warning
	{
		padding:10px;
		background-color:orange;
		color : white;
		margin : 5px auto;
		text-align : center;
		width : 50%;
	}
</style>
<div id="zone_message"></div>
<?php
include_once '../portailadmin/variables_' . $_SESSION['PORTAIL\lang'] . '.php';

$search_title_equipe="Equipe";
$search_button="Rechercher";
$nouveau_equipe_button="Nouvelle équipe";
$detruire_equipe_button="Supprimer l'équipe";
$ajouter_membre_equipe="Ajouter à l'équipe";
$tous_les_equipes_button="Toutes les équipes";
$message_erreur_equipe_existant="Une équipe avec ce login '%login_equipe%' existe déjà !!!";
$message_info_manquantes="Tous les champs précédés d'un * doivent être renseignés et les adresses email dans un format valide !!!";
$message_equipe_maj="L'équipe a été mis à jour";
$message_equipe_creer="L'équipe a été créée";
$message_equipe_supprimer="L'équipe a été supprimée !!!";
$membre_ajoute="Le membre a été ajouté à l'équipe";
$libelle_maj_equipe="Mettre à jour";
$libelle_creer_equipe="Créer";
$libelle_nom_equipe="Nom";
$libelle_bal_equipe="Bal";
$collaborateur="Collaborateur";

//var_dump($_REQUEST);


/**************** F O N C T I O N S ***************************/


function nbsp($texte)
{
	return ( empty($texte) ? "&nbsp;" : $texte);
}

function email_valide($email)
{
	return (filter_var($email, FILTER_VALIDATE_EMAIL)); 

}

/******************* P A R A M E T R E S  E N  E N T R E E S *********************/

$action=isset($_REQUEST["action"])?trim($_REQUEST["action"]):"";
$action_saisie=isset($_REQUEST["action_saisie"])?trim($_REQUEST["action_saisie"]):$action;
$id_equipe=isset($_REQUEST["id_equipe"])?trim($_REQUEST["id_equipe"]):-1;
$nom_equipe=isset($_REQUEST["nom_equipe"])?trim($_REQUEST["nom_equipe"]):"";
$bal_equipe=isset($_REQUEST["bal_equipe"])?trim($_REQUEST["bal_equipe"]):"";
$id_collaborateur=isset($_REQUEST["id_collaborateur"])?trim($_REQUEST["id_collaborateur"]):"";

if ( empty($nom_equipe))
{
	$equipe=isset($_REQUEST["equipe"])?$_REQUEST["equipe"]:"";
}
else
{
	$equipe=$nom_equipe;
}

$libelle_action = "libelle_maj_equipe";


/******************* T R A I T E M E N T S   E N   B A S E   D E   D O N N E E S  *********************/

switch ( $action_saisie )
{	
	case "MAJ_EQUIPE":
						
						if ( 	!empty($id_equipe) 
								&& 
								is_numeric($id_equipe) 
								&&
								!empty($nom_equipe)
								&&
								(empty($bal_equipe) || email_valide($bal_equipe))
							)
						{						

							//on verifie que le nom d'équipe n'existe par pour un autre id de equipe
							$req_verif = "select count(1) nb from commun.equipe where nom_equipe = ? and id_equipe != ?";
							$stmt_verif = $ressourceBDD_appli->prepare($req_verif);
							$stmt_verif->bindParam(1,$nom_equipe,PDO::PARAM_STR);
							$stmt_verif->bindParam(2,$id_equipe,PDO::PARAM_INT);
							$stmt_verif->execute();
							$verif = $stmt_verif->fetchAll(PDO::FETCH_ASSOC);
							if ( $verif[0]["nb"] == 0 )
							{
								//on peut faire l'update
								
								$req_update=
								"
									update commun.equipe
									set 
										nom_equipe = upper(?),
										bal_equipe = lower(?),
										synchro_date = now()
									where id_equipe = ?
								";
								$stmt_update = $ressourceBDD_appli->prepare($req_update);
								$stmt_update->bindParam(1,$nom_equipe,PDO::PARAM_STR);
								$stmt_update->bindParam(2,$bal_equipe,PDO::PARAM_STR);
								$stmt_update->bindParam(3,$id_equipe,PDO::PARAM_INT);
								$stmt_update->execute() or ErrorPdo (__FILE__, __LINE__, $req_update, $stmt_update);
								
								echo "<script>afficher_message(\"".$message_equipe_maj."\",\"ok\");</script>";
							
								
							}
							else
							{
								echo "<script>afficher_message(\"".str_replace("%login_equipe%",$login_equipe,$message_erreur_login_existant)."\",\"erreur\");</script>";
							}
							$action_saisie == "MAJ_EQUIPE";
							$libelle_action = "libelle_maj_equipe";
						
						}
						
						else
						{
							echo "<script>afficher_message(\"".$message_info_manquantes."\",\"erreur\");</script>";
						}
						
						break;
	case "CREER_EQUIPE":
						if ( 
								!empty($nom_equipe)
								&&
								(empty($bal_equipe) || email_valide($bal_equipe))
								)
						{						
							$req_insert=
							"
								insert into commun.equipe
								(
									nom_equipe,
									bal_equipe ,
									synchro_date
								)
								values
								(
									upper(?),
									lower(?),
									now()
								)
							";
							$stmt_insert = $ressourceBDD_appli->prepare($req_insert);
							$stmt_insert->bindParam(1,$nom_equipe,PDO::PARAM_STR);
							$stmt_insert->bindParam(2,$bal_equipe,PDO::PARAM_STR);
							$stmt_insert->execute() or ErrorPdo (__FILE__, __LINE__, $req_insert, $stmt_insert);
							
							echo "<script>afficher_message(\"".$message_equipe_creer."\",\"ok\");</script>";
							
							$action_saisie == "MAJ_EQUIPE";
							$libelle_action = "libelle_maj_equipe";
							
							
							
						}
						else
						{
							echo "<script>afficher_message(\"".$message_info_manquantes."\",\"erreur\");</script>";
						}
						break;
	case "NOUVEAU_EQUIPE":
						$equipe="";
						$action_saisie = "CREER_EQUIPE";
						$libelle_action = "libelle_creer_equipe";
						break;
						
	case "DETRUIRE_EQUIPE":	
						$equipe="";
						
						if ( 
							! empty($id_equipe)
							&&
							is_numeric($id_equipe)
							)
						{			
						
							//suppression table equipe
							$req_delete="delete from commun.equipe where id_equipe = ? ";
							$stmt_delete = $ressourceBDD_appli->prepare($req_delete);
							$stmt_delete->bindParam(1,$id_equipe,PDO::PARAM_INT);
							$stmt_delete->execute() or ErrorPdo (__FILE__, __LINE__, $req_delete, $stmt_delete);
							
							echo "<script>afficher_message(\"".$message_equipe_supprimer."\",\"warning\");</script>";
							
						}
						
						
						
						break;

	case "AJOUTER_MEMBRE_EQUIPE":
							//ajouter le membre à l'équipe
							$req_ajoutmembre="update commun.contact SET id_equipe=? WHERE id=?";
							$stmt_ajoutmembre = $ressourceBDD_appli->prepare($req_ajoutmembre);
							$stmt_ajoutmembre->bindParam(1,$id_equipe,PDO::PARAM_INT);
							$stmt_ajoutmembre->bindParam(2,$id_collaborateur,PDO::PARAM_INT);
							$stmt_ajoutmembre->execute() or ErrorPdo (__FILE__, __LINE__, $req_ajoutmembre, $stmt_ajoutmembre);
							
							echo "<script>afficher_message(\"".$membre_ajoute."\",\"ok\");</script>";
							
						break;						
}



?>


<!------------------------------------------------------PAGE---------------------------------------------------------------------------------------->
<div class='contenu_page' style="width:100%; ">

<!------------------------------------------------------RECHERCHE----------------------------------------------------------------------------------->
		<fieldset style='width:100%; float:left; '>
		<form action="" method="post" id="formulaire_recherche">	
		<input type='hidden' name="action" id="action" value="">
		<input type='hidden' name="recherche" id="recherche" value="">
		<input type='hidden' name="champ" id="champ" value="">
									
				<TABLE cellpadding='5px' cellspacing='0px' border='0'> 
						<TR> 
							<TD class='titreBU' style='width:160px'><?php echo $search_title_equipe; ?></TD>
							<TD style='width:380px'><input name="equipe" type='text' id="equipe" size=80 value="<?php echo $equipe; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_rechercher' name='RechercherContact' type="button" onclick="post_formulaire('RECHERCHER_EQUIPE','equipe','regex','')" value="<?php echo $search_button; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_creer' name='NouveauContact' type="button" onclick="post_formulaire('NOUVEAU_EQUIPE','nouveau_equipe','regex','')" value="<?php echo $nouveau_equipe_button; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_tous_les_equipes' name='TousLesContacts' type="button" onclick="tous_les_equipes()" value="<?php echo $tous_les_equipes_button; ?>"/></TD>
						
						</TR>
				</TABLE>
		</form>
		<br>
		<?php

			$id_equipe="";
			$nom_equipe="";
			$bal_equipe="";
						
			if ( !empty($equipe))
			{
				
				//recuperation des données
				$req_equipe = "SELECT 	 e.id_equipe
										,e.nom_equipe
										,e.bal_equipe
				FROM 	commun.equipe e
				WHERE 	nom_equipe = '$equipe'";
				$result_equipe = $ressourceBDD_appli->query($req_equipe);
				$equipes = $result_equipe->fetchAll(PDO::FETCH_ASSOC);
				
				if ( count($equipes) == 1) //on affiche la fiche du equipe
				{
					$action = "MAJ_EQUIPE";
					$id_equipe = $equipes[0]['id_equipe'];
					$nom_equipe = $equipes[0]['nom_equipe'];
					$bal_equipe = $equipes[0]['bal_equipe'];					
					$action_saisie = "MAJ_EQUIPE";
				}	
				else //on propose un tableau de collaborateurs potentiel
				{
					$action="MULTI_EQUIPE";
				}
				
			}
			
			
		if ( $action == "RECHERCHER_EQUIPE" || $action == "MAJ_EQUIPE" || $action_saisie == "CREER_EQUIPE")
		{
			
		?>
		<input type="hidden" name="id_equipe" value="<?php echo $id_equipe; ?>">
		<center>
		<form action="" method="post" id="formulaire_saisie">	
		<TABLE cellpadding='5px' cellspacing='0px' border='0'>
		<tr>
			<td align="right">* <?php echo $libelle_nom_equipe; ?></td>
			<td><input type="text" id="nom_equipe" name="nom_equipe" value="<?php echo $nom_equipe; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right"><?php echo $libelle_bal_equipe; ?></td>
			<td><input type="text" id="bal_equipe" name="bal_equipe" value="<?php echo $bal_equipe; ?>" size=80></td>
		</tr>
		<tr>
			<td colspan=2 align="center">
				<input type="submit" value="<?php echo $$libelle_action; ?>">
				<?php
				
				if ( $action != "CREER_EQUIPE" )
				{				
				?>
				<input type="button" onclick="detruire_equipe(<?php echo $id_equipe; ?>);" value="<?php echo $detruire_equipe_button; ?>"/>
				<?php			
				}
				?>
			</td>
		</tr>
		</TABLE>
		<br>
		<fieldset style='width:55%; float:center; '>
		<TABLE cellpadding='5px' cellspacing='0px' border='0'>
		<tr>
			<td align="left"><?php echo $collaborateur; ?></td>
			<td><input name="contact" type='text' id="contact" size=60 value=""/></td>
			<td><input type="button" onclick="ajouter_membre_equipe(<?php echo $id_equipe; ?>);" value="<?php echo $ajouter_membre_equipe; ?>"/></td>
		</tr>
		</TABLE>
		</fieldset>
		<input type="hidden" id="id_equipe" name="id_equipe" value="<?php echo $id_equipe; ?>">
		<input type="hidden" id="id_collaborateur" name="id_collaborateur" value="">
		<input type="hidden" id="action_saisie" name="action_saisie" value="<?php echo $action_saisie; ?>">
		<?php
		//liste des collaborateurs
		
		//recuperation des données
		if ( !empty($id_equipe) && is_numeric($id_equipe))
		{
?>
			<br><br>
			<table>
			<tr style="width:100%">
			<td style="padding-right:20px; vertical-align:top;">
			<table class='display_list2' cellpadding='0' cellspacing='0' border='0'>
				<tbody>
				<tr class='table_line'>
					<th style="padding-right:10px; width:4%">&nbsp;</th>
					<th style="padding-right:10px;"><?php echo $libelle_nom_contact?></th>
					<th style="padding-right:10px;"><?php echo $libelle_prenom_contact?></th>
					<th style="padding-right:10px;"><?php echo $libelle_type_contact?></th>
				</tr>
<?php
			$req_contact = "
			select 
				c.id
				,c.nom_contact 
				,c.prenom_contact
				,c.type_contact
			from commun.contact_infos_v c
			where c.id_equipe = $id_equipe
			order by c.nom_contact, c.prenom_contact";
			$result_contact = $ressourceBDD_appli->query($req_contact);
			$contacts = $result_contact->fetchAll(PDO::FETCH_ASSOC);
			for ( $i=0; $i < count($contacts) ; $i++)
			{
				$id_contact = $contacts[$i]['id'];
				$nom_contact = $contacts[$i]['nom_contact'];
				$prenom_contact = $contacts[$i]['prenom_contact'];	
				$type_contact = $contacts[$i]['type_contact'];	
?>
				<tr class='line<?php echo ($i%2)?>'>
				<td style="padding-right:10px;"><?php echo ($i+1)?></td>
				<td style="padding-right:10px;"><?php echo nbsp($nom_contact)?></td>
				<td style="padding-right:10px;"><?php echo nbsp($prenom_contact)?></td>
				<td style="padding-right:10px;"><?php echo nbsp($type_contact)?></td>
				</tr>
<?php
			}
?>
				</tbody>
			</table>
			</td>
			<td style="padding-left:20px; vertical-align:top;">
			<table class='display_list2' cellpadding='0' cellspacing='0' border='0'>
				<tbody>
				<tr class='table_line'>
					<th style="padding-right:10px;width:4%">&nbsp;</th>
					<th style="padding-right:10px;"><?php echo $libelle_nna_application?></th>
					<th style="padding-right:10px;"><?php echo $libelle_nom_application?></th>
				</tr>
<?php
			$query = "
			select 
				''
				,n.nnannb 
				,n.nomrte_application
			from commun.nnannb_avec_equipe_v n
			where n.nom_equipe = '$equipe'
			order by n.nomrte_application";
			$result = $ressourceBDD_appli->query($query)or ErrorPdo (__FILE__, __LINE__, $query, $ressourceBDD_appli);
			$data = $result->fetchAll(PDO::FETCH_ASSOC);
			for ( $i=0; $i < count($data) ; $i++)
			{
?>
				<tr class='line<?php echo ($i%2)?>'>
				<td style="padding-right:10px;"><?php echo ($i+1)?></td>
				<td style="padding-right:10px;"><?php echo nbsp($data[$i]['nnannb'])?></td>
				<td style="padding-right:10px;"><?php echo nbsp($data[$i]['nomrte_application'])?></td>
				</tr>
<?php
			}
?>
			</tbody>
			</table>
			
			</td>
			</tr>
			</table>
<?php
		
		
		
		}
		
		
		
		
		?>
		
		</form>
		</center>
		<?php
		}


//si $action et $action_saisie sont non défini ou == ""
//on affiche le tableau des équipes
if ( empty($action) && empty($action_saisie))
{
	//recuperation des données
	$req_equipe = "SELECT 	e.id_equipe
							,e.nom_equipe
							,e.bal_equipe
	FROM 	commun.equipe e
	order by e.nom_equipe";
	$result_equipe = $ressourceBDD_appli->query($req_equipe);
	$equipes = $result_equipe->fetchAll(PDO::FETCH_ASSOC);
	
	echo "<center>";	
	echo "<table class='display_list2' style='width:50%' cellpadding='0' cellspacing='0' border='0'>";;
	echo "	<tbody>";
	echo "	<tr class='table_line'>";
	echo "		<th width=50%>$libelle_nom_equipe</th>";
	echo "		<th width=50%>$libelle_bal_equipe</th>";
	echo "	</tr>";
	
	for ( $i=0; $i < count($equipes) ; $i++)
	{
		$id_equipe = $equipes[$i]['id_equipe'];
		$nom_equipe = $equipes[$i]['nom_equipe'];
		$bal_equipe = $equipes[$i]['bal_equipe'];

	
		echo "<tr class='line".($i%2)."'>";
		echo "<td><a href='javascript:detail_equipe(\"".$nom_equipe."\")'>".nbsp($nom_equipe)."</a></td>";
		echo "<td><a href='mailto:".$bal_equipe."'>".nbsp($bal_equipe)."</a></td>";
		echo "</tr>";
		
	}
	
	echo "	</tbody>";
	echo "		</table>";
	echo "</center>";			
}

		?>
		
	</fieldset>
</div>
