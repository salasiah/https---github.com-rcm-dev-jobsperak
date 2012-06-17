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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads WHERE ads_enable_view = 1 ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$maxRows_rsJobsOpening = 10;
$pageNum_rsJobsOpening = 0;
if (isset($_GET['pageNum_rsJobsOpening'])) {
  $pageNum_rsJobsOpening = $_GET['pageNum_rsJobsOpening'];
}
$startRow_rsJobsOpening = $pageNum_rsJobsOpening * $maxRows_rsJobsOpening;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobsOpening = "Select   jp_industry.indus_name,   jp_employer.emp_name,   jp_ads.* From   jp_ads Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id Where   jp_ads.ads_enable_view = 1 Order By   jp_ads.ads_date_published Desc";
$query_limit_rsJobsOpening = sprintf("%s LIMIT %d, %d", $query_rsJobsOpening, $startRow_rsJobsOpening, $maxRows_rsJobsOpening);
$rsJobsOpening = mysql_query($query_limit_rsJobsOpening, $conJobsPerak) or die(mysql_error());
$row_rsJobsOpening = mysql_fetch_assoc($rsJobsOpening);

if (isset($_GET['totalRows_rsJobsOpening'])) {
  $totalRows_rsJobsOpening = $_GET['totalRows_rsJobsOpening'];
} else {
  $all_rsJobsOpening = mysql_query($query_rsJobsOpening);
  $totalRows_rsJobsOpening = mysql_num_rows($all_rsJobsOpening);
}
$totalPages_rsJobsOpening = ceil($totalRows_rsJobsOpening/$maxRows_rsJobsOpening)-1;

$queryString_rsJobsOpening = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobsOpening") == false && 
        stristr($param, "totalRows_rsJobsOpening") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobsOpening = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobsOpening = sprintf("&totalRows_rsJobsOpening=%d%s", $totalRows_rsJobsOpening, $queryString_rsJobsOpening);
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
          	  <strong>Browse Jobs Opening</strong>
              <div class="topTableCaption">There are <?php echo $totalRows_rsJobsOpening ?> Job(s) opening.</div>
              <?php if ($totalRows_rsJobsOpening > 0) { // Show if recordset not empty ?>
  <table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable2">
    <tr>
      <th>Job Title</th>
      <th>Post By</th>
      <th>Salary</th>
      <th>Exp (Year)</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsJobsOpening['ads_id']; ?>"><?php echo $row_rsJobsOpening['ads_title']; ?></a> <br/><small><a href="jobsByIndustry.php?ads_industry_id=<?php echo $row_rsJobsOpening['ads_industry_id_fk']; ?>"><?php echo $row_rsJobsOpening['indus_name']; ?></a></small></td>
        <td><a href="employer.php?emp_id=<?php echo $row_rsJobsOpening['emp_id_fk']; ?>&employer=<?php echo $row_rsJobsOpening['emp_name']; ?>"><?php echo $row_rsJobsOpening['emp_name']; ?></a></td>
        <td>RM <?php echo $row_rsJobsOpening['ads_salary']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsJobsOpening['ads_y_exp']; ?></td>
      </tr>
      <?php } while ($row_rsJobsOpening = mysql_fetch_assoc($rsJobsOpening)); ?>
  </table>
              <div class="paginate"><a href="<?php printf("%s?pageNum_rsJobsOpening=%d%s", $currentPage, 0, $queryString_rsJobsOpening); ?>">First</a> | <a href="<?php printf("%s?pageNum_rsJobsOpening=%d%s", $currentPage, max(0, $pageNum_rsJobsOpening - 1), $queryString_rsJobsOpening); ?>">Previous</a> | <a href="<?php printf("%s?pageNum_rsJobsOpening=%d%s", $currentPage, min($totalPages_rsJobsOpening, $pageNum_rsJobsOpening + 1), $queryString_rsJobsOpening); ?>">Next</a> | <a href="<?php printf("%s?pageNum_rsJobsOpening=%d%s", $currentPage, $totalPages_rsJobsOpening, $queryString_rsJobsOpening); ?>">Last</a> | 
Records <?php echo ($startRow_rsJobsOpening + 1) ?> to <?php echo min($startRow_rsJobsOpening + $maxRows_rsJobsOpening, $totalRows_rsJobsOpening) ?> of <?php echo $totalRows_rsJobsOpening ?></div>
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

mysql_free_result($rsJobsOpening);
?>
