<?php  


require_once('Connections/conPerak.php');


$district_id = mysql_real_escape_string($_GET['district_id']);

/**
 *
 * Record Set for getDistrict
 * Retrieve via object 
 * 
 */
$query_getSubDistrict     = "SELECT * FROM jp_subdistrict WHERE district_id_fk = ".$district_id;
$rs_getSubDistrict        = mysql_query($query_getSubDistrict) or die(mysql_error());
$row_getSubDistrict       = mysql_fetch_object($rs_getSubDistrict);
$totalRows_getSubDistrict = mysql_num_rows($rs_getSubDistrict);


// default
echo "<option value=\"0\">All</option>";

while ($row_getSubDistrict1 = mysql_fetch_object($rs_getSubDistrict)) {
	echo "<option value=\"$row_getSubDistrict1->subdis_id\">".ucfirst(strtolower($row_getSubDistrict1->subdist_name))."</option>";
}



?>