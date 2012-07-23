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
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
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



mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads WHERE ads_enable_view = 1 ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$colname_rsJobsAdsDetails = "-1";
if (isset($_GET['jobAdsId'])) {
  $colname_rsJobsAdsDetails = $_GET['jobAdsId'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobsAdsDetails = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,  jp_employer.emp_pic,  jp_ads.*,   jp_industry.indus_name,   jp_location.location_name FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE jp_ads.ads_id = %s", GetSQLValueString($colname_rsJobsAdsDetails, "int"));
$rsJobsAdsDetails = mysql_query($query_rsJobsAdsDetails, $conJobsPerak) or die(mysql_error());
$row_rsJobsAdsDetails = mysql_fetch_assoc($rsJobsAdsDetails);
$totalRows_rsJobsAdsDetails = mysql_num_rows($rsJobsAdsDetails);

$colname_rsJsIdUser = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsJsIdUser = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJsIdUser = sprintf("SELECT * FROM jp_jobseeker WHERE users_id_fk = %s", GetSQLValueString($colname_rsJsIdUser, "int"));
$rsJsIdUser = mysql_query($query_rsJsIdUser, $conJobsPerak) or die(mysql_error());
$row_rsJsIdUser = mysql_fetch_assoc($rsJsIdUser);
$totalRows_rsJsIdUser = mysql_num_rows($rsJsIdUser);

$colname_rsJsID = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsJsID = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJsID = sprintf("SELECT * FROM jp_jobseeker WHERE users_id_fk = %s", GetSQLValueString($colname_rsJsID, "int"));
$rsJsID = mysql_query($query_rsJsID, $conJobsPerak) or die(mysql_error());
$row_rsJsID = mysql_fetch_assoc($rsJsID);
$totalRows_rsJsID = mysql_num_rows($rsJsID);

$currentJsID = $row_rsJsID['jobseeker_id'];
//$currentJobViewId = $row_rsJobsAdsDetails['ads_id'];
//$currentJobViewId = $_GET['jobAdsId'];

$colname_rsEmployerDetect = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsEmployerDetect = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerDetect = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsEmployerDetect, "int"));
$rsEmployerDetect = mysql_query($query_rsEmployerDetect, $conJobsPerak) or die(mysql_error());
$row_rsEmployerDetect = mysql_fetch_assoc($rsEmployerDetect);
$totalRows_rsEmployerDetect = mysql_num_rows($rsEmployerDetect);

$colname_rsIsActive = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsIsActive = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIsActive = sprintf("SELECT user_active FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsIsActive, "int"));
$rsIsActive = mysql_query($query_rsIsActive, $conJobsPerak) or die(mysql_error());
$row_rsIsActive = mysql_fetch_assoc($rsIsActive);
$totalRows_rsIsActive = mysql_num_rows($rsIsActive);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsArtCat = "SELECT * FROM jp_article_cat ORDER BY ac_namr ASC";
$rsArtCat = mysql_query($query_rsArtCat, $conJobsPerak) or die(mysql_error());
$row_rsArtCat = mysql_fetch_assoc($rsArtCat);
$totalRows_rsArtCat = mysql_num_rows($rsArtCat);

$colname_rsArticleURL = "-1";
if (isset($_GET['cid'])) {
  $colname_rsArticleURL = $_GET['cid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsArticleURL = sprintf("SELECT * FROM jp_article WHERE art_id = %s", GetSQLValueString($colname_rsArticleURL, "int"));
$rsArticleURL = mysql_query($query_rsArticleURL, $conJobsPerak) or die(mysql_error());
$row_rsArticleURL = mysql_fetch_assoc($rsArticleURL);
$totalRows_rsArticleURL = mysql_num_rows($rsArticleURL);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_application (app_id, ads_id_fk, js_id_fk, ads_app_date) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['app_id'], "int"),
                       GetSQLValueString($_POST['ads_id_fk'], "int"),
                       GetSQLValueString($_POST['js_id_fk'], "int"),
                       GetSQLValueString($_POST['ads_app_date'], "date"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());

  $insertGoTo = "jobsApply.php?employer_mail=" . $row_rsJobsAdsDetails['emp_email'] . "&jobseeker_mail=" . $_SESSION['MM_Username'] . "&jobTitle=" . $row_rsJobsAdsDetails['ads_title'] . "&employer_name=" . $row_rsJobsAdsDetails['emp_name'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
</head>

<body>



	<header id="header">

		<div class="center">
			<div class="left logo"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
			</div>

			<div class="right">
            	<?php if (!isset($_SESSION['MM_Username'])) { ?>
					<a href="login.php" title="Login">Login</a> &nbsp;|&nbsp;
                	<a href="registerJobSeeker.php" title="Register JobSeeker">
                    JobSeeker / Employer Registration</a>
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

		  <div id="content" class="search_container" style="width:610px; padding-top:10px;margin-top:30px;">
          	  <h2>Resource Center</h2>
              <br/><br/>
       	    
			<div>
            	<h3><?php echo $row_rsArticleURL['art_title']; ?></h3>
                <div><?php echo $row_rsArticleURL['art_body']; ?></div>
                
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
mysql_free_result($rsTenLatestJob);

mysql_free_result($rsJobsAdsDetails);

mysql_free_result($rsJsIdUser);

mysql_free_result($rsJsID);

mysql_free_result($rsEmployerDetect);

mysql_free_result($rsIsActive);

mysql_free_result($rsArtCat);

mysql_free_result($rsArticleURL);
?>