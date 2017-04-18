<?php
require_once("connect.php");

if(isset($_POST['edit_row']))
{
 $row=$_POST['row_id'];
 $module=$_POST['module_val'];
 $label=$_POST['label_val'];
 $seuil=$_POST['seuil_val'];
 $alerte=$_POST['alerte_val'];

 $ressourceBDD_appli->query("update capacityplanning.parametres set Module_concerne='$module',Label='$label',Seuil='$seuil',Alerte='$alerte' where id='$row'");
 echo "success";
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 $ressourceBDD_appli->query("delete from capacityplanning.parametres where id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $module=$_POST['module_val'];
 $label=$_POST['label_val'];
 $seuil=$_POST['seuil_val'];
 $alerte=$_POST['alerte_val'];
 $ressourceBDD_appli->query("insert into capacityplanning.parametres values('','$module','$label','$alerte','$seuil')");
 echo mysql_insert_id();
 exit();
}
?>