<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<meta charset="utf-8">
<meta charset="windows-1251">
<?
//phpinfo();

$dbusername = "wrhs";
$dbpass = "warehouse";
$dbhost = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=10.129.6.71)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=ora5.itgroup.local)))";

$c1 = ocilogon($dbusername,$dbpass,$dbhost); 
d($c1);
/*
$dbusername = "wrhs";
$dbpass = "warehouse";
$dbhost = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=10.129.6.71)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=ora5.itgroup.local)))";

$dbconnect = oci_connect ($dbusername, $dbpass, $dbhost);

if($dbconnect)
	echo 'Соединение установлено.';
else
	die ('Ошибка подключения к серверу баз данных.');
*/
?>