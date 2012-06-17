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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads WHERE ads_enable_view = 1 ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$maxRows_rsJobByLocation = 10;
$pageNum_rsJobByLocation = 0;
if (isset($_GET['pageNum_rsJobByLocation'])) {
  $pageNum_rsJobByLocation = $_GET['pageNum_rsJobByLocation'];
}
$startRow_rsJobByLocation = $pageNum_rsJobByLocation * $maxRows_rsJobByLocation;

$colname_rsJobByLocation = "-1";
if (isset($_GET['ads_location'])) {
  $colname_rsJobByLocation = $_GET['ads_location'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobByLocation = sprintf("Select   jp_industry.indus_name,   jp_employer.emp_name,   jp_ads.*,   jp_location.location_name From   jp_ads Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id Where   jp_ads.ads_location = %s And   jp_ads.ads_enable_view = 1", GetSQLValueString($colname_rsJobByLocation, "int"));
$query_limit_rsJobByLocation = sprintf("%s LIMIT %d, %d", $query_rsJobByLocation, $startRow_rsJobByLocation, $maxRows_rsJobByLocation);
$rsJobByLocation = mysql_query($query_limit_rsJobByLocation, $conJobsPerak) or die(mysql_error());
$row_rsJobByLocation = mysql_fetch_assoc($rsJobByLocation);

if (isset($_GET['totalRows_rsJobByLocation'])) {
  $totalRows_rsJobByLocation = $_GET['totalRows_rsJobByLocation'];
} else {
  $all_rsJobByLocation = mysql_query($query_rsJobByLocation);
  $totalRows_rsJobByLocation = mysql_num_rows($all_rsJobByLocation);
}
$totalPages_rsJobByLocation = ceil($totalRows_rsJobByLocation/$maxRows_rsJobByLocation)-1;

$queryString_rsJobByLocation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobByLocation") == false && 
        stristr($param, "totalRows_rsJobByLocation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobByLocation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobByLocation = sprintf("&totalRows_rsJobByLocation=%d%s", $totalRows_rsJobByLocation, $queryString_rsJobByLocation);
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
          	  <strong class="title"><h2><?php echo ucfirst($_GET['location']); ?></h2></strong>
              <div class="topTableCaption"><?php echo $totalRows_rsJobByLocation ?> Job(s) Posted in <?php echo ucfirst($_GET['location']); ?></div><br/>
              <?php if ($totalRows_rsJobByLocation > 0) { // Show if recordset not empty ?>
  <table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable2">
    <tr>
      <th>Job Title</th>
      <th>Post By</th>
      <th>Salary</th>
      <th>Exp (Year)</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsJobByLocation['ads_id']; ?>"><?php echo $row_rsJobByLocation['ads_title']; ?></a> <br/><small><a href="jobsByIndustry.php?ads_industry_id_fk=<?php echo $row_rsJobByLocation['ads_industry_id_fk']; ?>&industry=<?php echo $row_rsJobByLocation['indus_name']; ?>"><?php echo $row_rsJobByLocation['indus_name']; ?></a></small></td>
        <td><a href="employer.php?emp_id=<?php echo $row_rsJobByLocation['emp_id_fk']; ?>&employer=<?php echo $row_rsJobByLocation['emp_name']; ?>"><?php echo $row_rsJobByLocation['emp_name']; ?></a></td>
        <td>RM <?php echo $row_rsJobByLocation['ads_salary']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsJobByLocation['ads_y_exp']; ?></td>
      </tr>
      <?php } while ($row_rsJobByLocation = mysql_fetch_assoc($rsJobByLocation)); ?>
  </table>
              <div class="paginate"><a href="<?php printf("%s?pageNum_rsJobByLocation=%d%s", $currentPage, 0, $queryString_rsJobByLocation); ?>">First</a> | <a href="<?php printf("%s?pageNum_rsJobByLocation=%d%s", $currentPage, max(0, $pageNum_rsJobByLocation - 1), $queryString_rsJobByLocation); ?>">Previous</a> | <a href="<?php printf("%s?pageNum_rsJobByLocation=%d%s", $currentPage, min($totalPages_rsJobByLocation, $pageNum_rsJobByLocation + 1), $queryString_rsJobByLocation); ?>">Next</a> | <a href="<?php printf("%s?pageNum_rsJobByLocation=%d%s", $currentPage, $totalPages_rsJobByLocation, $queryString_rsJobByLocation); ?>">Last</a></div>
                <?php } // Show if recordset not empty ?>
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

mysql_free_result($rsJobByLocation);
?>
