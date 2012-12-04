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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_news (news_id, news_title, news_desc, news_date, news_status) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['news_id'], "int"),
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['news_desc'], "text"),
                       GetSQLValueString($_POST['news_date'], "text"),
                       GetSQLValueString($_POST['news_status'], "text"));

  mysql_select_db($database_conPerak, $conPerak);
  $Result1 = mysql_query($insertSQL, $conPerak) or die(mysql_error());

  $insertGoTo = "newsfeed.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$maxRows_rsJobadsLists = 100;
$pageNum_rsJobadsLists = 0;
if (isset($_GET['pageNum_rsJobadsLists'])) {
  $pageNum_rsJobadsLists = $_GET['pageNum_rsJobadsLists'];
}
$startRow_rsJobadsLists = $pageNum_rsJobadsLists * $maxRows_rsJobadsLists;

mysql_select_db($database_conPerak, $conPerak);
$query_rsJobadsLists = "Select   jp_industry.indus_name,   jp_employer.emp_name,   jp_ads.*,   jp_location.location_name From   jp_ads Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id";
$query_limit_rsJobadsLists = sprintf("%s LIMIT %d, %d", $query_rsJobadsLists, $startRow_rsJobadsLists, $maxRows_rsJobadsLists);
$rsJobadsLists = mysql_query($query_limit_rsJobadsLists, $conPerak) or die(mysql_error());
$row_rsJobadsLists = mysql_fetch_assoc($rsJobadsLists);

if (isset($_GET['totalRows_rsJobadsLists'])) {
  $totalRows_rsJobadsLists = $_GET['totalRows_rsJobadsLists'];
} else {
  $all_rsJobadsLists = mysql_query($query_rsJobadsLists);
  $totalRows_rsJobadsLists = mysql_num_rows($all_rsJobadsLists);
}
$totalPages_rsJobadsLists = ceil($totalRows_rsJobadsLists/$maxRows_rsJobadsLists)-1;

$queryString_rsNews = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsNews") == false && 
        stristr($param, "totalRows_rsNews") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsNews = "&" . htmlentities(implode("&", $newParams));
  }
}

$queryString_rsJobadsLists = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobadsLists") == false && 
        stristr($param, "totalRows_rsJobadsLists") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobadsLists = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobadsLists = sprintf("&totalRows_rsJobadsLists=%d%s", $totalRows_rsJobadsLists, $queryString_rsJobadsLists);

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
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_type = '".$type_of_user."'";
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
        
        <h1>Hello, <?php echo $row_rsAdminName['admin_name']; ?>! Here the news feed.</h1>
        <p>I was listed all the news and here the details.</p>
        <div>
       	  <a href="newsfeed.php">&larr; Cancel</a></div>
        <br/>
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center" class="table table-striped">
            <tr valign="baseline">
              <td nowrap align="right">Title</td>
              <td><input type="text" name="news_title" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right" valign="top">Description</td>
              <td><textarea name="news_desc" cols="500" rows="10" style="width:500px"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Date</td>
              <td><input type="text" name="news_date" value="" size="32"> <em>ex: 27-11-2012</em></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Status</td>
              <td>
                <select name="news_status">
                  <option value="pending">Pending</option>
                  <option value="published">Publish</option>
                </select>
              </td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Insert News" class="btn btn-success"></td>
            </tr>
          </table>
          <input type="hidden" name="news_id" value="">
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;</p>
<br/>
  		</div>

    </div> <!-- /container -->

	<?php include("footer.php"); ?>
    
  </body>
</html>
<?php
mysql_free_result($rsAdminName);

mysql_free_result($rsLanguageList);

mysql_free_result($rsJobadsLists);

mysql_free_result($rsUserLists);
?>
