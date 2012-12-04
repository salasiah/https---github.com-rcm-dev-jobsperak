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
  $insertSQL = sprintf("INSERT INTO jp_subdistrict (subdist_name, district_id_fk) VALUES (%s, %s)",
                       GetSQLValueString($_POST['subdist_name'], "text"),
                       GetSQLValueString($_POST['district_id_fk'], "int"));

  mysql_select_db($database_conJP, $conJP);
  $Result1 = mysql_query($insertSQL, $conJP) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsDistrictList = "-1";
if (isset($_GET['dist_id'])) {
  $colname_rsDistrictList = $_GET['dist_id'];
}
mysql_select_db($database_conJP, $conJP);
$query_rsDistrictList = sprintf("SELECT * FROM jp_district WHERE dist_id = %s", GetSQLValueString($colname_rsDistrictList, "int"));
$rsDistrictList = mysql_query($query_rsDistrictList, $conJP) or die(mysql_error());
$row_rsDistrictList = mysql_fetch_assoc($rsDistrictList);
$totalRows_rsDistrictList = mysql_num_rows($rsDistrictList);

$colname_rsSubDistrictList = "-1";
if (isset($_GET['dist_id'])) {
  $colname_rsSubDistrictList = $_GET['dist_id'];
}
mysql_select_db($database_conJP, $conJP);
$query_rsSubDistrictList = sprintf("SELECT * FROM jp_subdistrict WHERE district_id_fk = %s", GetSQLValueString($colname_rsSubDistrictList, "int"));
$rsSubDistrictList = mysql_query($query_rsSubDistrictList, $conJP) or die(mysql_error());
$row_rsSubDistrictList = mysql_fetch_assoc($rsSubDistrictList);
$totalRows_rsSubDistrictList = mysql_num_rows($rsSubDistrictList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Sub-District</title>
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
<h2>New Sub-District <?php echo $row_rsDistrictList['dist_name']; ?> in <?php echo $_GET['state']; ?></h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Sub-District Name:</td>
      <td align="left"><input type="text" name="subdist_name" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">District Name:</td>
      <td align="left"><select name="district_id_fk" id="district_id_fk">
        <?php
do {  
?>
        <option value="<?php echo $row_rsDistrictList['dist_id']?>"><?php echo $row_rsDistrictList['dist_name']?></option>
        <?php
} while ($row_rsDistrictList = mysql_fetch_assoc($rsDistrictList));
  $rows = mysql_num_rows($rsDistrictList);
  if($rows > 0) {
      mysql_data_seek($rsDistrictList, 0);
	  $row_rsDistrictList = mysql_fetch_assoc($rsDistrictList);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">State</td>
      <td align="left"><?php echo $_GET['state']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left"><a href="index.php">&laquo; Cancel</a> &middot; </td>
      <td align="left"><input type="submit" value="Insert Sub-District" class="btn btn-primary" /></td>
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
<h4>Existing Sub-District</h4>
<?php if ($totalRows_rsSubDistrictList > 0) { // Show if recordset not empty ?>
  <table width="500px" border="0" class="table-striped" align="center">
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsSubDistrictList['subdist_name']; ?></td>
      </tr>
      <?php } while ($row_rsSubDistrictList = mysql_fetch_assoc($rsSubDistrictList)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<div style="text-align:center">
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
mysql_free_result($rsDistrictList);

mysql_free_result($rsSubDistrictList);
?>
