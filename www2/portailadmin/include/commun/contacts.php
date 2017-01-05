<!---------------------------------------script pour autocompletion des champs de recherche--------------------------------------------------------->
<script type='text/javascript'>
	$(document).ready(function()
	{
      $( 'input#contact').autocomplete(
	  {
          source: 'include/commun/chercher_contact.php',
          minLength: 2,
		  select: function(event, ui) 
		  { 
			post_formulaire("RECHERCHER_CONTACT","contact","exact",ui.item.label); 
		  }
	});
	  
	});
	
	function post_formulaire(action,champ,recherche,valeur)
	{
		document.getElementById('action').value = action;
		document.getElementById('champ').value = champ;
		document.getElementById('recherche').value = recherche;
		
		if ( action == "RECHERCHER_CONTACT" && valeur != "" )
		{
			document.getElementById("contact").value=valeur;
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
	
	function  detruire_contact(id)
	{
		nom_contact = document.getElementById('nom_contact').value;
		prenom_contact = document.getElementById('prenom_contact').value;
		reponse = confirm("!!! Voulez-vous vraiment supprimer l'utilisateur " + prenom_contact + " " + nom_contact + " ? !!!");
		if ( reponse )
		{
			document.getElementById('action_saisie').value = "DETRUIRE_CONTACT";
			document.getElementById('formulaire_saisie').submit();
		}
	}
	
	function detail_contact(contact)
	{
		document.getElementById('contact').value = contact;
		post_formulaire('RECHERCHER_CONTACT','contact','regex','')
	}
	
	function tous_les_contacts()
	{
		document.getElementById('contact').value = "";
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

$search_title_contact="Utilisateur";
$search_button="Rechercher";
$nouveau_contact_button="Nouvel utilisateur";
$detruire_contact_button="Supprimer l'utilisateur";
$tous_les_contacts_button="Tous les utilisateurs";
$message_erreur_login_existant="Un utilisateur avec ce login '%login_contact%' existe déjà !!!";
$message_info_manquantes="Tous les champs précédés d'un * doivent être renseignés et les adresses email dans un format valide !!!";
$message_contact_maj="L'utilisateur a été mis à jour";
$message_contact_creer="L'utilisateur a été créé";
$message_contact_supprimer="L'utilisateur a été supprimé !!!";
$libelle_maj_contact="Mettre à jour";
$libelle_creer_contact="Créer";
$libelle_nom_contact="Nom";
$libelle_prenom_contact="Prénom";
$libelle_type_contact="Fonction";
$libelle_email_contact="Email";
$libelle_tel_contact="Tél";
$libelle_ronde_contact="Ronde";
$libelle_nom_societe="Société";
$libelle_nom_equipe="Equipe";

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
$id_contact=isset($_REQUEST["id_contact"])?trim($_REQUEST["id_contact"]):-1;
$nom_contact=isset($_REQUEST["nom_contact"])?trim($_REQUEST["nom_contact"]):"";
$prenom_contact=isset($_REQUEST["prenom_contact"])?trim($_REQUEST["prenom_contact"]):"";
$login_contact=isset($_REQUEST["login_contact"])?trim($_REQUEST["login_contact"]):"";
$type_contact=isset($_REQUEST["type_contact"])?trim($_REQUEST["type_contact"]):"";
$email_contact=isset($_REQUEST["email_contact"])?trim($_REQUEST["email_contact"]):"";
$tel_contact=isset($_REQUEST["tel_contact"])?trim($_REQUEST["tel_contact"]):"";
$ronde_contact=isset($_REQUEST["ronde_contact"])?trim($_REQUEST["ronde_contact"]):"";
$id_societe=isset($_REQUEST["id_societe"])?trim($_REQUEST["id_societe"]):-1;
$id_equipe=isset($_REQUEST["id_equipe"])?trim($_REQUEST["id_equipe"]):-1;


if ( empty($nom_contact) && empty($prenom_contact))
{
	$contact=isset($_REQUEST["contact"])?$_REQUEST["contact"]:"";
}
else
{
	$contact=$prenom_contact." ".$nom_contact;
}

$libelle_action = "libelle_maj_contact";


/******************* T R A I T E M E N T S   E N   B A S E   D E   D O N N E E S  *********************/

switch ( $action_saisie )
{	
	case "MAJ_CONTACT":
						if ( 	!empty($id_contact) 
								&& 
								is_numeric($id_contact) 
								&& 
								is_numeric($id_societe) 
								&& 
								$id_societe != -1
								&&
								!empty($nom_contact)
								&&
								!empty($prenom_contact)
								&&
								!empty($login_contact)
								&&
								!empty($type_contact)
								&&
								!empty($email_contact)
								&&
								!empty($tel_contact)
								&&
								email_valide($email_contact)
							)
						{						
							
							//on verifie que le login n'existe par pour un autre id de contact
							$req_verif = "select count(1) nb from commun.contact where login_contact = ? and id != ?";
							$stmt_verif = $ressourceBDD_appli->prepare($req_verif);
							$stmt_verif->bindParam(1,$login_contact,PDO::PARAM_STR);
							$stmt_verif->bindParam(2,$id_contact,PDO::PARAM_INT);
							$stmt_verif->execute();
							$verif = $stmt_verif->fetchAll(PDO::FETCH_ASSOC);
							if ( $verif[0]["nb"] == 0 )
							{
								//on peut faire l'update
								
								$req_update=
								"
									update commun.contact
									set 
										nom_contact = upper(?),
										prenom_contact = CONCAT(UCASE(LEFT(?, 1)),LCASE(SUBSTRING(?, 2))),
										login_contact = lower(?),
										type_contact = ?,
										email_contact = lower(?),
										tel_contact = ?,
										ronde_contact = ?,
										id_societe = ?,
										id_equipe = ?
									where id = ?
											
								";
								$stmt_update = $ressourceBDD_appli->prepare($req_update);
								$stmt_update->bindParam(1,$nom_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(2,$prenom_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(3,$prenom_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(4,$login_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(5,$type_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(6,$email_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(7,$tel_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(8,$ronde_contact,PDO::PARAM_STR);
								$stmt_update->bindParam(9,$id_societe,PDO::PARAM_INT);
								$stmt_update->bindParam(10,$id_equipe,PDO::PARAM_INT);
								$stmt_update->bindParam(11,$id_contact,PDO::PARAM_INT);
								$stmt_update->execute();
								
								echo "<script>afficher_message(\"".$message_contact_maj."\",\"ok\");</script>";
							
								
							}
							else
							{
								echo "<script>afficher_message(\"".str_replace("%login_contact%",$login_contact,$message_erreur_login_existant)."\",\"erreur\");</script>";
							}
							$action_saisie == "MAJ_CONTACT";
							$libelle_action = "libelle_maj_contact";
						}
						else
						{
							echo "<script>afficher_message(\"".$message_info_manquantes."\",\"erreur\");</script>";
						}
						break;
	case "CREER_CONTACT":
						if ( 
								is_numeric($id_societe) 
								&& 
								$id_societe != -1
								&&
								is_numeric($id_equipe) 
								&& 
								!empty($nom_contact)
								&&
								!empty($prenom_contact)
								&&
								!empty($login_contact)
								&&
								!empty($type_contact)
								&&
								!empty($email_contact)
								&&
								!empty($tel_contact)
								&&
								email_valide($email_contact)
								)
						{						
							$req_insert=
							"
								insert into commun.contact
								(
									nom_contact,
									prenom_contact ,
									login_contact ,
									type_contact ,
									email_contact ,
									tel_contact ,
									ronde_contact ,
									id_societe,
									id_equipe,
									synchro_date
								)
								values
								(
									upper(?),
									CONCAT(UCASE(LEFT(?, 1)),LCASE(SUBSTRING(?, 2))),
									lower(?),
									?,
									lower(?),
									?,
									?,
									?,
									?,
									now()
								)
							";
							$stmt_insert = $ressourceBDD_appli->prepare($req_insert);
							$stmt_insert->bindParam(1,$nom_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(2,$prenom_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(3,$prenom_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(4,$login_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(5,$type_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(6,$email_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(7,$tel_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(8,$ronde_contact,PDO::PARAM_STR);
							$stmt_insert->bindParam(9,$id_societe,PDO::PARAM_INT);
							$stmt_insert->bindParam(10,$id_equipe,PDO::PARAM_INT);
							$stmt_insert->execute();
							
							echo "<script>afficher_message(\"".$message_contact_creer."\",\"ok\");</script>";
							
							$action_saisie == "MAJ_CONTACT";
							$libelle_action = "libelle_maj_contact";
							
							
							
						}
						else
						{
							echo "<script>afficher_message(\"".$message_info_manquantes."\",\"erreur\");</script>";
						}
						break;
	case "NOUVEAU_CONTACT":
						$contact="";
						$action_saisie = "CREER_CONTACT";
						$libelle_action = "libelle_creer_contact";
						break;
						
	case "DETRUIRE_CONTACT":	
						$contact="";
						
						if ( 
							! empty($id_contact)
							&&
							is_numeric($id_contact)
							)
						{			
						
							//suppression table association groupe
							$req_delete="delete from associations_contacts_groupes where id_contacts = ? ";
							$stmt_delete = $ressourceBDD_appli->prepare($req_delete);
							$stmt_delete->bindParam(1,$id_contact,PDO::PARAM_INT);
							$stmt_delete->execute();
						
						
							//suppression table contact
							$req_delete="delete from commun.contact where id = ? ";
							$stmt_delete = $ressourceBDD_appli->prepare($req_delete);
							$stmt_delete->bindParam(1,$id_contact,PDO::PARAM_INT);
							$stmt_delete->execute();
							
							echo "<script>afficher_message(\"".$message_contact_supprimer."\",\"warning\");</script>";
							
						}
						
						
						
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
							<TD class='titreBU' style='width:160px'><?php echo $search_title_contact; ?></TD>
							<TD style='width:380px'><input name="contact" type='text' id="contact" size=80 value="<?php echo $contact; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_rechercher' name='RechercherContact' type="button" onclick="post_formulaire('RECHERCHER_CONTACT','contact','regex','')" value="<?php echo $search_button; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_creer' name='NouveauContact' type="button" onclick="post_formulaire('NOUVEAU_CONTACT','nouveau_contact','regex','')" value="<?php echo $nouveau_contact_button; ?>"/></TD>
							<TD style='width:170px'><input class='bouton_tous_les_contacts' name='TousLesContacts' type="button" onclick="tous_les_contacts()" value="<?php echo $tous_les_contacts_button; ?>"/></TD>
						
						</TR>
				</TABLE>
		</form>
		<br>
		<?php
			
			$id_contact="";
			$nom_contact="";
			$prenom_contact="";
			$email_contact="";
			$type_contact="";
			$tel_contact="";
			$ronde_contact="";
			$login_contact="";
			$id_societe=-1;
			$id_equipe=-1;
			
			
			if ( !empty($contact))
			{
				
				//recuperation des données
				$req_contact = "SELECT 	c.id
										,c.login_contact
										,c.prenom_contact
										,c.nom_contact
										,c.email_contact
										,c.type_contact
										,c.tel_contact
										,c.ronde_contact
										,c.id_societe
										,c.id_equipe
				FROM 	commun.contact c
				WHERE 	concat(prenom_contact,' ',nom_contact) = '$contact'";
				$result_contact = $ressourceBDD_appli->query($req_contact);
				$contacts = $result_contact->fetchAll(PDO::FETCH_ASSOC);
				
				if ( count($contacts) == 1) //on affiche la fiche du contact
				{
					$action = "MAJ_CONTACT";
					$id_contact = $contacts[0]['id'];
					$nom_contact = $contacts[0]['nom_contact'];
					$prenom_contact = $contacts[0]['prenom_contact'];
					$type_contact = $contacts[0]['type_contact'];
					$email_contact = $contacts[0]['email_contact'];
					$tel_contact = $contacts[0]['tel_contact'];
					$ronde_contact = $contacts[0]['ronde_contact'];
					$login_contact = $contacts[0]['login_contact'];
					$id_societe =  $contacts[0]['id_societe'];
					$id_equipe = $contacts[0]['id_equipe'];
					
					$action_saisie = "MAJ_CONTACT";
				}	
				else //on propose un tableau de collaborateurs potentiel
				{
					$action="MULTI_CONTACT";
				}
				
			}
			
			
		if ( $action == "RECHERCHER_CONTACT" || $action == "MAJ_CONTACT" || $action_saisie == "CREER_CONTACT")
		{
			
		?>
		
		<input type="hidden" name="id_contact" value="<?php echo $id_contact; ?>">
		<center>
		<form action="" method="post" id="formulaire_saisie">	
		<TABLE cellpadding='5px' cellspacing='0px' border='0'>
		<tr>
			<td align="right">* Nom</td>
			<td><input type="text" id="nom_contact" name="nom_contact" value="<?php echo $nom_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">* Prénom</td>
			<td><input type="text" id="prenom_contact" name="prenom_contact" value="<?php echo $prenom_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">* Login</td>
			<td><input type="text" id="login_contact" name="login_contact" value="<?php echo $login_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">* Type</td>
			<td><input type="text" id="type_contact" name="type_contact" value="<?php echo $type_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">* Email</td>
			<td><input type="text" id="email_contact" name="email_contact" value="<?php echo $email_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">* Tél</td>
			<td><input type="text" id="tel_contact" name="tel_contact" value="<?php echo $tel_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">Ronde</td>
			<td><input type="text" id="ronde_contact" name="ronde_contact" value="<?php echo $ronde_contact; ?>" size=80></td>
		</tr>
		<tr>
			<td align="right">Equipe</td>
			<td align="left">
			<?php
				//liste déroulante
				$req_equipe = "select id_equipe,nom_equipe from commun.equipe order by nom_equipe asc";
				$select_equipe="<select name='id_equipe'>";
				$select_equipe.="<option value='-1'></option>";
				$result_equipe = $ressourceBDD_appli->query($req_equipe);
				$equipes = $result_equipe->fetchAll(PDO::FETCH_ASSOC);
				for ( $i=0 ; $i < count($equipes) ; $i++)
				{
					$selected="";
					if ( $equipes[$i]["id_equipe"] == $id_equipe) { $selected = " SELECTED ";}
					$select_equipe.="<option value='".$equipes[$i]["id_equipe"]."' $selected>".$equipes[$i]["nom_equipe"]."</option>";
				}
				$select_equipe.="</select>";
				echo $select_equipe;
			?>
				
		</tr>
		<tr>
			<td align="right">* Société</td>
			<td align="left">
			<?php
				//liste déroulante
				$req_societe = "select id,nom_societe from commun.societe order by nom_societe asc";
				$select_societe="<select name='id_societe'>";
				$select_societe.="<option value='-1'></option>";
				$result_societe = $ressourceBDD_appli->query($req_societe);
				$societes = $result_societe->fetchAll(PDO::FETCH_ASSOC);
				for ( $i=0 ; $i < count($societes) ; $i++)
				{
					$selected="";
					if ( $societes[$i]["id"] == $id_societe) { $selected = " SELECTED ";}
					$select_societe.="<option value='".$societes[$i]["id"]."' $selected>".$societes[$i]["nom_societe"]."</option>";
				}
				$select_societe.="</select>";
				echo $select_societe;
			?>
			
			</td>
		</tr>
		<tr>
			<td colspan=2 align="center">
				<input type="submit" value="<?php echo $$libelle_action; ?>">
				<?php
				
				if ( $action != "CREER_CONTACT" )
				{				
				?>
				<input type="button" onclick="detruire_contact(<?php echo $id_contact; ?>);" value="<?php echo $detruire_contact_button; ?>"/>
				<?php			
				}
				?>
			</td>
		</tr>
		</TABLE>
		<input type="hidden" id="id_contact" name="id_contact" value="<?php echo $id_contact; ?>">
		<input type="hidden" id="action_saisie" name="action_saisie" value="<?php echo $action_saisie; ?>">
		
		</form>
		</center>
		<?php
		}


//si $action et $action_saisie sont non défini ou == ""
//on affiche le tableau des utilisateurs
if ( empty($action) && empty($action_saisie))
{
	//recuperation des données
	$req_contact = "SELECT 	c.id
							,c.login_contact
							,c.prenom_contact
							,c.nom_contact
							,c.email_contact
							,c.type_contact
							,c.tel_contact
							,c.ronde_contact
							,c.id_societe
							,c.id_equipe
							,e.nom_equipe
							,s.nom_societe
	FROM 	commun.societe s,
			commun.contact c			
			left join commun.equipe e on c.id_equipe = e.id_equipe
	where 	c.id_societe = s.id
	order by c.nom_contact,c.prenom_contact";
	$result_contact = $ressourceBDD_appli->query($req_contact);
	$contacts = $result_contact->fetchAll(PDO::FETCH_ASSOC);
	
	echo "<table class='display_list2' cellpadding='0' cellspacing='0' border='0'>";;
	echo "	<tbody>";
	echo "	<tr class='table_line'>";
	echo "		<td>$libelle_nom_contact</td>";
	echo "		<td>$libelle_prenom_contact</td>";
	echo "		<td>$libelle_type_contact</td>";
	echo "		<td>$libelle_email_contact</td>";
	echo "		<td>$libelle_tel_contact</td>";
	echo "		<td>$libelle_nom_societe</td>";
	echo "		<td>$libelle_nom_equipe</td>";
	echo "	</tr>";
	
	for ( $i=0; $i < count($contacts) ; $i++)
	{
		$id_contact = $contacts[$i]['id'];
		$nom_contact = $contacts[$i]['nom_contact'];
		$prenom_contact = $contacts[$i]['prenom_contact'];
		$type_contact = $contacts[$i]['type_contact'];
		$email_contact = $contacts[$i]['email_contact'];
		$tel_contact = $contacts[$i]['tel_contact'];
		$ronde_contact = $contacts[$i]['ronde_contact'];
		$login_contact = $contacts[$i]['login_contact'];
		$id_societe =  $contacts[$i]['id_societe'];
		$id_equipe = $contacts[$i]['id_equipe'];
		$nom_societe =  $contacts[$i]['nom_societe'];
		$nom_equipe = $contacts[$i]['nom_equipe'];

	
		echo "<tr class='line".($i%2)."'>";
		echo "<td><a href='javascript:detail_contact(\"".$prenom_contact." ".$nom_contact."\")'>".nbsp($nom_contact)."</a></td>";
		echo "<td>".nbsp($prenom_contact)."</td>";
		echo "<td>".nbsp($type_contact)."</td>";
		echo "<td><a href='mailto:".$email_contact."'>".nbsp($email_contact)."</a></td>";
		echo "<td>".nbsp($tel_contact)."</td>";
		echo "<td>".nbsp($nom_societe)."</td>";
		echo "<td>".nbsp($nom_equipe)."</td>";
		echo "</tr>";
		
	}
	
	echo "	</tbody>";
	echo "		</table>";
				
}
		
		?>

		</fieldset>
		
		
		
