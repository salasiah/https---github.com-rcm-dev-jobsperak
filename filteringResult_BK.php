<?php require_once('Connections/conJobsPerak.php'); ?>
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

$colname_rsEmployerProfile = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsEmployerProfile = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerProfile = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsEmployerProfile, "int"));
$rsEmployerProfile = mysql_query($query_rsEmployerProfile, $conJobsPerak) or die(mysql_error());
$row_rsEmployerProfile = mysql_fetch_assoc($rsEmployerProfile);
$totalRows_rsEmployerProfile = mysql_num_rows($rsEmployerProfile);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIndustry = "SELECT * FROM jp_industry WHERE industry_parent = 0";
$rsIndustry = mysql_query($query_rsIndustry, $conJobsPerak) or die(mysql_error());
$row_rsIndustry = mysql_fetch_assoc($rsIndustry);
$totalRows_rsIndustry = mysql_num_rows($rsIndustry);

$colname_rsCompanyInfoDetail = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsCompanyInfoDetail = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCompanyInfoDetail = sprintf("SELECT * FROM jp_employer WHERE users_id_fk = %s", GetSQLValueString($colname_rsCompanyInfoDetail, "int"));
$rsCompanyInfoDetail = mysql_query($query_rsCompanyInfoDetail, $conJobsPerak) or die(mysql_error());
$row_rsCompanyInfoDetail = mysql_fetch_assoc($rsCompanyInfoDetail);
$totalRows_rsCompanyInfoDetail = mysql_num_rows($rsCompanyInfoDetail);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLoc = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsLoc = mysql_query($query_rsLoc, $conJobsPerak) or die(mysql_error());
$row_rsLoc = mysql_fetch_assoc($rsLoc);
$totalRows_rsLoc = mysql_num_rows($rsLoc);

//$colname_rsEmployerId = $_SESSION['MM_UserID'];
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsEmployerId = $_SESSION['MM_UserID'];
}
$colname_rsEmployerId = "-1";
if (isset($_GET['emp_id'])) {
  $colname_rsEmployerId = $_GET['emp_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerId = sprintf("SELECT emp_id FROM jp_employer WHERE emp_id = %s", GetSQLValueString($colname_rsEmployerId, "int"));
$rsEmployerId = mysql_query($query_rsEmployerId, $conJobsPerak) or die(mysql_error());
$row_rsEmployerId = mysql_fetch_assoc($rsEmployerId);
$totalRows_rsEmployerId = mysql_num_rows($rsEmployerId);

$maxRows_rsJobSeekerList = 20;
$pageNum_rsJobSeekerList = 0;
if (isset($_GET['pageNum_rsJobSeekerList'])) {
  $pageNum_rsJobSeekerList = $_GET['pageNum_rsJobSeekerList'];
}
$startRow_rsJobSeekerList = $pageNum_rsJobSeekerList * $maxRows_rsJobSeekerList;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobSeekerList = "Select   jp_users.*,   jp_jobseeker.*,   jp_users.users_type As users_type1 From   jp_users Inner Join   jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Where   jp_users.user_active = 1 And   jp_users.users_type = 1";
$query_limit_rsJobSeekerList = sprintf("%s LIMIT %d, %d", $query_rsJobSeekerList, $startRow_rsJobSeekerList, $maxRows_rsJobSeekerList);
$rsJobSeekerList = mysql_query($query_limit_rsJobSeekerList, $conJobsPerak) or die(mysql_error());
$row_rsJobSeekerList = mysql_fetch_assoc($rsJobSeekerList);

if (isset($_GET['totalRows_rsJobSeekerList'])) {
  $totalRows_rsJobSeekerList = $_GET['totalRows_rsJobSeekerList'];
} else {
  $all_rsJobSeekerList = mysql_query($query_rsJobSeekerList);
  $totalRows_rsJobSeekerList = mysql_num_rows($all_rsJobSeekerList);
}
$totalPages_rsJobSeekerList = ceil($totalRows_rsJobSeekerList/$maxRows_rsJobSeekerList)-1;

$queryString_rsJobSeekerList = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobSeekerList") == false && 
        stristr($param, "totalRows_rsJobSeekerList") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobSeekerList = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobSeekerList = sprintf("&totalRows_rsJobSeekerList=%d%s", $totalRows_rsJobSeekerList, $queryString_rsJobSeekerList);
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
  $_SESSION['MM_UserID'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_UserID']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "sessionGateway.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Welcome to Jobsperak Portal</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
<style type="text/css">
#wrapper #middle #content .master_details h1 {
	color: #F00;
}
</style>
</head>

<body>



	<header id="header">

		<div class="center">
			<div class="left"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
			</div>

			<div class="right">
            	<?php if (!isset($_SESSION['MM_Username'])) { ?>
<a href="login.php" title="Login">Login</a> &nbsp;|&nbsp;
                	<a href="registerJobSeeker.php" title="Register JobSeeker">
                    Register JobSeeker</a>
				<?php } else { ?>
                	<strong>Hi, <?php echo $_SESSION['MM_Username']; ?></strong> 
                    &middot; <a href="sessionGateway.php">My Dashboard</a> &middot; (<a href="<?php echo $logoutAction ?>">Log Out</a>)
<?php }?>
    		</div>
			<div class="clear"></div>
		</div><!-- .center -->
		
		<?php include("main_menu.php"); ?>
	</header><!-- #header-->

	<div id="wrapper">
	
	<section id="middle">

		  <div id="content">
<h2>Employer Profile</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  <?php include("employer_menu.php"); ?><br/> 
<strong>Browse Resume</strong><br/><br/>
<h1 class="hide">Advance filtering goes here</h1>
<br/>

<table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable2">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Picture</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_rsJobSeekerList['users_fname']; ?> <?php echo $row_rsJobSeekerList['users_lname']; ?></td>
      <td align="center" valign="middle"><a href="jobSeekerResume.php?js_id=<?php echo $row_rsJobSeekerList['users_id']; ?>"><?php echo $row_rsJobSeekerList['users_email']; ?></a></td>
      <td align="center" valign="middle"><img src="<?php echo $row_rsJobSeekerList['jobseeker_pic']; ?>"></td>
    </tr>
    <?php } while ($row_rsJobSeekerList = mysql_fetch_assoc($rsJobSeekerList)); ?>
</table>

<div class="paginate"><a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, 0, $queryString_rsJobSeekerList); ?>">First</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, max(0, $pageNum_rsJobSeekerList - 1), $queryString_rsJobSeekerList); ?>">Previous</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, min($totalPages_rsJobSeekerList, $pageNum_rsJobSeekerList + 1), $queryString_rsJobSeekerList); ?>">Next</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, $totalPages_rsJobSeekerList, $queryString_rsJobSeekerList); ?>">Last</a> | Records <?php echo ($startRow_rsJobSeekerList + 1) ?> to <?php echo min($startRow_rsJobSeekerList + $maxRows_rsJobSeekerList, $totalRows_rsJobSeekerList) ?> of <?php echo $totalRows_rsJobSeekerList ?></div>
</div>

          </div><!-- #content-->
	
		  <aside id="sideRight">
          	  <?php include('full_content_sidebar.php'); ?>
          </aside>
			<!-- aside -->
			<!-- #sideRight -->


	</section><!-- #middle-->

	</div><!-- #wrapper-->

	<footer id="footer">
		<div class="center">
			<?php include("footer.php"); ?>
		</div><!-- .center -->
	</footer><!-- #footer -->



</body>
</html>
<?php
mysql_free_result($rsEmployerProfile);

mysql_free_result($rsIndustry);

mysql_free_result($rsCompanyInfoDetail);

mysql_free_result($rsLoc);

mysql_free_result($rsEmployerId);

mysql_free_result($rsJobSeekerList);
?>
