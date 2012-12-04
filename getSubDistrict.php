<?php 

require_once('Connections/conJobsPerak.php'); 


$district_id = (int) mysql_real_escape_string($_GET['district_id']);


/**
 *
 * Record Set for getSubDistricListed
 * Retrieve via object 
 * 
 */
$query_getSubDistricListed     = "SELECT * FROM jp_subdistrict WHERE district_id_fk = $district_id";
$rs_getSubDistricListed        = mysql_query($query_getSubDistricListed) or die(mysql_error());
$row_getSubDistricListed       = mysql_fetch_object($rs_getSubDistricListed);
$totalRows_getSubDistricListed = mysql_num_rows($rs_getSubDistricListed);


if ($totalRows_getSubDistricListed > 0) {
	while ($row_getSubDistricListed1 = mysql_fetch_object($rs_getSubDistricListed)) {
		echo "<option value=\"$row_getSubDistricListed1->subdis_id\">".ucwords(strtolower($row_getSubDistricListed1->subdist_name))."</option>";
	}
} else {
	echo "<option value=\"\">All</option>";
}


?>