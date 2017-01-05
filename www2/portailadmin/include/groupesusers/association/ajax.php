<?php
session_start();
require_once("../connect.php");
if($_SESSION['PORTAIL\lang']=='FR')
	require_once("../variables_FR.php");
else if($_SESSION['PORTAIL\lang']=='EN')
	require_once("../variables_EN.php");
require_once("../variables.php");

$id_bien=mysql_real_escape_string($_POST['id']);
$_SESSION['NEXUS\modif_id_bien']=$id_bien;

$sql_checkbox_assoc_type="SELECT id, nom_type
							FROM types 
							ORDER BY nom_type";
$result_checkbox_assoc_type=mysql_query($sql_checkbox_assoc_type);

if (isset($_POST['bouton_assoc']))
{
	while ($r_checkbox_assoc_type = mysql_fetch_array($result_checkbox_assoc_type))
	{
		if (isset($_POST['assoc_'.$r_checkbox_assoc_type['id']]))
		{
			mysql_query("INSERT INTO biens_types(id_bien,id_type) VALUES (".$id_bien.",".$r_checkbox_assoc_type['id'].")");
		}
		else
		{
			mysql_query("DELETE FROM biens_types WHERE id_bien=".$id_bien." AND id_type=".$r_checkbox_assoc_type['id']);
		}
	}
}
if (isset($_POST['select_bien']))

$id_bien=$_POST['select_bien'];
$sql_recup_type_assoc_bien="SELECT t.id, t.nom_type
							FROM types t, biens_types bt 
							WHERE bt.id_bien=".$id_bien."
								AND t.id=bt.id_type
							ORDER BY upper(t.nom_type)";
$result_recup_type_assoc_bien=mysql_query($sql_recup_type_assoc_bien);

$tab_id_type_assoc_bien = array();
$i=0;

while ($r_recup_type_assoc_bien = mysql_fetch_array($result_recup_type_assoc_bien))
{
	 $tab_id_type_assoc_bien[$i]=$r_recup_type_assoc_bien['id'];
	 $i++;
}

$sql_recup_type="SELECT id,nom_type FROM types ORDER BY upper(nom_type)";
		
$result_recup_type=mysql_query($sql_recup_type);

$tr_line=0;
$contenu_tableau_type= "<table style='width: 300px' class='display_list2' cellpadding='0' cellspacing='0' border='0'>";
$contenu_tableau_type.= "<tr class='table_line'>";
	$contenu_tableau_type.= "<td colspan='2'>".$AssociationBiensTypes_titre2."</td>";
$contenu_tableau_type.= "</tr>";
while ($r_recup_type = mysql_fetch_array($result_recup_type))
{
	
	$contenu_tableau_type.= "<tr class='line".(($tr_line+1)%2)."'>";
	
	if($i==0)
	{
		$contenu_tableau_type.= "<td><input id='assoc_".$r_recup_type['id']."' name='assoc_".$r_recup_type['id']."' type='checkbox'/></td>";
		$contenu_tableau_type.= "<td>".$r_recup_type['nom_type']."</td>";	
	}
	else
	{
		$flag_type_assoc_bien=false;
		for($j=0;$j<$i;$j++)
		{
			if($r_recup_type['id']==$tab_id_type_assoc_bien[$j])
			{
				$flag_type_assoc_bien=true;
				$j=$i;
			}
			else
				$flag_type_assoc_bien=false;
			
		}
		if($flag_type_assoc_bien==true)
			$contenu_tableau_type.= "<td><input id='assoc_".$r_recup_type['id']."' name='assoc_".$r_recup_type['id']."' type='checkbox' checked='yes'/></td>";
		else
			$contenu_tableau_type.= "<td><input id='assoc_".$r_recup_type['id']."' name='assoc_".$r_recup_type['id']."' type='checkbox'/></td>";
		$contenu_tableau_type.= "<td>".$r_recup_type['nom_type']."</td>";
	}
		
	$contenu_tableau_type.= "</tr>";
	$tr_line++;
}
$contenu_tableau_type.= "</table>";



echo 'document.getElementById("tableau_type").innerHTML = "'.$contenu_tableau_type.'"';

?>