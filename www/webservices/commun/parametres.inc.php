<?php
// Connexion COBRA
$dbhost = 'localhost';
$dbuser = 'commun';
$dbpass = 'commun';
$dbname = 'commun';
$dbport = 3306;

//ITAC
$itacTNS = '(DESCRIPTION_LIST=(LOAD_BALANCE=off)(FAILOVER=on)(DESCRIPTION=(ADDRESS_LIST=(LOAD_BALANCE=on)(ADDRESS = (PROTOCOL = TCP)(HOST = itac-prd-snp02-db.rte-france.com)(PORT = 1526)))(CONNECT_DATA=(SERVICE_NAME=ITAC_OCI)))(DESCRIPTION=(ADDRESS_LIST=(LOAD_BALANCE=on)(ADDRESS = (PROTOCOL = TCP)(HOST = itac-prd-snp01-db.rte-france.com)(PORT = 1526)))(CONNECT_DATA=(SERVICE_NAME=ITAC_OCI))))';
$itacUser = 'ITAC522_LEC';
$itacPwd = 'ITAC522_LEC';
?>