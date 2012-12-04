<?php 

require_once('Connections/conJobsPerak.php'); 



$d_val = (int) mysql_real_escape_string($_POST['val1']);
$i_val = (int) mysql_real_escape_string($_POST['val2']);
$s_val = (int) mysql_real_escape_string($_POST['val3']);
$c_val = (int) mysql_real_escape_string($_POST['val4']);

$current_user_id = (int) mysql_real_escape_string($_POST['current_user_id']);


// save data
/**
 *
 * Record Set for insertDISC
 * Retrieve via object 
 * 
 */
$query_insertDISC     = "INSERT INTO jp_disc_test_result (disc_id, d_val, i_val, s_val, c_val, user_id_fk) VALUES ('', '$d_val', '$i_val', '$s_val', '$c_val', '$current_user_id')";
$rs_insertDISC        = mysql_query($query_insertDISC) or die(mysql_error());

if ($rs_insertDISC) {
	echo "Saved!";
}




?>