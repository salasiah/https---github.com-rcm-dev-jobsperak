<?php require_once('Connections/conJobsPerak.php'); ?>
<?php 

	// REMOVE THIS IF YOU WANT TO DISPLAY THE SERVER BEHAVIOR INSERT RECORD
  	// Mail to candidate and employer
	
	$employer_mail = $_GET['employer_mail'];
	$jobseeker_mail = $_GET['jobseeker_mail'];
	$jobsTitle = $_GET['jobTitle'];
	$employer_name = $_GET['employer_name'];
	
  	// Send copy to jobseeker
	$to  = $jobseeker_mail;
	
	// subject
	$subject = 'JobsPerak Recruitment Portal- Your application has been submited.';
	
	// message
	$message = '
	<html>
	<head>
	  <title>Your application has been submited.</title>
	</head>
	<body>
	  <p>Here the details of the Job</p>
	  <table>
		<tr>
		  <td><strong>Job Title</strong></td>
		</tr>
		<tr>
		  <td>'.$jobsTitle.'</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  <td><strong>Company</strong></td>
		</tr>
		<tr>
		  <td>'.$employer_name.'</td>
		</tr>
	  </table>
	</body>
	</html>
	';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'From: no-replay  <no-reply@jobsperak.com>' . "\r\n";
	
	// Mail it
	mail($to, $subject, $message, $headers);
	
	
	
	// tell employer they got the application
	// Send copy to jobseeker
	$to_employer  = $employer_mail;
	
	$subject_employer = 'JobsPerak Recruitment Portal - You have received new application ';
	$subject_employer .= 'for '.$jobsTitle;
	
	$message_employer = 'Hi, You have received new application for '.$jobsTitle;
	$message_employer .= ' Check the application now at http://www.jobsperak.com/v1/employerDashboard.php';
	
	$headers_employer = 'From: no-reply@jobsperak.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	// Mail it
	mail($to_employer, $subject_employer, $message_employer, $headers_employer);
  // ====================================================================================

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
          	  <strong>Jobs Applied</strong>
            <div class="master_details"><br/>
            <strong>Your Application has been sent.</strong> <a href="index.php">Search more job</a></div>
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
?>
