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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_district (dist_name, dist_parent_fk) VALUES (%s, %s)",
                       GetSQLValueString($_POST['dist_name'], "text"),
                       GetSQLValueString($_POST['dist_parent_fk'], "int"));

  mysql_select_db($database_conJP, $conJP);
  $Result1 = mysql_query($insertSQL, $conJP) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsState = "-1";
if (isset($_GET['state'])) {
  $colname_rsState = $_GET['state'];
}
mysql_select_db($database_conJP, $conJP);
$query_rsState = sprintf("SELECT * FROM jp_location WHERE location_id = %s AND location_parent = 0", GetSQLValueString($colname_rsState, "int"));
$rsState = mysql_query($query_rsState, $conJP) or die(mysql_error());
$row_rsState = mysql_fetch_assoc($rsState);
$totalRows_rsState = "-1";
if (isset($_GET['state'])) {
  $totalRows_rsState = $_GET['state'];
}
mysql_select_db($database_conJP, $conJP);
$query_rsState = sprintf("SELECT * FROM jp_location WHERE location_id = %s AND location_parent = 0", GetSQLValueString($colname_rsState, "int"));
$rsState = mysql_query($query_rsState, $conJP) or die(mysql_error());
$row_rsState = mysql_fetch_assoc($rsState);
$totalRows_rsState = mysql_num_rows($rsState);

$colname_rsDistrictByState = "-1";
if (isset($_GET['state'])) {
  $colname_rsDistrictByState = $_GET['state'];
}
mysql_select_db($database_conJP, $conJP);
$query_rsDistrictByState = sprintf("SELECT * FROM jp_district WHERE dist_parent_fk = %s", GetSQLValueString($colname_rsDistrictByState, "int"));
$rsDistrictByState = mysql_query($query_rsDistrictByState, $conJP) or die(mysql_error());
$row_rsDistrictByState = mysql_fetch_assoc($rsDistrictByState);
$totalRows_rsDistrictByState = mysql_num_rows($rsDistrictByState);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New District</title>
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
<div style="text-align:center">
<h2>New District for <?php echo $row_rsState['location_name']; ?></h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">State:</td>
      <td align="left"><select name="dist_parent_fk">
        <?php
do {  
?>
        <option value="<?php echo $row_rsState['location_id']?>"<?php if (!(strcmp($row_rsState['location_id'], $row_rsState['location_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsState['location_name']?></option>
        <?php
} while ($row_rsState = mysql_fetch_assoc($rsState));
  $rows = mysql_num_rows($rsState);
  if($rows > 0) {
      mysql_data_seek($rsState, 0);
	  $row_rsState = mysql_fetch_assoc($rsState);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">District Name:</td>
      <td align="left"><input type="text" name="dist_name" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left"><a href="index.php">&laquo; Cancel</a> &middot; </td>
      <td align="left"><input type="submit" value="Insert District" class="btn btn-primary" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<br/>
<h4>Existing District Available</h4>
<?php if ($totalRows_rsDistrictByState > 0) { // Show if recordset not empty ?>
  <table width="500px" border="0" align="center" class="table-striped">
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsDistrictByState['dist_name']; ?></td>
      </tr>
      <?php } while ($row_rsDistrictByState = mysql_fetch_assoc($rsDistrictByState)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</div>
<p>&nbsp;</p>
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
mysql_free_result($rsState);

mysql_free_result($rsDistrictByState);
?>
