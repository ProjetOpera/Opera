<?php
/* ------------------------    Extraction CSV   -------------------------------- */

	if ($_REQUEST["action"] == "ExtractCsv") {
		header("Content-type: application/csv-tab-delimited-table");
		header("Content-disposition: filename=Nna_Nnb_et_Equipe-" . date("Ymd_His")."_".$reportType.".csv");
	}
	else {
?>

		<!---------------------------------------script pour autocompletion des champs de recherche--------------------------------------------------------->
		<script type='text/javascript'>
			
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
			
			function  maj_equipe(id)
			{
				nna = document.getElementById('nna_'+id).value;
				application = document.getElementById('application_'+id).value;
				equipe =  document.getElementById('liste_'+id).options[document.getElementById('liste_'+id).options.selectedIndex].text;
				id_equipe =  document.getElementById('liste_'+id).value;
				
				reponse = confirm("Voulez-vous vraiment ajouter l'application " + application + " dans l'équipe " + equipe + " ?");
				if ( reponse )
				{
					document.getElementById('nna').value = nna;
					document.getElementById('id_equipe').value = id_equipe;
					
					valeur="Y";
					if ( ! document.getElementById("cac_afficher_toutes_les_applications").checked)
					{
						valeur="N";
					}
					document.getElementById("afficher_toutes_les_applications").value=valeur;
					document.getElementById('action_saisie').value = "AJOUTER_EQUIPE";
					document.getElementById('formulaire_applications_sans_equipe').submit();
					
				}
			}
			
			function rafraichir_liste()
			{
				valeur="Y";
				if ( ! document.getElementById("cac_afficher_toutes_les_applications").checked)
				{
					valeur="N";
				}
				document.getElementById("afficher_toutes_les_applications").value=valeur;
				document.getElementById("formulaire_applications_sans_equipe").submit();
			}
			
			function toggle_button(id)
			{
				valeur=false;
				if ( document.getElementById("liste_"+id).value == "0" )
				{
					valeur=true;
				}
				else
				{
					valeur=false;
				}
				document.getElementById("bouton_"+id).disabled=valeur;
				
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
		<form id="formulaire_applications_sans_equipe" name="formulaire_applications_sans_equipe" method="POST" action="">
			<input type="hidden" name="afficher_toutes_les_applications" id="afficher_toutes_les_applications" value=""/>
			<input type="hidden" name="nna" id="nna" value=""/>
			<input type="hidden" name="id_equipe" id="id_equipe" value=""/>
			<input type="hidden" name="action_saisie" id="action_saisie" value=""/>
		</form>
<?php
	}
require_once("{$_SERVER[DOCUMENT_ROOT]}/commun/inc/librairie.inc.php");
require_once("{$_SERVER[DOCUMENT_ROOT]}/commun/inc/debug.inc.php");
include_once '../portailadmin/variables_' . $_SESSION['PORTAIL\lang'] . '.php';

$sans_equipe="Afficher que les applications sans équipe";
$search_button="Rechercher";
$equipe_ajoutee="L'application a été ajoutée à l'équipe";
$aucun_nom_court="Aucun nom court";
$libelle_maj_equipe="Mettre à jour";
$libelle_creer_equipe="Créer";
$libelle_nom_equipe="Équipe";

/**************** P A R A M È T R E S   E N   E N T R É E S  ************/

$cac_afficher_toutes_les_applications=isset($_POST["afficher_toutes_les_applications"])?$_POST["afficher_toutes_les_applications"]:"N";

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
$nna=isset($_REQUEST["nna"])?trim($_REQUEST["nna"]):"";
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

	case "AJOUTER_EQUIPE":
							if ( empty($id_equipe) || $id_equipe < 0 || empty($nna) ) break;
							
							$req_selection_equipe=
							"
								select 1
								from commun.liaison_atos_arte
								where nnannb = ?
							";
							$stmt_selection_equipe = $ressourceBDD_appli->prepare($req_selection_equipe);
							$stmt_selection_equipe->bindParam(1,$nna,PDO::PARAM_INT);
							$stmt_selection_equipe->execute();
							$lignes = $stmt_selection_equipe->fetchAll();
							if ( count($lignes) == 1 )
							{
							
								$req_modification_equipe=
								"
									update commun.liaison_atos_arte
									set id_equipe = ?
									where nnannb = ?
								";
								$stmt_modification_equipe = $ressourceBDD_appli->prepare($req_modification_equipe);
								$stmt_modification_equipe->bindParam(1,$id_equipe,PDO::PARAM_INT) or ErrorPdo (__FILE__, __LINE__, $req_selection_equipe, $ressourceBDD_appli);
								$stmt_modification_equipe->bindParam(2,$nna,PDO::PARAM_STR) or ErrorPdo (__FILE__, __LINE__, $req_selection_equipe, $ressourceBDD_appli);
								$stmt_modification_equipe->execute() or ErrorPdo (__FILE__, __LINE__, $req_selection_equipe, $ressourceBDD_appli);
							}
							else
							{
							
								$req_ajout_equipe=
								"
									insert into commun.liaison_atos_arte
									(
										nnannb,
										id_equipe
									) 
									values 
									(
									?, 
									?
									)
								";
								$stmt_ajout_equipe = $ressourceBDD_appli->prepare($req_ajout_equipe);
								$stmt_ajout_equipe->bindParam(1,$nna,PDO::PARAM_STR);
								$stmt_ajout_equipe->bindParam(2,$id_equipe,PDO::PARAM_INT);
								$stmt_ajout_equipe->execute() or ErrorPdo (__FILE__, __LINE__, $req_ajout_equipe, $ressourceBDD_appli);
							}
							
							echo "<script>afficher_message(\"".$equipe_ajoutee."\",\"ok\");</script>";
							
						break;						
}



/*
------------------------------------------------------RECHERCHE----------------------------------------------------------------------------------
*/

			//si la case cac_afficher_toutes_les_applications a été cochée
			// on ne d'affiche que les applications sans équipe
			$where="";
			$valeur_cac = "";
			if ( $cac_afficher_toutes_les_applications == "Y" )
			{
				$where = " and liaison.nom_equipe is null ";
				$valeur_cac = " checked ";
			}
		
		
			/* Restriction sur les applications actives au moment de la requete */
		
			$req_application = "
			select 
				a.nna_application
				,a.nomrte_application
				,a.nom_application
				,liaison.nom_equipe
				,liaison.id_equipe
				,p.nom_programme
			from 
				commun.programme p,
				commun.application a
			left outer join 
				( 
					select 	l.nnannb,
							e.nom_equipe,
							e.id_equipe
				 from commun.liaison_atos_arte l,
					  commun.equipe e
				where l.id_equipe = e.id_equipe
				)	liaison	
			on  liaison.nnannb = a.nna_application
			where 1=1
			and p.id = a.id_programme
			and now() between ifnull(datedebut_application,now()) and ifnull(datefin_application,now())
			$where
			order by a.nom_application, liaison.nom_equipe
			";
			
			
			
			$req_equipe = "
						select nom_equipe,id_equipe from commun.equipe order by nom_equipe";
			$result_equipe = $ressourceBDD_appli->query($req_equipe);
			$equipe_liste = $result_equipe->fetchAll(PDO::FETCH_ASSOC);	
			
			$result_application = $ressourceBDD_appli->query($req_application);
			$application = $result_application->fetchAll(PDO::FETCH_ASSOC);


/* ------------------------    Extraction CSV   -------------------------------- */

			if ($action == "ExtractCsv") {
				//Afficher l'entete des colonnes
				print utf8_decode("$libelle_nna_application;$libelle_nom_application;$libelle_nom_programme;$libelle_nom_equipe")."\r\n";
			

				for ( $i=0; $i < count($application) ; $i++)
				{
					$nna = $application[$i]['nna_application'];
					$nom_appli = empty($application[$i]['nomrte_application']) ? $application[$i]['nom_application'] : $application[$i]['nomrte_application'];
					$nom_prg = $application[$i]['nom_programme'];
					$equipe = $application[$i]['nom_equipe'];
					print utf8_decode("$nna;$nom_appli;$nom_prg;$equipe")."\r\n";
				}
				exit;
			}
?>

<!------------------------------------------------------PAGE---------------------------------------------------------------------------------------->
<div class='contenu_page' style="width:100%; ">

	<input type='checkbox' name='cac_afficher_toutes_les_applications' id='cac_afficher_toutes_les_applications' value='valeur attachée au bouton' onclick='rafraichir_liste()' <?php echo $valeur_cac;?>><?php echo $sans_equipe;?>
	<br><br>
	<a href="?action=ExtractCsv"><img style="height:15px;" src="../commun/images/xls.jpg" title="Extraction CSV"> Extraction CSV</a>
	<br><br>
	<table class='display_list2' style='width:100%' cellpadding='0' cellspacing='0' border='0'>
	<tbody>
		<tr class='table_line'>
			<th width=20%><?php echo $libelle_nna_application;?></th>
			<th width=40%><?php echo $libelle_nom_application;?></th>
			<th width=40%><?php echo $libelle_nom_programme;?></th>
			<th width=30%><?php echo $libelle_nom_equipe;?></th>
			<th width=20%><?php echo $libelle_MAJ;?></th>
		</tr>
<?php
			for ( $i=0; $i < count($application) ; $i++)
			{
				$nna_application = $application[$i]['nna_application'];
				$nom_application = $application[$i]['nomrte_application'];
				$nom_long_application = $application[$i]['nom_application'];
				$nom_programme = $application[$i]['nom_programme'];
				$nom_equipe = $application[$i]['nom_equipe'];
				$id_equipe = $application[$i]['id_equipe'];
				echo "<input type='hidden' id='nna_".$i."' value='".$nna_application."'>";
				//echo "<input type='hidden' id='application_".$i."'  value='".$nom_application."'>";
				echo "<tr class='line".($i%2)."'>";
				//echo "<td>".($i+1)."</td>";
				echo "<td>";
				echo 	nbsp($nna_application);
				echo "</td>";
				echo "<td>";
				if ( empty($nom_application))
				{
				echo "<p title='$nom_long_application'><b>$aucun_nom_court</b></p>";
				echo "<input type='hidden' id='application_".$i."'  value='".$nom_long_application."'>";
				}
				else
				echo 	nbsp($nom_application);
				echo "<input type='hidden' id='application_".$i."'  value='".$nom_application."'>";
				echo "</td>";	
				echo "<td>";
				echo 	nbsp($nom_programme);
				echo "</td>";					
				
				
				$selectEquipe="";
				$disabled="";
				$selectEquipe.="<select id='liste_".$i."'  name='liste' onchange='toggle_button(".$i.")'>";
				if ( empty($id_equipe))
				{
					$selectEquipe.="<option value='0' SELECTED></option>";
					$disabled="DISABLED";
				}
				for ( $j=0; $j < count($equipe_liste) ; $j++)
				{
					$liste_equipe = $equipe_liste[$j]['nom_equipe'];
					$id_equipe_liste = $equipe_liste[$j]['id_equipe'];
					$selected = "";
					if ( $id_equipe_liste == $id_equipe ) { $selected = "SELECTED"; }
					$selectEquipe.="<option value='$id_equipe_liste' $selected>$liste_equipe</option>";
				}
				$selectEquipe.="</select>";
				
				
				
				
				
				echo "<td>".$selectEquipe."</td>";
				echo "<td><button id='bouton_".$i."' name='$i' style='width: 100px' onclick='maj_equipe($i)' $disabled>$libelle_maj_equipe</button></td>";
				
							
				echo "</tr>";
				
			}
			
			echo "	</tbody>";
			echo "		</table>";
		
		?>
		</center>
		
		</form>