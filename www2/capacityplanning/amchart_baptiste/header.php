<?php ob_start(); ?>

<?php include '../TOOLS/Connexion_PDO_CDE.php'; ?>

<?php include 'fonctions.php'; ?>
<script type="text/javascript" src="fonctions.js"></script>

<?php session_start(); ?>

<html>
	<head>
		<title>Cahier Electronique CDE</title>
        
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
   
		<link href="bootstrap/css/fam-icons.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="bootstrap/css/datepicker.css" rel="stylesheet">
		<link rel="stylesheet" href="datatables/jquery.dataTables.min.css" />		
		<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-select.css" />
		<link rel="stylesheet" href="bootstrap/css/animate.css" />
		
		<link href="style.css" rel="stylesheet">
		
		<script src="bootstrap/js/jquery-1.10.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="bootstrap/js/bootstrap-datepicker.js"></script>		
		<script src="datatables/jquery.dataTables.min.js"></script>
		<script src="bootstrap/js/jquery.smartmenus.js"></script>
		<script src="bootstrap/js/bootstrap-select.js"></script>
		<script src="bootstrap/js/combobox.js"></script>
		<script src="bootstrap/js/jquery-iframe-auto-height.js"></script>
		<script src="tinymce/tinymce.min.js"></script>
  		<script src="amcharts/amcharts.js" type="text/javascript"></script>
		<script src="amcharts/serial.js" type="text/javascript"></script> 
		<script src="amcharts/lang/fr.js" type="text/javascript"></script> 
		<script src="notify/bootstrap-notify.js"></script>
		<script src="bootstrap/js/bootstrap-confirmation.js"></script>
		
		<script type="text/javascript">
			$.notifyDefaults({
				type: 'minimalist',
				animate: {
					enter: 'animated fadeIn',
					exit: 'animated fadeOut'
				},
				placement: {
					from: "bottom",
					align: "right"
				},
				delay: 5000,
				allow_dismiss: false
			});
		</script>
	</head>
</html>

<?php 
	if ($_SESSION['MDP'] == 'aucun' and basename($_SERVER['PHP_SELF']) != 'mdp.php' and basename($_SERVER['PHP_SELF']) != 'index.php')
	{
		$_SESSION['MDP'] = 'aucun';
		header('Location: mdp.php');
	}

	if (basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_modif_realise.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_absence.php' and basename($_SERVER['PHP_SELF']) != 'conges_ferie_ajout_popup.php' and basename($_SERVER['PHP_SELF']) != 'index.php' and basename($_SERVER['PHP_SELF']) != 'groupe_horaire_agents.php' and basename($_SERVER['PHP_SELF']) != 'groupe_horaire_agents_horaires.php' and basename($_SERVER['PHP_SELF']) != 'premiere_connexion.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_ajout.php' and basename($_SERVER['PHP_SELF']) != 'conges_liste_modifier_popup.php' and basename($_SERVER['PHP_SELF']) != 'conges_liste_ajout_popup.php' and basename($_SERVER['PHP_SELF']) != 'modifier_situation_popup.php' and basename($_SERVER['PHP_SELF']) != 'modifier_statut_popup.php' and basename($_SERVER['PHP_SELF']) != 'ajout_situation_popup.php' and basename($_SERVER['PHP_SELF']) != 'ajout_statut_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_planning_repliquer_popup.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_modif.php' and basename($_SERVER['PHP_SELF']) != 'groupe&enfant_modifier_planning_popup.php' and basename($_SERVER['PHP_SELF']) != 'enfant_ajout_planning_popup.php' and basename($_SERVER['PHP_SELF']) != 'effectif_repas_envoie_mail_selection.php' and basename($_SERVER['PHP_SELF']) != 'groupe_horaire_repliquer_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_ajout_planning_popup.php' and basename($_SERVER['PHP_SELF']) != 'Enfant_traitement.php' and basename($_SERVER['PHP_SELF']) != 'bons_envoie_mail_selection.php' and basename($_SERVER['PHP_SELF']) != 'conges_modifier_popup.php' and basename($_SERVER['PHP_SELF']) != 'conges_ajout_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_ajout_horaire_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_modifier_horaire_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_modifier_planning_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_modifier_planning_popup.php' and basename($_SERVER['PHP_SELF']) != 'groupe_repliquer.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_nouveau.php' and basename($_SERVER['PHP_SELF']) != 'agent_horaire_popup_valide.php')
	{
		include 'menu.php';
	}
	
	if (!isset($_SESSION['CDE_ID_Utilisateur']) and basename($_SERVER['PHP_SELF']) != 'index.php') {
		echo '<meta http-equiv="refresh" content="0; url=index.php">';
	}
?>