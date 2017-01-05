<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Portail Admin Interface</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" href="http://163.104.210.198/commun/CSS/template.css" type="text/css" />
<link rel="stylesheet" href="/css/admin.css" type="text/css" />
<?php use_stylesheet('admin.css') ?>
<?php include_javascripts() ?>
<?php //include_stylesheets() ?>
<?php require_once("d:/applis/www/commun/functions/functions.php"); ?>
</head>
<body>


<!-- BANNIERE -->
<?php banniere("OPERA",'',"Administrateur",'',0); ?>


<div id="menu">
	<ul>
	<li><?php echo link_to('Utilisateurs', '/backend.php/Users') ?></li>
	<li><?php echo link_to('Categories', '/backend.php/Categories') ?></li>
	<li><?php echo link_to('Autorisations', '/backend.php/Autorisations') ?></li>
	<li><?php echo link_to('Applications', '/backend.php/Applications') ?></li>
</ul>
</div>


<div id="corps">
<?php echo $sf_content ?>
</div>


</body>
</html>



<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>
-->