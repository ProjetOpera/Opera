<?php

	//connexion base
	session_start();
	require_once("../functions/functions.php");
	require_once("../variables_".$_SESSION['PORTAIL\lang'].".php");
	$link_portail = connexion_portail();

	switch ($_REQUEST["action"]) {
		case "getSocieteContact" :
			$query = "SELECT 	s.nom_societe
						FROM 	commun.contact c
						LEFT JOIN commun.equipe e ON e.id_equipe = c.id_equipe
						LEFT JOIN commun.societe s ON s.id = c.id_societe
						WHERE 	c.id = {$_SESSION['PORTAIL\id']}";
			$result = $link_portail->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_portail);
			$societe = $result->fetch(PDO::FETCH_ASSOC);
			$result->closeCursor();

			header ("200", true, 200);
			echo json_encode($societe);

			return;

		case "autocomplete" :
			$term = $_REQUEST['term'];
			$tableau_json = array();

			// Rechercher les contacts
			$query = "SELECT 	id	as id, 
								concat(nom_contact,' ',prenom_contact) nom
						FROM 	commun.contact
						WHERE 	concat(nom_contact,' ',prenom_contact) LIKE '%$term%'
						order by concat(nom_contact,' ',prenom_contact) asc";
			$result = $link_portail->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_portail);
			$contacts = $result->fetchAll(PDO::FETCH_ASSOC);
			$result->closeCursor();

			foreach ($contacts as $val) 
			{
				$tableau_json[] = array(
					'label' => "<img width='15px' style='margin:0 5px 0 5px' src='../portailv2/images/business_contact.png'>".stripslashes($val['nom']),
					'value' => stripslashes($val['nom']),
					'id' => "contact.".$val['id']);
			}

/*
			// Rechercher l'id de l'application Shiva
			$query = "SELECT id FROM portailv2.applications WHERE nom_appli = 'SHIVA'";
			$result = $link_portail->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_portail);
			list($id_aplli_shiva) = $result->fetch(PDO::FETCH_NUM);
			$result->closeCursor();
			
			// Connexion a la base de SHIVA
			$link_shiva = connexion_appli($id_aplli_shiva, $link_portail);

			// Rechercher les serveurs
			$query = "SELECT ID_serveur as id,
							 Nom_serveur as nom
						FROM shiva.serveur
						WHERE nom_serveur LIKE '$term%'";
			$result = $link_shiva->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_shiva);
			$serveurs = $result->fetchAll(PDO::FETCH_ASSOC);
			$result->closeCursor();

			foreach ($serveurs as $val) 
			{
				$tableau_json[] = array(
					'label' => "<img width='15px' style='margin:0 5px 0 5px' src='../portailv2/images/computer.png'>".stripslashes($val['nom']),
					'value' => stripslashes($val['nom']),
					'id' => "contact.".$val['id']);
			}

			// Rechercher les applications
			$query = "SELECT ID_application as id,
							 Nom_application as nom
						FROM Shiva.Application 
						WHERE Nom_application LIKE '$term%'";
			$result = $link_shiva->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_shiva);
			$applications = $result->fetchAll(PDO::FETCH_ASSOC);
			$result->closeCursor();

			foreach ($applications as $val) 
			{
				$tableau_json[] = array(
					'label' => "<img width='15px' style='margin:0 5px 0 5px' src='../portailv2/images/application.png'>".stripslashes($val['nom']),
					'value' => stripslashes($val['nom']),
					'id' => "contact.".$val['id']);
			}
*/

			echo json_encode($tableau_json);
			return;

		case "recherche" :
			list ($type, $id) = explode(".", $_REQUEST["id"]); // Id conient l'info de la forme "<type a rechercher>.<id dans le trype>"
			
			switch ($type) {
				case "contact" :
					//recuperation des données
					$query = "SELECT 	c.id
										,c.login_contact
										,concat(c.nom_contact, ' ', c.prenom_contact) nom_contact
										,c.email_contact
										,c.type_contact
										,c.tel_contact
										,c.ronde_contact
										,s.nom_societe
										,e.nom_equipe
								FROM 	commun.contact c
								LEFT JOIN commun.equipe e ON e.id_equipe = c.id_equipe
								LEFT JOIN commun.societe s ON s.id = c.id_societe
								WHERE 	c.id = $id";
					$result = $link_portail->query($query) or ErrorPdo (__FILE__, __LINE__, $query, $link_portail);
					$donnees_contact = $result->fetch(PDO::FETCH_ASSOC);
					$result->closeCursor();
?>
					<style type='text/css'>
						.ui-widget-content {float:none !important} /* Pour annuler le style creer par datpicker.css sur widget dialog */
					</style>
					<div>
						<table>
							<tr><th style="padding-right:10px;"><?php echo $Nom_prenom_contact?></th><td><?php echo $donnees_contact["nom_contact"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Email_contact?></th><td><a href="mailto:<?php echo $donnees_contact["email_contact"]?>" style="color:blue" title="mailto"><?php echo $donnees_contact["email_contact"]?></a></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Telephone_contact?></th><td><?php echo $donnees_contact["tel_contact"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Login_contact?></th><td><?php echo $donnees_contact["login_contact"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Fonction_contact?></th><td><?php echo $donnees_contact["type_contact"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Equipe_contact?></th><td><?php echo $donnees_contact["nom_equipe"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Ronde_contact?></th><td><?php echo $donnees_contact["ronde_contact"]?></td></tr>
							<tr><th style="padding-right:10px;"><?php echo $Societe_contact?></th><td><?php echo $donnees_contact["nom_societe"]?></td></tr>
						</table>
					</div>
<?php

					break;
				case "bien" :
					break;
				case "application" :
					break;
			}
			return;
	}


?>