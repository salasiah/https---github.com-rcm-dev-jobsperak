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

$colname_rsEmployerDetails = "-1";
if (isset($_GET['emp_id'])) {
  $colname_rsEmployerDetails = $_GET['emp_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerDetails = sprintf("Select   jp_employer.*,   jp_industry.indus_name From   jp_employer Inner Join   jp_industry On jp_employer.emp_industry_id_fk = jp_industry.indus_id Where   jp_employer.emp_id = %s", GetSQLValueString($colname_rsEmployerDetails, "int"));
$rsEmployerDetails = mysql_query($query_rsEmployerDetails, $conJobsPerak) or die(mysql_error());
$row_rsEmployerDetails = mysql_fetch_assoc($rsEmployerDetails);
$totalRows_rsEmployerDetails = mysql_num_rows($rsEmployerDetails);

$maxRows_rsEmployerJobLists = 5;
$pageNum_rsEmployerJobLists = 0;
if (isset($_GET['pageNum_rsEmployerJobLists'])) {
  $pageNum_rsEmployerJobLists = $_GET['pageNum_rsEmployerJobLists'];
}
$startRow_rsEmployerJobLists = $pageNum_rsEmployerJobLists * $maxRows_rsEmployerJobLists;

$colname_rsEmployerJobLists = "-1";
if (isset($_GET['emp_id'])) {
  $colname_rsEmployerJobLists = $_GET['emp_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerJobLists = sprintf("Select   jp_ads.ads_id,   jp_ads.ads_title,   jp_ads.emp_id_fk,   jp_ads.ads_enable_view,   jp_ads.ads_date_published From   jp_ads Where   jp_ads.emp_id_fk = %s And   jp_ads.ads_enable_view = 1 Order By   jp_ads.ads_date_published Desc", GetSQLValueString($colname_rsEmployerJobLists, "int"));
$query_limit_rsEmployerJobLists = sprintf("%s LIMIT %d, %d", $query_rsEmployerJobLists, $startRow_rsEmployerJobLists, $maxRows_rsEmployerJobLists);
$rsEmployerJobLists = mysql_query($query_limit_rsEmployerJobLists, $conJobsPerak) or die(mysql_error());
$row_rsEmployerJobLists = mysql_fetch_assoc($rsEmployerJobLists);

if (isset($_GET['totalRows_rsEmployerJobLists'])) {
  $totalRows_rsEmployerJobLists = $_GET['totalRows_rsEmployerJobLists'];
} else {
  $all_rsEmployerJobLists = mysql_query($query_rsEmployerJobLists);
  $totalRows_rsEmployerJobLists = mysql_num_rows($all_rsEmployerJobLists);
}
$totalPages_rsEmployerJobLists = ceil($totalRows_rsEmployerJobLists/$maxRows_rsEmployerJobLists)-1;
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
          	  Viewing : <strong><?php echo ucfirst($_GET['employer']); ?></strong>
              <?php if ($totalRows_rsEmployerDetails > 0) { // Show if recordset not empty ?>
  <div class="master_details">
    <p><h2><?php echo $row_rsEmployerDetails['emp_name']; ?></h2></p>
    <p><br>
      <strong>Descriptions</strong><br> 
      <?php echo $row_rsEmployerDetails['emp_desc']; ?></p>
    <p><strong>Industry<br>
    </strong><?php echo $row_rsEmployerDetails['indus_name']; ?></p>
    <p><?php echo $row_rsEmployerDetails['emp_address']; ?><br>
      <?php echo $row_rsEmployerDetails['emp_tel']; ?><br>
      <?php echo $row_rsEmployerDetails['emp_email']; ?><br>
      <a href="http://<?php echo $row_rsEmployerDetails['emp_web']; ?>" title="<?php echo $row_rsEmployerDetails['emp_web']; ?>"><?php echo $row_rsEmployerDetails['emp_web']; ?></a></p>
<p><?php 
				if($row_rsEmployerDetails['emp_featured'] == 1)
				{
					echo "Premium Subscription";
				} else 
				{
					echo "Basic Subcription";
				} ?></p>
    
  </div>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rsEmployerDetails == 0) { // Show if recordset empty ?>
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

mysql_free_result($rsEmployerDetails);

mysql_free_result($rsEmployerJobLists);
?>
