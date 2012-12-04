<?php require_once('../Connections/conJobsPerak.php'); ?>
<?php  



$jobsid = mysql_real_escape_string(stripslashes($_GET['adsid']));
$url_callback = mysql_real_escape_string(stripslashes($_GET['url_callback']));


// Delete Jobs / Disable View
$sqlDelete = "UPDATE jp_ads SET ads_enable_view = 2 WHERE ads_id = '$jobsid'";
$sqlDeleteResult = mysql_query($sqlDelete);

if ($sqlDeleteResult) {
	# code...
	header("location: $url_callback");
}



?>