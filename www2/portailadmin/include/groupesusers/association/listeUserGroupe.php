<?php
session_start();
require_once("../../../../portailv2/functions/functions.php");
require_once("../../../variables_".$_SESSION['PORTAIL\lang'].".php");
require_once("../../../variables.php");
$ressourceBDD_appli = connexion_externe('../../../../portailv2/');


$id=isset($_POST['id'])?$_POST['id']:"";

if ( empty($id) ) { return; }

$req_user="
select nom_contact,prenom_contact,g.nom
from contacts c,
	  associations_contacts_groupes acg,
      groupes g
where acg.id_contacts = c.id
and acg.id_groupes = g.id
and g.id=$id
order by nom_contact,prenom_contact
";



$result_req_user = $ressourceBDD_appli->query($req_user);


echo "<table style='width: 300px' class='display_list2' cellpadding='0' cellspacing='0' border='0'>";
echo "<tr class='table_line'>\n";
echo "<td>$label_groupe</td>";
echo "<td>$label_nom</td>";
echo "<td>$label_prenom</td>";
echo "</tr>";
while ($line = $result_req_user->fetch(PDO::FETCH_ASSOC)) 
{
		$groupe=$line['nom'];
		$nom = $line['nom_contact'];
		$prenom = $line['prenom_contact'];
		echo "<tr>";
		echo "<td>$groupe</td>";
		echo "<td>$nom</td>";
		echo "<td>$prenom</td>";
		echo "</tr>";
		
}
echo "</table>";


?>