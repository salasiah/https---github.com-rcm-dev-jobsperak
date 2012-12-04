<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conJP = "localhost";
$database_conJP = "jobskcom_newjp";
$username_conJP = "jobskcom_rcm";
$password_conJP = "RCMPASSWORD";
$conJP = mysql_pconnect($hostname_conJP, $username_conJP, $password_conJP) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conJobsPerak);

?>