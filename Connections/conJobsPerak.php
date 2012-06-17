<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conJobsPerak = "localhost";
$database_conJobsPerak = "rcm_jobsperak";
$username_conJobsPerak = "root";
$password_conJobsPerak = "";
$conJobsPerak = mysql_pconnect($hostname_conJobsPerak, $username_conJobsPerak, $password_conJobsPerak) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conJobsPerak);
?>
<?php $_ENV['app_url'] = "http://localhost:81/"; ?>