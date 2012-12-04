<?php
/// In order to use this script freely
/// you must leave the following copyright
/// information in this file:
/// Copyright 2012 www.turningturnip.co.uk
/// All rights reserved.

include("connect.php");

$email = trim(mysql_real_escape_string($_POST["email"]));
$f_name = trim(mysql_real_escape_string($_POST["f_name"]));
$l_name = trim(mysql_real_escape_string($_POST["l_name"]));
$phone = trim(mysql_real_escape_string($_POST["phone"]));
$employer_name = trim(mysql_real_escape_string($_POST["employer_name"]));
$position = trim(mysql_real_escape_string($_POST["position"]));
$start_work = trim(mysql_real_escape_string($_POST["start_work"]));

$results = mysql_query("INSERT INTO jp_outside_successful (id, email, f_name, l_name, phone, employer_name, position, start_work)
VALUES ('', '$email', '$f_name', '$l_name', '$phone', '$employer_name', '$position', '$start_work')");

if($results) { echo "Successfully Added. <a href='add.php'>Add More</a>"; } else { die('Invalid query: '.mysql_error()); }

?>
<br/>
<br/>
<a href="index.php">View All Entry</a>