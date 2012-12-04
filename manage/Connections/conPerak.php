<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*$hostname_conPerak = "localhost";
$database_conPerak = "jobskcom_newjp";
$username_conPerak = "jobskcom_rcm";
$password_conPerak = "RCMPASSWORD";*/

$hostname_conPerak = "localhost";
$database_conPerak = "jobsperak";
$username_conPerak = "root";
$password_conPerak = "";


$conPerak = mysql_pconnect($hostname_conPerak, $username_conPerak, $password_conPerak) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conPerak ); 
?>