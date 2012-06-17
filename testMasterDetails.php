<?php require_once('Connections/conJobsPerak.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_DetailRS1 = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $conJobsPerak) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>users_id</td>
    <td><?php echo $row_DetailRS1['users_id']; ?></td>
  </tr>
  <tr>
    <td>users_email</td>
    <td><?php echo $row_DetailRS1['users_email']; ?></td>
  </tr>
  <tr>
    <td>users_pass</td>
    <td><?php echo $row_DetailRS1['users_pass']; ?></td>
  </tr>
  <tr>
    <td>users_register</td>
    <td><?php echo $row_DetailRS1['users_register']; ?></td>
  </tr>
  <tr>
    <td>users_last_login</td>
    <td><?php echo $row_DetailRS1['users_last_login']; ?></td>
  </tr>
  <tr>
    <td>users_fname</td>
    <td><?php echo $row_DetailRS1['users_fname']; ?></td>
  </tr>
  <tr>
    <td>users_lname</td>
    <td><?php echo $row_DetailRS1['users_lname']; ?></td>
  </tr>
  <tr>
    <td>users_type</td>
    <td><?php echo $row_DetailRS1['users_type']; ?></td>
  </tr>
  <tr>
    <td>user_active</td>
    <td><?php echo $row_DetailRS1['user_active']; ?></td>
  </tr>
</table>

</body>
</html><?php
mysql_free_result($DetailRS1);
?>