<?php require_once('Connections/conJP.php'); ?>
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

mysql_select_db($database_conJP, $conJP);
$query_rsStateList = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsStateList = mysql_query($query_rsStateList, $conJP) or die(mysql_error());
$row_rsStateList = mysql_fetch_assoc($rsStateList);
$totalRows_rsStateList = mysql_num_rows($rsStateList);

mysql_select_db($database_conJP, $conJP);
$query_rsDistrict = "SELECT jp_location.location_name,    jp_district.dist_id, jp_district.dist_name FROM jp_location Inner Join   jp_district On jp_district.dist_parent_fk = jp_location.location_id";
$rsDistrict = mysql_query($query_rsDistrict, $conJP) or die(mysql_error());
$row_rsDistrict = mysql_fetch_assoc($rsDistrict);
$totalRows_rsDistrict = mysql_num_rows($rsDistrict);

mysql_select_db($database_conJP, $conJP);
$query_rsSubDistrictList = "Select   jp_subdistrict.subdist_name,   jp_district.dist_name From   jp_district Inner Join   jp_subdistrict On jp_subdistrict.district_id_fk = jp_district.dist_id";
$rsSubDistrictList = mysql_query($query_rsSubDistrictList, $conJP) or die(mysql_error());
$row_rsSubDistrictList = mysql_fetch_assoc($rsSubDistrictList);
$totalRows_rsSubDistrictList = mysql_num_rows($rsSubDistrictList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>State - District - SubDistrict</title>
<!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
</head>

<body>
<div class="container">
<p><h1>New District and Sub-District form</h1>
</p>
<h3>State</h3>
<table width="100%" border="0" align="center" class="table table-hover table-striped">
  <tr>
    <th width="60%">State</th>
    <th width="10%">District</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsStateList['location_name']; ?></td>
      <td align="center" valign="middle"><a href="new-district.php?state=<?php echo $row_rsStateList['location_id']; ?>"><span class="icon-plus"></span> District</a></td>
    </tr>
    <?php } while ($row_rsStateList = mysql_fetch_assoc($rsStateList)); ?>
</table>
	<br/>
  <?php echo $totalRows_rsStateList ?> Records Total
  <h3>District</h3>
  <table width="100%" border="0" align="center" class="table table-hover table-striped">
    <tr>
      <th width="55%">State</th>
      <th width="10%">District</th>
      <th width="10%">Sub-District</th>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo $row_rsDistrict['location_name']; ?></td>
        <td align="left" valign="middle"><?php echo $row_rsDistrict['dist_name']; ?></td>
        <td align="center" valign="middle"><a href="new-sub-district.php?dist_id=<?php echo $row_rsDistrict['dist_id']; ?>&amp;state=<?php echo $row_rsDistrict['location_name']; ?>"><span class="icon-plus"></span> Sub-District</a></td>
      </tr>
      <?php } while ($row_rsDistrict = mysql_fetch_assoc($rsDistrict)); ?>
  </table><br />
  <?php echo $totalRows_rsDistrict ?> Records Total
  <h3>Sub-District</h3>
<table width="100%" border="0" align="center" class="table table-hover table-striped">
  <tr>
    <th width="50%">District</th>
    <th>Sub-District</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_rsSubDistrictList['dist_name']; ?>&nbsp; </td>
      <td align="left" valign="middle"><?php echo $row_rsSubDistrictList['subdist_name']; ?></td>
    </tr>
    <?php } while ($row_rsSubDistrictList = mysql_fetch_assoc($rsSubDistrictList)); ?>
</table>
<br />
<?php echo $totalRows_rsSubDistrictList ?> Records Total

</div>
<br/><br/>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
</body>
</html>
<?php
mysql_free_result($rsStateList);

mysql_free_result($rsDistrict);

mysql_free_result($rsSubDistrictList);
?>
