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

$maxRows_rsJobByIndustry = 10;
$pageNum_rsJobByIndustry = 0;
if (isset($_GET['pageNum_rsJobByIndustry'])) {
  $pageNum_rsJobByIndustry = $_GET['pageNum_rsJobByIndustry'];
}
$startRow_rsJobByIndustry = $pageNum_rsJobByIndustry * $maxRows_rsJobByIndustry;

$colname_rsJobByIndustry = "-1";
if (isset($_GET['ads_industry_id_fk'])) {
  $colname_rsJobByIndustry = $_GET['ads_industry_id_fk'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobByIndustry = sprintf("Select   jp_industry.indus_name,   jp_employer.emp_name,   jp_ads.*,   jp_location.location_name,   jp_ads.ads_industry_id_fk As ads_industry_id_fk1 From   jp_ads Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id Where   jp_ads.ads_industry_id_fk = %s And   jp_ads.ads_enable_view = 1", GetSQLValueString($colname_rsJobByIndustry, "int"));
$query_limit_rsJobByIndustry = sprintf("%s LIMIT %d, %d", $query_rsJobByIndustry, $startRow_rsJobByIndustry, $maxRows_rsJobByIndustry);
$rsJobByIndustry = mysql_query($query_limit_rsJobByIndustry, $conJobsPerak) or die(mysql_error());
$row_rsJobByIndustry = mysql_fetch_assoc($rsJobByIndustry);

if (isset($_GET['totalRows_rsJobByIndustry'])) {
  $totalRows_rsJobByIndustry = $_GET['totalRows_rsJobByIndustry'];
} else {
  $all_rsJobByIndustry = mysql_query($query_rsJobByIndustry);
  $totalRows_rsJobByIndustry = mysql_num_rows($all_rsJobByIndustry);
}
$totalPages_rsJobByIndustry = ceil($totalRows_rsJobByIndustry/$maxRows_rsJobByIndustry)-1;

$queryString_rsJobByIndustry = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobByIndustry") == false && 
        stristr($param, "totalRows_rsJobByIndustry") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobByIndustry = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobByIndustry = sprintf("&totalRows_rsJobByIndustry=%d%s", $totalRows_rsJobByIndustry, $queryString_rsJobByIndustry);
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
          	  Jobs By Industry: <strong><?php echo ucfirst($_GET['industry']); ?></strong>
              <div class="topTableCaption"><?php echo $totalRows_rsJobByIndustry ?> Job(s) Posted in <?php echo ucfirst($_GET['industry']); ?></div>
              <?php if ($totalRows_rsJobByIndustry > 0) { // Show if recordset not empty ?>
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
        <td><?php echo $row_rsJobByIndustry['ads_title']; ?> <br/><small><?php echo $row_rsJobByIndustry['indus_name']; ?></small></td>
        <td><?php echo $row_rsJobByIndustry['emp_name']; ?></td>
        <td>RM <?php echo $row_rsJobByIndustry['ads_salary']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsJobByIndustry['ads_y_exp']; ?></td>
        <td align="center" valign="middle"><?php echo $row_rsJobByIndustry['ads_date_published']; ?></td>
      </tr>
      <?php } while ($row_rsJobByIndustry = mysql_fetch_assoc($rsJobByIndustry)); ?>
  </table>
              <div class="paginate"><a href="<?php printf("%s?pageNum_rsJobByIndustry=%d%s", $currentPage, 0, $queryString_rsJobByIndustry); ?>">First</a> | <a href="<?php printf("%s?pageNum_rsJobByIndustry=%d%s", $currentPage, max(0, $pageNum_rsJobByIndustry - 1), $queryString_rsJobByIndustry); ?>">Previous</a> | <a href="<?php printf("%s?pageNum_rsJobByIndustry=%d%s", $currentPage, min($totalPages_rsJobByIndustry, $pageNum_rsJobByIndustry + 1), $queryString_rsJobByIndustry); ?>">Next</a> | <a href="<?php printf("%s?pageNum_rsJobByIndustry=%d%s", $currentPage, $totalPages_rsJobByIndustry, $queryString_rsJobByIndustry); ?>">Last</a></div>
                <?php } // Show if recordset not empty ?>
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

mysql_free_result($rsJobByIndustry);
?>
