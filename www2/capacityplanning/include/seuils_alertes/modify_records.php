<?php
if(isset($_POST['edit_row']))
{
 $row=$_POST['row_id'];
 $name=$_POST['name_val'];
 $age=$_POST['age_val'];

 mysql_query("update user_detail set name='$name',age='$age' where id='$row'");
 echo "success";
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 mysql_query("delete from user_detail where id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $name=$_POST['name_val'];
 $age=$_POST['age_val'];
 mysql_query("insert into user_detail values('','$name','$age')");
 echo mysql_insert_id();
 exit();
}
?>