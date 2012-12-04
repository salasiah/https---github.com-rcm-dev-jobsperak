<?php 

require_once('Connections/conJobsPerak.php'); 



$state_id = (int) mysql_real_escape_string(@$_GET['state_id']);


/**
 *
 * Record Set for getDistricListed
 * Retrieve via object 
 * 
 */
$query_getDistricListed     = "SELECT * FROM jp_district WHERE dist_parent_fk = $state_id";
$rs_getDistricListed        = mysql_query($query_getDistricListed) or die(mysql_error());
$row_getDistricListed       = mysql_fetch_object($rs_getDistricListed);
$totalRows_getDistricListed = mysql_num_rows($rs_getDistricListed);

if ($totalRows_getDistricListed > 0) {
	while ($row_getDistricListed1 = mysql_fetch_object($rs_getDistricListed)) {
		echo "<option value=\"$row_getDistricListed1->dist_id\">".ucwords(strtolower($row_getDistricListed1->dist_name))."</option>";
	}
} else {
	echo "<option value=\"\">All</option>";
}

?>