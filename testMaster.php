<?php require_once('Connections/conJobsPerak.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_allUsers = 10;
$pageNum_allUsers = 0;
if (isset($_GET['pageNum_allUsers'])) {
  $pageNum_allUsers = $_GET['pageNum_allUsers'];
}
$startRow_allUsers = $pageNum_allUsers * $maxRows_allUsers;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_allUsers = "SELECT * FROM jp_users";
$query_limit_allUsers = sprintf("%s LIMIT %d, %d", $query_allUsers, $startRow_allUsers, $maxRows_allUsers);
$allUsers = mysql_query($query_limit_allUsers, $conJobsPerak) or die(mysql_error());
$row_allUsers = mysql_fetch_assoc($allUsers);

if (isset($_GET['totalRows_allUsers'])) {
  $totalRows_allUsers = $_GET['totalRows_allUsers'];
} else {
  $all_allUsers = mysql_query($query_allUsers);
  $totalRows_allUsers = mysql_num_rows($all_allUsers);
}
$totalPages_allUsers = ceil($totalRows_allUsers/$maxRows_allUsers)-1;

$queryString_allUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_allUsers") == false && 
        stristr($param, "totalRows_allUsers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_allUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_allUsers = sprintf("&totalRows_allUsers=%d%s", $totalRows_allUsers, $queryString_allUsers);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>users_id</td>
    <td>users_email</td>
    <td>users_pass</td>
    <td>users_register</td>
    <td>users_last_login</td>
    <td>users_fname</td>
    <td>users_lname</td>
    <td>users_type</td>
    <td>Edit</td>
    <td>user_active</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="testMasterDetails.php?recordID=<?php echo $row_allUsers['users_id']; ?>"> <?php echo $row_allUsers['users_id']; ?>&nbsp; </a></td>
      <td><?php echo $row_allUsers['users_email']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_pass']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_register']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_last_login']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_fname']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_lname']; ?>&nbsp; </td>
      <td><?php echo $row_allUsers['users_type']; ?>&nbsp; </td>
      <td><a href="#">Edit</a></td>
      <td><?php echo $row_allUsers['user_active']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_allUsers = mysql_fetch_assoc($allUsers)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_allUsers > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_allUsers=%d%s", $currentPage, 0, $queryString_allUsers); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_allUsers > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_allUsers=%d%s", $currentPage, max(0, $pageNum_allUsers - 1), $queryString_allUsers); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_allUsers < $totalPages_allUsers) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_allUsers=%d%s", $currentPage, min($totalPages_allUsers, $pageNum_allUsers + 1), $queryString_allUsers); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_allUsers < $totalPages_allUsers) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_allUsers=%d%s", $currentPage, $totalPages_allUsers, $queryString_allUsers); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_allUsers + 1) ?> to <?php echo min($startRow_allUsers + $maxRows_allUsers, $totalRows_allUsers) ?> of <?php echo $totalRows_allUsers ?>
</body>
</html>
<?php
mysql_free_result($allUsers);
?>
