<?php require_once('../Connections/conJobsPerak.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAds = "SELECT ads_id, ads_enable_view, ads_date_expired FROM jp_ads ORDER BY ads_date_expired DESC";
$rsAds = mysql_query($query_rsAds, $conJobsPerak) or die(mysql_error());
$row_rsAds = mysql_fetch_assoc($rsAds);
$totalRows_rsAds = mysql_num_rows($rsAds);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ads Expired</title>
</head>

<body>
<strong>Today Date: 
<?php

# set GMT +8
date_default_timezone_set('Asia/Singapore');

# Current date 
$currentTime = date("m/d/Y");

# display date
echo $currentTime;

?>
</strong><br/><br/>
<table width="600" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <th bgcolor="#CCCCCC">Id</th>
    <th bgcolor="#CCCCCC">Expired Date</th>
    <th bgcolor="#CCCCCC">Status</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsAds['ads_id']; ?></td>
      <td align="center" valign="middle">
	  <?php 
	  
	  if(date('m/d/Y',strtotime($row_rsAds['ads_date_expired'])) == $currentTime) {
		  
		  $sqlExpired = "UPDATE jp_ads SET ads_enable_view = 2 WHERE ads_id = ".$row_rsAds['ads_id'];
		  $sqlExpiredResult = mysql_query($sqlExpired);
		  
		  echo 'Expired Today <br/>';
		    
		} else {
			echo date('m/d/Y',strtotime($row_rsAds['ads_date_expired']));
		}
	  
	  ?></td>
      <td align="center" valign="middle">
	  <?php
      	
		if($row_rsAds['ads_enable_view'] == 1){
			echo "<span style='color:green;font-weight:bold'>Live</span>";
		} else {
			echo "<span style='color:#f3f3f3;font-weight:bold'>Close</span>";
		}
	  ?></td>
    </tr>
    <?php } while ($row_rsAds = mysql_fetch_assoc($rsAds)); ?>
</table>

</body>
</html>
<?php
mysql_free_result($rsAds);
?>
