<?php require_once('Connections/conPerak.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$colname_rsAdminName = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsAdminName = $_SESSION['MM_Username'];
}
mysql_select_db($database_conPerak, $conPerak);
$query_rsAdminName = sprintf("SELECT admin_name FROM jp_admin WHERE admin_name = %s", GetSQLValueString($colname_rsAdminName, "text"));
$rsAdminName = mysql_query($query_rsAdminName, $conPerak) or die(mysql_error());
$row_rsAdminName = mysql_fetch_assoc($rsAdminName);
$totalRows_rsAdminName = mysql_num_rows($rsAdminName);

mysql_select_db($database_conPerak, $conPerak);
$query_rsLanguageList = "SELECT * FROM jp_language_list";
$rsLanguageList = mysql_query($query_rsLanguageList, $conPerak) or die(mysql_error());
$row_rsLanguageList = mysql_fetch_assoc($rsLanguageList);
$totalRows_rsLanguageList = mysql_num_rows($rsLanguageList);

$maxRows_rsUserLists = 100;
$pageNum_rsUserLists = 0;
if (isset($_GET['pageNum_rsUserLists'])) {
  $pageNum_rsUserLists = $_GET['pageNum_rsUserLists'];
}
$startRow_rsUserLists = $pageNum_rsUserLists * $maxRows_rsUserLists;

mysql_select_db($database_conPerak, $conPerak);
// tweak for filter
$type_of_user = (int) mysql_real_escape_string(@$_GET['type_of_user']);
$activation = (int) mysql_real_escape_string(@$_GET['activation']);
$email = mysql_real_escape_string(@$_GET['email']);

if($email == "" && $type_of_user == '-1' && $activation == '-1'){
  $query_rsUserLists = "SELECT * FROM jp_users";
} elseif($email != "" && $type_of_user == '-1' && $activation == '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_email LIKE '%".$email."%'";
} elseif($email == "" && $type_of_user != '-1' && $activation == '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_type = ".$type_of_user;
} elseif($email == "" && $type_of_user == '-1' && $activation != '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE user_active = ".$activation;
} elseif($email != "" && $type_of_user != '-1' && $activation != '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_email LIKE '%".$email."%' AND users_type = '$type_of_user' AND user_active = '$activation'";
} else {
  $query_rsUserLists = "SELECT * FROM jp_users";
}
// ============================================
$query_limit_rsUserLists = sprintf("%s LIMIT %d, %d", $query_rsUserLists, $startRow_rsUserLists, $maxRows_rsUserLists);
$rsUserLists = mysql_query($query_limit_rsUserLists, $conPerak) or die(mysql_error());
$row_rsUserLists = mysql_fetch_assoc($rsUserLists);

if (isset($_GET['totalRows_rsUserLists'])) {
  $totalRows_rsUserLists = $_GET['totalRows_rsUserLists'];
} else {
  $all_rsUserLists = mysql_query($query_rsUserLists);
  $totalRows_rsUserLists = mysql_num_rows($all_rsUserLists);
}
$totalPages_rsUserLists = ceil($totalRows_rsUserLists/$maxRows_rsUserLists)-1;

$queryString_rsUserLists = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUserLists") == false && 
        stristr($param, "totalRows_rsUserLists") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUserLists = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUserLists = sprintf("&totalRows_rsUserLists=%d%s", $totalRows_rsUserLists, $queryString_rsUserLists);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Jobsperak Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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

    <?php include("header.php"); ?>

    <div class="container">

		<div style="text-align:center">
      
      <h1>Hello, <?php echo $row_rsAdminName['admin_name']; ?>! Here the list of all users.</h1>
      <p>I was listed all the users registered and here the details.</p><br/><br/>

      <div>
        <form action="exportToExcel.php" method="post" target="_blank" accept-charset="utf-8" class="form-inline">
            <label>Excel filename: <input type="text" name="excelName" value="" id="excelName" placeholder="What filename should be?"></label>
            <input type="submit" name="btnexport" value="Export to Excel" id="btnexport" class="btn btn-success">
            <input type="hidden" name="tableData" id="tableData" value="
            <?php 

              if (@$type_of_user == 2) {
                $query_rsUserLists = "SELECT
  jp_users.users_email,
  jp_users.users_fname,
  jp_users.users_lname,
  jp_users.users_type,
  jp_users.user_active,
  jp_employer.emp_name,
  jp_employer.emp_desc,
  jp_employer.emp_address,
  jp_employer.emp_tel,
  jp_employer.emp_email,
  jp_employer.emp_web,
  jp_industry.indus_name
From
  jp_users Inner Join
  jp_employer On jp_employer.users_id_fk = jp_users.users_id Inner Join
  jp_industry On jp_employer.emp_industry_id_fk = jp_industry.indus_id
Where
  jp_users.users_type = 2 And
  jp_users.user_active = 1";
                echo $query_rsUserLists; 
              } else {
                echo $query_rsUserLists; 
              }

            ?>">
          </form>  
      </div>

      <form action="users.php" method="get" name="filterUser">
      <table width="100%" border="0" class="table">
  <tr>
    <td width="32%" align="left" valign="middle">
    <label for="email">Email
    <input name="email" type="text" class="input-xlarge"></label></td>
    <td width="28%" align="left" valign="middle"><label for="active_status">
    Activation
      <select name="activation" id="select" class="input-medium">
        <option value="-1">All</option>
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </label></td>
    <td width="40%" align="left" valign="middle"><label for="type_of_user"> Type of User
      <select name="type_of_user" id="select2">
        <option value="-1">All</option>
        <option value="1">Jobseeker</option>
        <option value="2">Employer</option>
      </select>
    </label></td>
    <td>
    	<input name="filter" class="btn btn-primary" type="submit" value="Submit">
    </td>
    </tr>
</table>

      </form>
      <table border="0" class="table table-hover table-striped" align="center" width="100%">
        <tr>
          <th>users_email</th>
          <th>users_fname</th>
          <th>users_register</th>
          <th>user_active</th>
          <th>Type</th>
        </tr>
        <?php do { ?>
          <tr>
            <td align="left" valign="middle"><a href="users-details.php?recordID=<?php echo $row_rsUserLists['users_id']; ?>" target="_blank"> <?php echo $row_rsUserLists['users_email']; ?>&nbsp; </a></td>
            <td align="left" valign="middle"><?php echo $row_rsUserLists['users_fname']; ?>&nbsp;<?php echo $row_rsUserLists['users_lname']; ?></td>
            <td align="left" valign="middle"><?php echo $row_rsUserLists['users_register']; ?></td>
            <td align="left" valign="middle"><?php if($row_rsUserLists['user_active'] != 1) {echo "Not Active";} else {echo "Active";} ?></td>
            <td align="left" valign="middle"><?php if($row_rsUserLists['users_type'] != 1) {echo "Employer";} else {echo "Jobseeker";} ?></td>
        </tr>
          <?php } while ($row_rsUserLists = mysql_fetch_assoc($rsUserLists)); ?>
      </table>
      <br>
      <table border="0">
        <tr>
          <td><?php if ($pageNum_rsUserLists > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rsUserLists=%d%s", $currentPage, 0, $queryString_rsUserLists); ?>">First</a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rsUserLists > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rsUserLists=%d%s", $currentPage, max(0, $pageNum_rsUserLists - 1), $queryString_rsUserLists); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rsUserLists < $totalPages_rsUserLists) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rsUserLists=%d%s", $currentPage, min($totalPages_rsUserLists, $pageNum_rsUserLists + 1), $queryString_rsUserLists); ?>">Next</a>
          <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rsUserLists < $totalPages_rsUserLists) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rsUserLists=%d%s", $currentPage, $totalPages_rsUserLists, $queryString_rsUserLists); ?>">Last</a>
          <?php } // Show if not last page ?></td>
        </tr>
      </table>
Records <?php echo ($startRow_rsUserLists + 1) ?> to <?php echo min($startRow_rsUserLists + $maxRows_rsUserLists, $totalRows_rsUserLists) ?> of <?php echo $totalRows_rsUserLists ?> </div>

    </div> <!-- /container -->

	<?php include("footer.php"); ?>
    
  </body>
</html>
<?php
mysql_free_result($rsAdminName);

mysql_free_result($rsLanguageList);

mysql_free_result($rsUserLists);
?>
