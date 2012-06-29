<?php require_once('Connections/conJobsPerak.php'); ?>
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



$colname_rsEmployed = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsEmployed = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployed = sprintf("SELECT * FROM jp_employer WHERE users_id_fk = %s", GetSQLValueString($colname_rsEmployed, "int"));
$rsEmployed = mysql_query($query_rsEmployed, $conJobsPerak) or die(mysql_error());
$row_rsEmployed = mysql_fetch_assoc($rsEmployed);
$totalRows_rsEmployed = mysql_num_rows($rsEmployed);

$colname_rsComDetail = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsComDetail = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsComDetail = sprintf("SELECT * FROM jp_employer WHERE users_id_fk = %s", GetSQLValueString($colname_rsComDetail, "int"));
$rsComDetail = mysql_query($query_rsComDetail, $conJobsPerak) or die(mysql_error());
$row_rsComDetail = mysql_fetch_assoc($rsComDetail);
$totalRows_rsComDetail = mysql_num_rows($rsComDetail);

$maxRows_rsAppsList = 20;
$pageNum_rsAppsList = 0;
if (isset($_GET['pageNum_rsAppsList'])) {
  $pageNum_rsAppsList = $_GET['pageNum_rsAppsList'];
}
$startRow_rsAppsList = $pageNum_rsAppsList * $maxRows_rsAppsList;

$colname_rsAppsList = "-1";
if (isset($_GET['appid'])) {
  $colname_rsAppsList = $_GET['appid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAppsList = sprintf("SELECT jp_users.users_email,   jp_jobseeker.jobseeker_pic,   jp_application.ads_app_date,   jp_users.users_fname,   jp_users.users_lname,   jp_application.js_id_fk,   jp_users.users_id FROM jp_application Inner Join   jp_jobseeker On jp_application.js_id_fk = jp_jobseeker.jobseeker_id Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id WHERE jp_application.ads_id_fk = %s AND jp_application.is_shortlisted = 0", GetSQLValueString($colname_rsAppsList, "int"));
$query_limit_rsAppsList = sprintf("%s LIMIT %d, %d", $query_rsAppsList, $startRow_rsAppsList, $maxRows_rsAppsList);
$rsAppsList = mysql_query($query_limit_rsAppsList, $conJobsPerak) or die(mysql_error());
$row_rsAppsList = mysql_fetch_assoc($rsAppsList);

if (isset($_GET['totalRows_rsAppsList'])) {
  $totalRows_rsAppsList = $_GET['totalRows_rsAppsList'];
} else {
  $all_rsAppsList = mysql_query($query_rsAppsList);
  $totalRows_rsAppsList = mysql_num_rows($all_rsAppsList);
}
$totalPages_rsAppsList = ceil($totalRows_rsAppsList/$maxRows_rsAppsList)-1;

$colname_rsJobAdsTitle = "-1";
if (isset($_GET['appid'])) {
  $colname_rsJobAdsTitle = $_GET['appid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobAdsTitle = sprintf("SELECT * FROM jp_ads WHERE ads_id = %s", GetSQLValueString($colname_rsJobAdsTitle, "int"));
$rsJobAdsTitle = mysql_query($query_rsJobAdsTitle, $conJobsPerak) or die(mysql_error());
$row_rsJobAdsTitle = mysql_fetch_assoc($rsJobAdsTitle);
$totalRows_rsJobAdsTitle = mysql_num_rows($rsJobAdsTitle);

$maxRows_rsJobAds = 30;
$pageNum_rsJobAds = 0;
if (isset($_GET['pageNum_rsJobAds'])) {
  $pageNum_rsJobAds = $_GET['pageNum_rsJobAds'];
}
$startRow_rsJobAds = $pageNum_rsJobAds * $maxRows_rsJobAds;

$colname_rsJobAds = $row_rsEmployed['emp_id'];
if (isset($row_rsEmployed['emp_id'])) {
  $colname_rsJobAds = $row_rsEmployed['emp_id'];
}

$colname_rsJobAds = $row_rsEmployed['emp_id'];

$currentJobAdsId = 7;
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
<h2>Employer Dashboard</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php //echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  <?php include("employer_menu.php"); ?>
  <br/>
  <p>List(s) of candidate under job ads <strong><?php echo ucfirst($row_rsJobAdsTitle['ads_title']); ?>.</strong></p>
  <?php if ($totalRows_rsAppsList > 0) { // Show if recordset not empty ?>
  <table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable2">
    <tr>
      <th>Name</th>
      <th>Date Applied</th>
      <th>Picture</th>
      <th>Actions</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="jobSeekerResume.php?js_id=<?php echo $row_rsAppsList['users_id']; ?>"><?php echo $row_rsAppsList['users_fname']; ?> <?php echo $row_rsAppsList['users_lname']; ?></a></td>
        <td align="center" valign="middle"><?php echo date('l, d/m/Y',strtotime($row_rsAppsList['ads_app_date'])); ?></td>
        <td align="center" valign="middle"><img src="<?php echo $row_rsAppsList['jobseeker_pic']; ?>" alt="" width="48"></td>
        <td align="center" valign="middle"><a href="employerApplicationReject.php?candidateID=<?php echo $row_rsAppsList['js_id_fk']; ?>&adsId=<?php echo $_GET['appid']; ?>&action=reject"><img src="img/Delete-icon.png" alt="reject" width="16" height="16" border="0" title="Reject this Candidate"></a> &middot; <a href="employerApplicationShorlisted.php?candidateID=<?php echo $row_rsAppsList['js_id_fk']; ?>&adsId=<?php echo $_GET['appid']; ?>&action=reject"><img src="img/Document-Write-icon.png" alt="shortlisted" width="16" height="16" border="0" title="Shorlist this Candidate"></a>
        </td>
      </tr>
      <?php } while ($row_rsAppsList = mysql_fetch_assoc($rsAppsList)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
  
  <?php if ($totalRows_rsAppsList == 0) { // Show if recordset not empty ?>
  No Candidate applied under this Job Ads
  <?php } // Show if recordset not empty ?>
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
mysql_free_result($rsEmployed);

mysql_free_result($rsComDetail);

mysql_free_result($rsAppsList);

mysql_free_result($rsJobAdsTitle);
?>
