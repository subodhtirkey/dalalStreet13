<?php
mysql_connection("localhost","dalal","dalal@01#");

mysql_select_db("pragyan13_dalal");

$var=mysql_query("SELECT DISTINCT `userid` FROM `stocks_details`");
while($c=mysql_fetch_array($var))
  {
    $theid=$c[0];
    $kick=mysql_query("SELECT * FROM ")
  }
?>