<?php
/* MySQL Connection Information */

$user = "johhoo8_lee";
$pass = "letmein12";
$host = "mysql22.freehostia.com";
$database = "johhoo8_lee";

$link = mysql_connect($host, $user , $pass);
	if (!$link) {
    die('Could not connect: ' . mysql_error());
	}

mysql_select_db($database,$link);

?>