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
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$maxRows_rsQueryJob = 10;
$pageNum_rsQueryJob = 0;
if (isset($_GET['pageNum_rsQueryJob'])) {
  $pageNum_rsQueryJob = $_GET['pageNum_rsQueryJob'];
}
$startRow_rsQueryJob = $pageNum_rsQueryJob * $maxRows_rsQueryJob;

$colname_rsQueryJob = "-1";
if (isset($_GET['q'])) {
  $colname_rsQueryJob = $_GET['q'];
}
$exp_rsQueryJob = "0";
if (isset($_GET['year_exp'])) {
  $exp_rsQueryJob = $_GET['year_exp'];
}
$salaries_rsQueryJob = "0";
if (isset($_GET['salary'])) {
  $salaries_rsQueryJob = $_GET['salary'];
}
$location_rsQueryJob = "0";
if (isset($_GET['locations'])) {
  $location_rsQueryJob = $_GET['locations'];
}
$industry_rsQueryJob = "0";
if (isset($_GET['industries'])) {
  $industry_rsQueryJob = $_GET['industries'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);

// 7 june 2012 03-40pm
if(	$colname_rsQueryJob == NULL && 
	$industry_rsQueryJob == 0 &&
	$location_rsQueryJob == 0 &&
	$salaries_rsQueryJob == 0 &&
	$exp_rsQueryJob == 0
) {

$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title  Like %s OR   jp_ads.ads_details Like %s) And jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"));

}
if(	$colname_rsQueryJob != NULL && 
	$industry_rsQueryJob == 0 &&
	$location_rsQueryJob == 0 &&
	$salaries_rsQueryJob == 0 &&
	$exp_rsQueryJob == 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title  Like %s OR   jp_ads.ads_details Like %s) And jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"));
	
}

if(	$colname_rsQueryJob != NULL && 
	$industry_rsQueryJob != 0 &&
	$location_rsQueryJob != 0 &&
	$salaries_rsQueryJob != 0 &&
	$exp_rsQueryJob != 0
) { 

$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or     jp_ads.ads_details Like %s) And   jp_ads.ads_industry_id_fk = %s And   jp_ads.ads_location = %s And jp_ads.ads_salary <= %s And jp_ads.ads_y_exp = %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"),GetSQLValueString($location_rsQueryJob, "int"),GetSQLValueString($salaries_rsQueryJob, "int"),GetSQLValueString($exp_rsQueryJob, "int"));

}

if(	$colname_rsQueryJob != NULL && 
	$industry_rsQueryJob != 0 &&
	$location_rsQueryJob != 0 &&
	$salaries_rsQueryJob != 0
) {

$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or     jp_ads.ads_details Like %s) And   jp_ads.ads_industry_id_fk = %s And   jp_ads.ads_location = %s And  jp_ads.ads_salary <= %s And jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"),GetSQLValueString($location_rsQueryJob, "int"),GetSQLValueString($salaries_rsQueryJob, "int"));

}

if(	$colname_rsQueryJob != NULL && 
	$industry_rsQueryJob != 0 &&
	$location_rsQueryJob != 0 
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or     jp_ads.ads_details Like %s) And   jp_ads.ads_industry_id_fk = %s And   jp_ads.ads_location = %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"),GetSQLValueString($location_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$industry_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("Select   jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 From   jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id Where   (jp_ads.ads_title Like %s Or     jp_ads.ads_details Like %s) And   jp_ads.ads_industry_id_fk = %s And   jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$location_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or     jp_ads.ads_details Like %s) And   jp_ads.ads_location = %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($location_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$salaries_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And  jp_ads.ads_salary <= %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($salaries_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$exp_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And  jp_ads.ads_y_exp = %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($exp_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$exp_rsQueryJob != 0 &&
	$industry_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And jp_ads.ads_industry_id_fk = %s And  jp_ads.ads_y_exp = %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"),GetSQLValueString($exp_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$salaries_rsQueryJob != 0 &&
	$industry_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And jp_ads.ads_industry_id_fk = %s And  jp_ads.ads_salary <= %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($industry_rsQueryJob, "int"),GetSQLValueString($salaries_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$salaries_rsQueryJob != 0 &&
	$location_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And jp_ads.ads_location = %s And  jp_ads.ads_salary <= %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($location_rsQueryJob, "int"),GetSQLValueString($salaries_rsQueryJob, "int"));
}

if(	$colname_rsQueryJob != NULL && 
	$salaries_rsQueryJob != 0 &&
	$exp_rsQueryJob != 0
) {
	$query_rsQueryJob = sprintf("SELECT jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name,   jp_ads.ads_title As ads_title1,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 FROM jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id WHERE (jp_ads.ads_title Like %s Or jp_ads.ads_details Like %s) And jp_ads.ads_y_exp = %s And  jp_ads.ads_salary <= %s And  jp_ads.ads_enable_view = 1", GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString("%" . $colname_rsQueryJob . "%", "text"),GetSQLValueString($exp_rsQueryJob, "int"),GetSQLValueString($salaries_rsQueryJob, "int"));
}




$query_limit_rsQueryJob = sprintf("%s LIMIT %d, %d", $query_rsQueryJob, $startRow_rsQueryJob, $maxRows_rsQueryJob);
$rsQueryJob = mysql_query($query_limit_rsQueryJob, $conJobsPerak) or die(mysql_error());
$row_rsQueryJob = mysql_fetch_assoc($rsQueryJob);

if (isset($_GET['totalRows_rsQueryJob'])) {
  $totalRows_rsQueryJob = $_GET['totalRows_rsQueryJob'];
} else {
  $all_rsQueryJob = mysql_query($query_rsQueryJob);
  $totalRows_rsQueryJob = mysql_num_rows($all_rsQueryJob);
}
$totalPages_rsQueryJob = ceil($totalRows_rsQueryJob/$maxRows_rsQueryJob)-1;

$queryString_rsQueryJob = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsQueryJob") == false && 
        stristr($param, "totalRows_rsQueryJob") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsQueryJob = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsQueryJob = sprintf("&totalRows_rsQueryJob=%d%s", $totalRows_rsQueryJob, $queryString_rsQueryJob);

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
			<div class="left">
				<h1>Jobs Perak</h1>
			</div>

			<div class="right">
				<a href="#" title="Login">Login</a> &nbsp;|&nbsp;
                <a href="#" title="Register">Register</a>
			</div>
			<div class="clear"></div>
		</div><!-- .center -->
		
		<nav id="menu">
			<div class="center">
	        	<ul id="navigation">
	            	<li><a href="index.php">Home</a></li>
	                <li><a href="#">Search</a></li>
	                <li><a href="#">Register</a></li>
                    <li><a href="#">Employer : Post a Job</a></li>
	            </ul>
            </div><!-- .center -->
        </nav>
	</header><!-- #header-->

	<div id="wrapper">
	
	<section id="middle">

		<div id="container">
		  <div id="content">
          	  <strong>Your Search Result</strong>
              <div class="topTableCaption">There are (<?php echo $totalRows_rsQueryJob ?>) Job(s) in your search</div>
              
              <!-- Query Only -->
              <?php if ($totalRows_rsQueryJob > 0) { // Show if recordset not empty ?>
  <table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable">
    <tr>
      <th>Job Title</th>
      <th>Post By</th>
      <th>Salary</th>
      <th>Exp (Year)</th>
      <th>Date posted</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsQueryJob['ads_id']; ?>"><?php echo $row_rsQueryJob['ads_title']; ?></a> <br/>
          <small><a href="jobsByIndustry.php?ads_industry_id_fk=<?php echo $row_rsQueryJob['ads_industry_id_fk']; ?>&industry=<?php echo $row_rsQueryJob['indus_name']; ?>"><?php echo $row_rsQueryJob['indus_name']; ?></a></small></td>
        <td><a href="employer.php?emp_id=<?php echo $row_rsQueryJob['emp_id_fk']; ?>&employer=<?php echo $row_rsQueryJob['emp_name']; ?>"><?php echo $row_rsQueryJob['emp_name']; ?></a></td>
        <td>RM <?php echo $row_rsQueryJob['ads_salary']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsQueryJob['ads_y_exp']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsQueryJob['ads_date_published']; ?></td>
      </tr>
      <?php } while ($row_rsQueryJob = mysql_fetch_assoc($rsQueryJob)); ?>
  </table>
                <div class="paginate"><a href="<?php printf("%s?pageNum_rsQueryJob=%d%s", $currentPage, 0, $queryString_rsQueryJob); ?>">First</a> | <a href="<?php printf("%s?pageNum_rsQueryJob=%d%s", $currentPage, max(0, $pageNum_rsQueryJob - 1), $queryString_rsQueryJob); ?>">Previous</a> | <a href="<?php printf("%s?pageNum_rsQueryJob=%d%s", $currentPage, min($totalPages_rsQueryJob, $pageNum_rsQueryJob + 1), $queryString_rsQueryJob); ?>">Next</a> | <a href="<?php printf("%s?pageNum_rsQueryJob=%d%s", $currentPage, $totalPages_rsQueryJob, $queryString_rsQueryJob); ?>">Last</a> | 
              Records <?php echo ($startRow_rsQueryJob + 1) ?> to <?php echo min($startRow_rsQueryJob + $maxRows_rsQueryJob, $totalRows_rsQueryJob) ?> of <?php echo $totalRows_rsQueryJob ?></div>
                <?php } // Show if recordset not empty ?>
                <!-- /Query Only -->
                              
                <!-- Query & Industry Only -->
           	<!--<table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable">
    <tr>
      <th>Job Title</th>
      <th>Post By</th>
      <th>Salary</th>
      <th>Exp (Year)</th>
      <th>Date posted</th>
    </tr>
      <tr>
        <td>x<br/>
          <small>x</small></td>
        <td>x</td>
        <td>RM x</td>
        <td align="center" valign="middle">x</td>
        <td align="center" valign="middle">x</td>
      </tr>
  </table>
                <div class="paginate">Content for  class "paginate" Goes Here</div>-->
<!-- /Query & Industry Only -->
                
                
          </div><!-- #content-->
	
		  <aside id="sideRight">
          	  <div class="sidebarBox">
              	<strong>How-to</strong>
            	<div class="sidebar_howto">
                	<ul>
                    	<li><a href="#">Register</a></li>
                        <li><a href="#">Post a Job</a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
			  <div class="sidebarBox">
              	<strong>Recent Jobs</strong>
            	<div class="sidebar_recentjob">
                	<ul>
                    	<?php do { ?>
                   	    <li><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsTenLatestJob['ads_id']; ?>"><?php echo $row_rsTenLatestJob['ads_title']; ?></a></li>
                    	  <?php } while ($row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob)); ?>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox">
           	  <strong>Advertisement</strong>
              	<img src="media/ads/36b7c88239654754a0504fe7c6e01669.gif" width="300" height="100" alt="latest">
              	<img src="media/ads/34e8a0caf5ff263683d3b3371fda5ecd.jpg" width="300" height="250" alt="advert1">
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox">
           	  <strong>Get Connected</strong><br />
              	Facebook | Twitter | RSS
              </div><!-- .sidebarBox -->
            </aside>
			<!-- aside -->
			<!-- #sideRight -->

		</div><!-- #container-->
		

	</section><!-- #middle-->

	</div><!-- #wrapper-->

	<footer id="footer">
		<div class="center">
			Copyright Reserved &copy; 2012
		</div><!-- .center -->
	</footer><!-- #footer -->



</body>
</html>
<?php
mysql_free_result($rsTenLatestJob);

mysql_free_result($rsQueryJob);
?>