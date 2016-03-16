<?php

$host = 'localhost';
$user = 'root';
$passwd = 'usbw';
$dataBase = "unisinos";

mysql_connect($host, $user, $passwd) or die(mysql_error());
mysql_select_db($dataBase) or die(mysql_error());

mysql_set_charset("utf8"); 