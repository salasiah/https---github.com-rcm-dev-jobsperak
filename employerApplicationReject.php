<?php require_once('Connections/conJobsPerak.php');

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
  $insertSQL = sprintf("INSERT INTO jp_reason (reason_id, reason_remark, jobseeker_id_fk, ads_id_fk, employer_id_fk, `time`) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['reason_id'], "int"),
                       GetSQLValueString($_POST['reason_remark'], "text"),
                       GetSQLValueString($_POST['jobseeker_id_fk'], "int"),
                       GetSQLValueString($_POST['ads_id_fk'], "int"),
                       GetSQLValueString($_POST['employer_id_fk'], "int"),
                       GetSQLValueString($_POST['time'], "date"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());
  
  
  //insert into reject table
  $ads_id_fk = $_POST['ads_id_fk'];
  $jobseeker_id_fk = $_POST['jobseeker_id_fk'];
  $employer_id_fk = $_POST['employer_id_fk'];
  
  $sqlReject = "INSERT INTO jp_reject (reject_id, ads_id_fk, jobseeker_id_fk, employer_id_fk) VALUES ('', '$ads_id_fk', '$jobseeker_id_fk', '$employer_id_fk')";
  $sqlRejectResult = mysql_query($sqlReject);
  
  //Delet from application table of the user
  $sqlDeleteApplication = "DELETE FROM jp_application WHERE ads_id_fk = '$ads_id_fk' AND js_id_fk = '$jobseeker_id_fk'";
  $sqlDeleteResut = mysql_query($sqlDeleteApplication);
  
  //Set is_reject at shortlisted table
  $sqlSetRejectShortlisted = "UPDATE jp_shortlisted SET is_reject = 1 WHERE ads_id_fk = '$ads_id_fk' AND joseeker_id_fk = '$jobseeker_id_fk'";
  $sqlSetRejectShortlistedResut = mysql_query($sqlSetRejectShortlisted);
  
  // =========================================================================================

  $insertGoTo = "employerDashboard.php?appid=" . $_GET['adsId'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsCandidate = "-1";
if (isset($_GET['candidateID'])) {
  $colname_rsCandidate = $_GET['candidateID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCandidate = sprintf("Select   jp_users.users_fname,   jp_users.users_lname,   jp_jobseeker.jobseeker_id From   jp_users Inner Join   jp_jobseeker On jp_jobseeker.jobseeker_tel = jp_users.users_id Where   jp_jobseeker.jobseeker_id = %s", GetSQLValueString($colname_rsCandidate, "int"));
$rsCandidate = mysql_query($query_rsCandidate, $conJobsPerak) or die(mysql_error());
$row_rsCandidate = mysql_fetch_assoc($rsCandidate);
$totalRows_rsCandidate = mysql_num_rows($rsCandidate);

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
if (isset($_GET['candidateID'])) {
  $colname_rsAppsList = $_GET['candidateID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAppsList = sprintf("SELECT jp_users.users_email,   jp_jobseeker.jobseeker_pic,   jp_application.ads_app_date,   jp_users.users_fname,   jp_users.users_lname,   jp_application.js_id_fk,   jp_users.users_id FROM jp_application Inner Join   jp_jobseeker On jp_application.js_id_fk = jp_jobseeker.jobseeker_id Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id WHERE jp_application.ads_id_fk = %s", GetSQLValueString($colname_rsAppsList, "int"));
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
if (isset($_GET['adsId'])) {
  $colname_rsJobAdsTitle = $_GET['adsId'];
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

$colname_rsCandidateURL = "-1";
if (isset($_GET['candidateID'])) {
  $colname_rsCandidateURL = $_GET['candidateID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCandidateURL = sprintf("Select   jp_users.users_fname,   jp_users.users_lname,   jp_jobseeker.jobseeker_id From   jp_jobseeker Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id Where   jp_jobseeker.jobseeker_id = %s", GetSQLValueString($colname_rsCandidateURL, "int"));
$rsCandidateURL = mysql_query($query_rsCandidateURL, $conJobsPerak) or die(mysql_error());
$row_rsCandidateURL = mysql_fetch_assoc($rsCandidateURL);
$totalRows_rsCandidateURL = mysql_num_rows($rsCandidateURL);
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
    <script language="javascript" src="js/jquery-1.7.1.min.js"></script>
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
  <p>Reason for Rejection<strong>.</strong></p>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Jobs Title</td>
        <td><?php echo $row_rsJobAdsTitle['ads_title']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Candidate Name:</td>
        <td><?php echo $row_rsCandidateURL['users_fname']; ?> <?php echo $row_rsCandidateURL['users_lname']; ?></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Remark:</td>
        <td><textarea name="reason_remark" cols="50" rows="5" id="reason_remark"></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" id="submitReason" value="Reject &amp; Submit Reason"></td>
      </tr>
    </table>
    <input type="hidden" name="reason_id" value="">
    <input name="jobseeker_id_fk" type="hidden" value="<?php echo $_GET['candidateID']; ?>">
    <input type="hidden" name="ads_id_fk" value="<?php echo $row_rsJobAdsTitle['ads_id']; ?>">
    <input name="employer_id_fk" type="hidden" value="<?php echo $row_rsEmployed['emp_id']; ?>">
    <input type="hidden" name="time" value="">
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <p>&nbsp;</p>
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
<script>
$(document).ready(function(){
	$('#submitReason').live('click', function(){
		var q = $('#reason_remark').val();
		
		if(q == ''){
			alert('Fill a reason!');
			return false;
		} else {
			
			var answer = confirm('Are you sure you want to delete this?');
			
			if(answer){
				return true;
			} else {
				return false;
			}
			
			
		}

	});
});
</script>
</html>
<?php
mysql_free_result($rsCandidate);

mysql_free_result($rsEmployed);

mysql_free_result($rsComDetail);

mysql_free_result($rsAppsList);

mysql_free_result($rsJobAdsTitle);

mysql_free_result($rsCandidateURL);
?>
