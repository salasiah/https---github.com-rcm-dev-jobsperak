<?php 
/// In order to use this script freely
/// you must leave the following copyright
/// information in this file:
/// Copyright 2012 www.turningturnip.co.uk
/// All rights reserved.

include("connect.php");

$id = $_GET['id'];

mysql_query("DELETE FROM jp_outside_successful WHERE id = '$id' ");
mysql_close();

echo "Entry deleted";
?>
<br/>
<br/>
<a href="index.php">View All Entry</a>