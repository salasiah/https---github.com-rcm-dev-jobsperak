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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_message (msg_id, msg_subject, msg_body, ads_id_fk, jobseeker_id_fk, employer_id_fk) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['msg_id'], "int"),
                       GetSQLValueString($_POST['msg_subject'], "text"),
                       GetSQLValueString($_POST['msg_body'], "text"),
                       GetSQLValueString($_POST['ads_id_fk'], "int"),
                       GetSQLValueString($_POST['jobseeker_id_fk'], "int"),
                       GetSQLValueString($_POST['employer_id_fk'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());
  
  // Set accepted candidate
  $shortlisted_id = $_POST['shortId'];
  $sqlAcceptedCandidate = "UPDATE jp_shortlisted SET is_approve = 2 WHERE shortlisted_id = $shortlisted_id";
  $sqlAcceptedCandidateResult = mysql_query($sqlAcceptedCandidate);

  $insertGoTo = "employerApplicationShorlistedList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_shortlisted (shortlisted_id, ads_id_fk, joseeker_id_fk, employer_id_fk, `time`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['shortlisted_id'], "int"),
                       GetSQLValueString($_POST['ads_id_fk'], "int"),
                       GetSQLValueString($_POST['joseeker_id_fk'], "int"),
                       GetSQLValueString($_POST['employer_id_fk'], "int"),
                       GetSQLValueString($_POST['time'], "date"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());
  
  
  // update shortlisted
  $ads_id_fk = $_POST['ads_id_fk'];
  $js_id_fk = $_POST['joseeker_id_fk'];
  $sqlUpdate = "UPDATE jp_application SET is_shortlisted = '1' WHERE ads_id_fk = '$ads_id_fk' AND js_id_fk = '$js_id_fk'";
  $sqlUpdateResult = mysql_query($sqlUpdate);
  // ==================================

  $insertGoTo = "employerDashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$colname_rsJobAds = "-1";
if (isset($_GET['adsId'])) {
  $colname_rsJobAds = $_GET['adsId'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobAds = sprintf("SELECT * FROM jp_ads WHERE ads_id = %s", GetSQLValueString($colname_rsJobAds, "int"));
$rsJobAds = mysql_query($query_rsJobAds, $conJobsPerak) or die(mysql_error());
$row_rsJobAds = mysql_fetch_assoc($rsJobAds);
$totalRows_rsJobAds = mysql_num_rows($rsJobAds);

$currentJobAdsId = 7;
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCandidateApplied = "Select   Count(jp_application.ads_id_fk) From   jp_application Where   jp_application.ads_id_fk = $currentJobAdsId";
$rsCandidateApplied = mysql_query($query_rsCandidateApplied, $conJobsPerak) or die(mysql_error());
$row_rsCandidateApplied = mysql_fetch_assoc($rsCandidateApplied);
$totalRows_rsCandidateApplied = mysql_num_rows($rsCandidateApplied);

$colname_rsIsActive = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsIsActive = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIsActive = sprintf("SELECT user_active FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsIsActive, "int"));
$rsIsActive = mysql_query($query_rsIsActive, $conJobsPerak) or die(mysql_error());
$row_rsIsActive = mysql_fetch_assoc($rsIsActive);
$totalRows_rsIsActive = mysql_num_rows($rsIsActive);

$colname_rsCandidate = "-1";
if (isset($_GET['candidateID'])) {
  $colname_rsCandidate = $_GET['candidateID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCandidate = sprintf("Select   jp_users.users_fname,   jp_users.users_lname,   jp_jobseeker.jobseeker_id From   jp_jobseeker Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id Where   jp_jobseeker.jobseeker_id = %s", GetSQLValueString($colname_rsCandidate, "int"));
$rsCandidate = mysql_query($query_rsCandidate, $conJobsPerak) or die(mysql_error());
$row_rsCandidate = mysql_fetch_assoc($rsCandidate);
$totalRows_rsCandidate = mysql_num_rows($rsCandidate);

$currentEmployedId = $row_rsEmployed['emp_id'];
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsShortlistedCandidate = "SELECT jp_ads.ads_title,   jp_jobseeker.users_id_fk,   jp_users.users_fname,   jp_users.users_lname,   jp_users.users_email,   jp_shortlisted.employer_id_fk, jp_shortlisted.joseeker_id_fk, jp_shortlisted.ads_id_fk FROM jp_shortlisted Inner Join   jp_ads On jp_shortlisted.ads_id_fk = jp_ads.ads_id Inner Join   jp_jobseeker On jp_shortlisted.joseeker_id_fk = jp_jobseeker.jobseeker_id   Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id WHERE jp_shortlisted.employer_id_fk = $currentEmployedId And   jp_shortlisted.is_reject = 0 And   jp_shortlisted.is_approve = 0  ORDER BY jp_ads.ads_title";
$rsShortlistedCandidate = mysql_query($query_rsShortlistedCandidate, $conJobsPerak) or die(mysql_error());
$row_rsShortlistedCandidate = mysql_fetch_assoc($rsShortlistedCandidate);
$totalRows_rsShortlistedCandidate = mysql_num_rows($rsShortlistedCandidate);
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
  
  <?php if ($row_rsIsActive['user_active'] != 0){ ?>
  
  <?php include("employer_menu.php"); ?>
	
    <p>Send to admin about this candidate has been accepted.</p>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Subject:</td>
          <td><input type="text" placeholder="Subject for accepted" name="msg_subject" value="" size="32" id="msg_subject"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right" valign="top">Message Body:</td>
          <td><textarea name="msg_body" id="msg_body" cols="50" rows="5" placeholder="Message for approval"></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" id="submitApproval" value="Submit for approval"></td>
        </tr>
      </table>
      <input type="hidden" name="msg_id" value="">
      <input type="hidden" name="ads_id_fk" value="<?php echo $_GET['adsIdFk']; ?>">
      <input type="hidden" name="jobseeker_id_fk" value="<?php echo $_GET['jbSkerIdFk']; ?>">
      <input type="hidden" name="employer_id_fk" value="<?php echo $_GET['empIdFk']; ?>">
      <input type="hidden" name="MM_insert" value="form1">
      <input name="shortId" type="hidden" id="shortId" value="<?php echo $_GET['shortId']; ?>">
    </form>
    <p>&nbsp;</p>
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
<script>
$(document).ready(function(){
	$('#submitApproval').live('click', function(){
		var msg_subject = $('#msg_subject').val();
		var msg_body = $('#msg_body').val();
		
		if(msg_subject == '' && msg_body == ''){
			alert('Fill up subject and message');
			return false;
		}

	});
});
</script>
</html>
<?php
mysql_free_result($rsJobAds);

mysql_free_result($rsCandidateApplied);

mysql_free_result($rsIsActive);

mysql_free_result($rsCandidate);

mysql_free_result($rsShortlistedCandidate);

mysql_free_result($rsEmployed);

mysql_free_result($rsComDetail);
?>
