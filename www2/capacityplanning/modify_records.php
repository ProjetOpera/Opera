<?php
require_once("connect.php");

if(isset($_POST['edit_row']))
{
 $row=$_POST['row_id'];
 $module=$_POST['module_val'];
 $label=$_POST['label_val'];
 $seuil=$_POST['seuil_val'];
 $alerte=$_POST['alerte_val'];

 //$q = $connexion->prepare("update capacityplanning.parametres set Module_concerne=?,Label=?,Seuil=?,Alerte=? where id=?");
 //$q->execute(array($module, $label, $seuil, $alerte, $row));
 
 $connexion->exec("update capacityplanning.parametres set Module_concerne='$module',Label='$label',Seuil='$seuil',Alerte='$alerte' where id='$row'");
 echo "success";
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 $connexion->query("delete from capacityplanning.parametres where id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $module=$_POST['module_val'];
 $label=$_POST['label_val'];
 $seuil=$_POST['seuil_val'];
 $alerte=$_POST['alerte_val'];
 $connexion->exec("insert into capacityplanning.parametres(Module_concerne, Label, Seuil, Alerte, Pourcentage) values('$module','$label','$seuil','$alerte', 0);");
 echo $connexion->lastInsertId();
 exit();
}
?>