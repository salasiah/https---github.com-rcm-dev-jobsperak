<?php  


require_once('Connections/conPerak.php');


$state_id = mysql_real_escape_string($_GET['state_id']);

/**
 *
 * Record Set for getDistrict
 * Retrieve via object 
 * 
 */
$query_getDistrict     = "SELECT * FROM jp_district WHERE dist_parent_fk = ".$state_id;
$rs_getDistrict        = mysql_query($query_getDistrict) or die(mysql_error());
$row_getDistrict       = mysql_fetch_object($rs_getDistrict);
$totalRows_getDistrict = mysql_num_rows($rs_getDistrict);


// default
echo "<option value=\"0\">All</option>";

while ($row_getDistrict1 = mysql_fetch_object($rs_getDistrict)) {
	echo "<option value=\"$row_getDistrict1->dist_id\">".ucfirst(strtolower($row_getDistrict1->dist_name))."</option>";
}



?>