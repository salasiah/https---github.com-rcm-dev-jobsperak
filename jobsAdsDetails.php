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
$currentJobViewId = $_GET['jobAdsId'];
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIfExistApplied = "SELECT * FROM jp_application WHERE ads_id_fk = '$currentJobViewId'";
$rsIfExistApplied = mysql_query($query_rsIfExistApplied, $conJobsPerak) or die(mysql_error());
$row_rsIfExistApplied = mysql_fetch_assoc($rsIfExistApplied);
$totalRows_rsIfExistApplied = mysql_num_rows($rsIfExistApplied);

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
			<div class="left"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
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

		  <div id="content">
          	  <strong>Jobs Details</strong>
       	    <?php if ($totalRows_rsJobsAdsDetails > 0) { // Show if recordset not empty ?>
  <div class="master_details">
    <p><h2><?php echo $row_rsJobsAdsDetails['ads_title']; ?></h2></p>
    <p><strong>Description</strong><br/><?php echo $row_rsJobsAdsDetails['ads_details']; ?></p>
    <p><strong>Location</strong><br/><?php echo $row_rsJobsAdsDetails['location_name']; ?></p>
    <p><strong>Salary</strong><br/>MYR <?php echo $row_rsJobsAdsDetails['ads_salary']; ?></p>
    <p><strong>Year Experience</strong><br/><?php echo $row_rsJobsAdsDetails['ads_y_exp']; ?></p>
    <p><strong>Date Published</strong><br/><?php echo date('l, d/m/Y',strtotime($row_rsJobsAdsDetails['ads_date_published'])); ?></p>
    <p><strong>Industry</strong><br/><?php echo $row_rsJobsAdsDetails['indus_name']; ?></p>
  </div>
  <div class="apply_container">
  	
   <?php 
   // if xlogin display 
   if (!isset($_SESSION['MM_UserID'])) { ?>
            <a href="login.php">Login to Apply</a>
<?php 
	
	} else { 
	
		// check if view is employer
		$sql_isEmployer = "SELECT * FROM jp_users WHERE users_id = ".$_SESSION['MM_UserID'];
		$r_sql_isEmployer = mysql_query($sql_isEmployer);
		$objectRowisEmployer = mysql_fetch_object($r_sql_isEmployer);
	
		// check if user online is jobseeker
		// display button applied
		if($objectRowisEmployer->users_type == 1){
		
		
				// if login display
				// check details jobseeker
				
				$sql_js = "SELECT * FROM jp_jobseeker WHERE users_id_fk = ".$_SESSION['MM_UserID'];
				$r_sql_js = mysql_query($sql_js);
				$rows_js = mysql_num_rows($r_sql_js);
				$objectRowJobSeeker = mysql_fetch_object($r_sql_js);
				
				if($rows_js > 0) {
					
					// echo "boleh apply";
		
					// if boleh apply check dh apply ke blom
					$sql_dh_apply_or_blom = "SELECT * FROM jp_application WHERE js_id_fk = ".$objectRowJobSeeker->jobseeker_id." And ads_id_fk = ".$_GET['jobAdsId'];
					$r_sql_dh_apply_or_blom = mysql_query($sql_dh_apply_or_blom);
					$rows_r_sql_dh_apply_or_blom = mysql_num_rows($r_sql_dh_apply_or_blom);
					$object_row_r_sql_dh_apply_or_blom = mysql_fetch_object($r_sql_dh_apply_or_blom);
					
					if ($rows_r_sql_dh_apply_or_blom == NULL) {
						
						// if ada display already applied
						// echo "boleh Apply"; 
						?>
                        
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Apply this Job">
        </td>
      </tr>
    </table>
  <input type="hidden" name="app_id" value="">
  <input type="hidden" name="ads_id_fk" value="<?php echo $row_rsJobsAdsDetails['ads_id']; ?>">
  <input type="hidden" name="js_id_fk" value="<?php echo $row_rsJsIdUser['jobseeker_id']; ?>">
  <input type="hidden" name="ads_app_date" value="">
  <input type="hidden" name="MM_insert" value="form1">
</form>
                        
                        <?php
					
					} elseif ($rows_r_sql_dh_apply_or_blom > 0) {
						
						// if xde dlm application table, boleh apply the job 
						echo "Already applied this job";				
					}
					
					
				} else {
					
					
					echo "Full fill your details 1st";
					
					
				}
				
		
		
		} else {
		
			// else display status
			echo "Employer cant apply the job.";	
				
		}
		?>
    	
    <?php } // close xlogin ?>
    
   </div>
<div class="jobEmployer"><br/>
  <p>Posted By</p>
  <div class="left" style="width:120px; height:120px; margin-right:5px;">
  	<img src="media/employer/img/<?php echo $row_rsJobsAdsDetails['emp_pic']; ?>" width="80" height="80" border="0" />
  </div>
  <div class="left">
  <a href="employer.php?emp_id=<?php echo $row_rsJobsAdsDetails['emp_id_fk']; ?>&employer=<?php echo $row_rsJobsAdsDetails['emp_name']; ?>"><?php echo $row_rsJobsAdsDetails['emp_name']; ?></a><br/>
  <?php echo $row_rsJobsAdsDetails['emp_address']; ?><br/>
  <?php echo $row_rsJobsAdsDetails['emp_tel']; ?>
  <p><a href="http://<?php echo $row_rsJobsAdsDetails['emp_web']; ?>"><?php echo $row_rsJobsAdsDetails['emp_web']; ?></a></p>
  </div>
  <div class="clear"></div>
</div>
  
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rsJobsAdsDetails == 0) { // Show if recordset empty ?>
  	<div class="master_details"><p>No list in our Database.</p></div>
  <?php } // Show if recordset empty ?>
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

mysql_free_result($rsIfExistApplied);

mysql_free_result($rsEmployerDetect);

mysql_free_result($rsIsActive);
?>