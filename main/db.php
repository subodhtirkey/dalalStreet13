<?php

$mysql_hostname = "localhost";
$mysql_user = "dalal";
$mysql_password = "dalal@01#";
$mysql_database = "pragyan13_dalal";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die(mysql_error());
mysql_select_db($mysql_database, $bd) or die("Could not select database");
?>
