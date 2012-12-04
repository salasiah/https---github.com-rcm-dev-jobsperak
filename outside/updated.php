<?php
/// In order to use this script freely
/// you must leave the following copyright
/// information in this file:
/// Copyright 2012 www.turningturnip.co.uk
/// All rights reserved.

include("connect.php");

$id = trim(mysql_real_escape_string($_REQUEST['id']));

$email = trim(mysql_real_escape_string($_POST["email"]));
$f_name = trim(mysql_real_escape_string($_POST["f_name"]));
$l_name = trim(mysql_real_escape_string($_POST["l_name"]));
$phone = trim(mysql_real_escape_string($_POST["phone"]));
$employer_name = trim(mysql_real_escape_string($_POST["employer_name"]));
$position = trim(mysql_real_escape_string($_POST["position"]));
$start_work = trim(mysql_real_escape_string($_POST["start_work"]));

$rsUpdate = mysql_query("UPDATE jp_outside_successful
SET  email = '$email',  f_name = '$f_name',  l_name = '$l_name',  phone = '$phone',  employer_name = '$employer_name',  position = '$position',  start_work = '$start_work'
WHERE id = '$id' ");

if($rsUpdate) { echo "Successfully updated"; } else { die('Invalid query: '.mysql_error()); }
?>

<br/>
<br/>
<a href="index.php">View All Entry</a>