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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$colname_rsJobsAdsDetails = "-1";
if (isset($_GET['jobAdsId'])) {
  $colname_rsJobsAdsDetails = $_GET['jobAdsId'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobsAdsDetails = sprintf("Select   jp_employer.emp_name,   jp_employer.emp_address,   jp_employer.emp_email,   jp_employer.emp_web,   jp_employer.emp_tel,   jp_ads.*,   jp_industry.indus_name,   jp_location.location_name From   jp_ads Inner Join   jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join   jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join   jp_location On jp_ads.ads_location = jp_location.location_id Where   jp_ads.ads_id = %s", GetSQLValueString($colname_rsJobsAdsDetails, "int"));
$rsJobsAdsDetails = mysql_query($query_rsJobsAdsDetails, $conJobsPerak) or die(mysql_error());
$row_rsJobsAdsDetails = mysql_fetch_assoc($rsJobsAdsDetails);
$totalRows_rsJobsAdsDetails = mysql_num_rows($rsJobsAdsDetails);
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
          	  <strong>Jobs Details</strong>
       	    <?php if ($totalRows_rsJobsAdsDetails > 0) { // Show if recordset not empty ?>
  <div class="master_details">
    <p><h2><?php echo $row_rsJobsAdsDetails['ads_title']; ?></h2></p>
    <p><?php echo $row_rsJobsAdsDetails['ads_details']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['location_name']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['ads_salary']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['ads_y_exp']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['ads_date_published']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['indus_name']; ?></p>
  </div>
  
  <div class="jobEmployer">
  	<p>Posted By</p>
    <p><a href="employer.php?emp_id=<?php echo $row_rsJobsAdsDetails['emp_id_fk']; ?>&employer=<?php echo $row_rsJobsAdsDetails['emp_name']; ?>"><?php echo $row_rsJobsAdsDetails['emp_name']; ?></a></p>
    <p><?php echo $row_rsJobsAdsDetails['emp_address']; ?></p>
    <p><?php echo $row_rsJobsAdsDetails['emp_tel']; ?></p>
    <p><a href="http://<?php echo $row_rsJobsAdsDetails['emp_web']; ?>"><?php echo $row_rsJobsAdsDetails['emp_web']; ?></a></p>
    <p>2</p>
  </div>
  
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rsJobsAdsDetails == 0) { // Show if recordset empty ?>
  	<div class="master_details"><p>No list in our Database.</p></div>
  <?php } // Show if recordset empty ?>
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
              
              <div class="sidebarBox hide">
           	  <strong>Jobs Posted under <?php echo $_GET['employer']; ?></strong>
              	<ul>
                  <li><a href="#"><?php echo $row_rsEmployerJobLists['ads_title']; ?></a></li>
                </ul>
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
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

mysql_free_result($rsJobsAdsDetails);
?>
