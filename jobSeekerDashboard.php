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
  $_SESSION['MM_UserID'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['MM_UserID']);
  unset($_SESSION['PrevUrl']);
	
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
$MM_authorizedUsers = "1";
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
<?php //$getJobAlertLoc = $row_rsUserJobAlert['jobP_1']; ?>
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

$colname_rsUserDashboard = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserDashboard = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserDashboard = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsUserDashboard, "int"));
$rsUserDashboard = mysql_query($query_rsUserDashboard, $conJobsPerak) or die(mysql_error());
$row_rsUserDashboard = mysql_fetch_assoc($rsUserDashboard);
$totalRows_rsUserDashboard = mysql_num_rows($rsUserDashboard);

$colname_rsUserJobAlert = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserJobAlert = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserJobAlert = sprintf("SELECT * FROM jp_jobpreferences WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserJobAlert, "int"));
$rsUserJobAlert = mysql_query($query_rsUserJobAlert, $conJobsPerak) or die(mysql_error());
$row_rsUserJobAlert = mysql_fetch_assoc($rsUserJobAlert);
$totalRows_rsUserJobAlert = mysql_num_rows($rsUserJobAlert);

$colname_rsJobAlertAds = $row_rsUserJobAlert['jobP_1'];
if (isset($row_rsUserJobAlert['jobP_1'])) {
  $colname_rsJobAlertAds = $row_rsUserJobAlert['jobP_1'];
}
$colLoc_rsJobAlertAds = $row_rsUserJobAlert['jobP_1'];
if (isset($colLoc_rsJobAlertAds)) {
  $colLoc_rsJobAlertAds = $row_rsUserJobAlert['jobP_1'];
}
$colSal_rsJobAlertAds = $row_rsUserJobAlert['jobP_salary'];
if (isset($colSal_rsJobAlertAds)) {
  $colSal_rsJobAlertAds = $row_rsUserJobAlert['jobP_salary'];
}
$colInd_rsJobAlertAds = $row_rsUserJobAlert['jobP_2'];
if (isset($colInd_rsJobAlertAds)) {
  $colInd_rsJobAlertAds = $row_rsUserJobAlert['jobP_2'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobAlertAds = sprintf("Select   jp_ads.* From   jp_ads Where   (jp_ads.ads_location = %s Or   jp_ads.ads_salary <= %s Or   jp_ads.ads_industry_id_fk = %s) And jp_ads.ads_enable_view = 1", GetSQLValueString($colLoc_rsJobAlertAds, "int"),GetSQLValueString($colSal_rsJobAlertAds, "int"),GetSQLValueString($colInd_rsJobAlertAds, "int"));
$rsJobAlertAds = mysql_query($query_rsJobAlertAds, $conJobsPerak) or die(mysql_error());
$row_rsJobAlertAds = mysql_fetch_assoc($rsJobAlertAds);
$totalRows_rsJobAlertAds = mysql_num_rows($rsJobAlertAds);

$colname_rsIsActive = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsIsActive = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIsActive = sprintf("SELECT user_active FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsIsActive, "int"));
$rsIsActive = mysql_query($query_rsIsActive, $conJobsPerak) or die(mysql_error());
$row_rsIsActive = mysql_fetch_assoc($rsIsActive);
$totalRows_rsIsActive = mysql_num_rows($rsIsActive);
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
<h2>JobSeeker Dashboard</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  
  <?php if ($row_rsIsActive['user_active'] != 0){ ?>
  <?php include("jobSeekerMenu.php"); ?>
  <?php } else { ?>
  	<span style="color:#FF0000">Please Activate your account. Check your mail or <a href="resent-activation.php?mail=<?php echo $_SESSION['MM_Username']; ?>">resend activation link</a>.</span>
  <?php } ?>
  
  <?php if ($row_rsIsActive['user_active'] != 0){ ?>
  <h3>Summary</h3><br/>
    
    <div class="resumebox">
    	<strong>Register at</strong> <?php echo $row_rsUserDashboard['users_register']; ?><br/><br/>
		<strong>Last Login at</strong> <?php echo $row_rsUserDashboard['users_last_login']; ?>
    </div>
    
    <div class="resumebox">
    	<p><strong>Job Alert</strong> based on Job Preferences Setting
  	  </p>
        <?php if ($totalRows_rsJobAlertAds == 0) { // Show if recordset empty ?>
  <p>No Job Alert from your setting.</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rsJobAlertAds > 0) { // Show if recordset not empty ?>
  <table width="500" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th width="250">Job Title</th>
      <th>Salary</th>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsJobAlertAds['ads_id']; ?>"><?php echo $row_rsJobAlertAds['ads_title']; ?></a></td>
        <td align="right" valign="middle">MYR&nbsp;<?php echo $row_rsJobAlertAds['ads_salary']; ?></td>
      </tr>
      <?php } while ($row_rsJobAlertAds = mysql_fetch_assoc($rsJobAlertAds)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
 
    </div>
    
     <?php } // if not active?>
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
mysql_free_result($rsUserDashboard);

mysql_free_result($rsUserJobAlert);

mysql_free_result($rsJobAlertAds);

mysql_free_result($rsIsActive);
?>
