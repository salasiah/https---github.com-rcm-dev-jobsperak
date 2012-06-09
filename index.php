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
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
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
$query_rsLocation = "SELECT * FROM jp_location WHERE location_parent = 0 ORDER BY location_name ASC";
$rsLocation = mysql_query($query_rsLocation, $conJobsPerak) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIndustry = "SELECT * FROM jp_industry WHERE industry_parent = 0";
$rsIndustry = mysql_query($query_rsIndustry, $conJobsPerak) or die(mysql_error());
$row_rsIndustry = mysql_fetch_assoc($rsIndustry);
$totalRows_rsIndustry = mysql_num_rows($rsIndustry);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTenLatestJob = "SELECT ads_id, ads_title FROM jp_ads ORDER BY ads_date_posted DESC";
$rsTenLatestJob = mysql_query($query_rsTenLatestJob, $conJobsPerak) or die(mysql_error());
$row_rsTenLatestJob = mysql_fetch_assoc($rsTenLatestJob);
$totalRows_rsTenLatestJob = mysql_num_rows($rsTenLatestJob);

$maxRows_rs14FeaturedEmployed = 14;
$pageNum_rs14FeaturedEmployed = 0;
if (isset($_GET['pageNum_rs14FeaturedEmployed'])) {
  $pageNum_rs14FeaturedEmployed = $_GET['pageNum_rs14FeaturedEmployed'];
}
$startRow_rs14FeaturedEmployed = $pageNum_rs14FeaturedEmployed * $maxRows_rs14FeaturedEmployed;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rs14FeaturedEmployed = "SELECT emp_id, emp_name, emp_featured FROM jp_employer WHERE emp_featured = 1";
$query_limit_rs14FeaturedEmployed = sprintf("%s LIMIT %d, %d", $query_rs14FeaturedEmployed, $startRow_rs14FeaturedEmployed, $maxRows_rs14FeaturedEmployed);
$rs14FeaturedEmployed = mysql_query($query_limit_rs14FeaturedEmployed, $conJobsPerak) or die(mysql_error());
$row_rs14FeaturedEmployed = mysql_fetch_assoc($rs14FeaturedEmployed);

if (isset($_GET['totalRows_rs14FeaturedEmployed'])) {
  $totalRows_rs14FeaturedEmployed = $_GET['totalRows_rs14FeaturedEmployed'];
} else {
  $all_rs14FeaturedEmployed = mysql_query($query_rs14FeaturedEmployed);
  $totalRows_rs14FeaturedEmployed = mysql_num_rows($all_rs14FeaturedEmployed);
}
$totalPages_rs14FeaturedEmployed = ceil($totalRows_rs14FeaturedEmployed/$maxRows_rs14FeaturedEmployed)-1;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rs10FeaturedCandidate = "Select   jp_resume.users_id_fk,   jp_resume.resume_featured,   jp_users.users_fname,   jp_users.users_lname From   jp_resume Inner Join   jp_users On jp_resume.users_id_fk = jp_users.users_id Where   jp_resume.resume_featured = 1";
$rs10FeaturedCandidate = mysql_query($query_rs10FeaturedCandidate, $conJobsPerak) or die(mysql_error());
$row_rs10FeaturedCandidate = mysql_fetch_assoc($rs10FeaturedCandidate);
$totalRows_rs10FeaturedCandidate = mysql_num_rows($rs10FeaturedCandidate);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAllindustries = "SELECT * FROM jp_industry ORDER BY indus_name ASC";
$rsAllindustries = mysql_query($query_rsAllindustries, $conJobsPerak) or die(mysql_error());
$row_rsAllindustries = mysql_fetch_assoc($rsAllindustries);
$totalRows_rsAllindustries = mysql_num_rows($rsAllindustries);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsTotalJobsOnline = "Select   Count(*) As totalOnline From   jp_ads Where   jp_ads.ads_enable_view = 1";
$rsTotalJobsOnline = mysql_query($query_rsTotalJobsOnline, $conJobsPerak) or die(mysql_error());
$row_rsTotalJobsOnline = mysql_fetch_assoc($rsTotalJobsOnline);
$totalRows_rsTotalJobsOnline = mysql_num_rows($rsTotalJobsOnline);
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
			<div class="left"> <a href="index.php"><img src="img/logo.png" width="179" height="44" alt="JobsPerak Logo" longdesc="index.php"></a>
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
		
		<nav id="menu">
			<div class="center">
	        	<ul id="navigation">
	            	<li><a href="index.php">Home</a></li>
	                <li><a href="#">Search</a></li>
	                <li><a href="registerJobSeeker.php" title="Register JobSeeker">Register JobSeeker</a></li>
                    <li><a href="registerJobSeeker.php">Employer : Post a Job</a></li>
	            </ul>
            </div><!-- .center -->
        </nav>
	</header><!-- #header-->

	<div id="wrapper">
	
	<section id="middle">

		  <div id="content">
          	  <div class="box">
              	<div class="search_container">
                	<h3>Search Jobs</h3>
                	<form action="jobAdsSearchResult.php" method="get" name="front_search">
                    <table width="100%" border="0" cellspacing="6" cellpadding="2">
  <tr>
  	<td colspan="4"><input name="q" type="text" class="main_q" id="main_q" placeholder="Search Jobstitle / Job Description " dir="ltr" /></td>
  </tr>
  <tr>
    <td><select name="industries">
      <option value="0">All Industries</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsAllindustries['indus_id']?>"><?php echo $row_rsAllindustries['indus_name']?></option>
      <?php
} while ($row_rsAllindustries = mysql_fetch_assoc($rsAllindustries));
  $rows = mysql_num_rows($rsAllindustries);
  if($rows > 0) {
      mysql_data_seek($rsAllindustries, 0);
	  $row_rsAllindustries = mysql_fetch_assoc($rsAllindustries);
  }
?>
    </select></td>
    <td><select name="locations">
      <option value="0">All Locations</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsLocation['location_id']?>"><?php echo $row_rsLocation['location_name']?></option>
      <?php
} while ($row_rsLocation = mysql_fetch_assoc($rsLocation));
  $rows = mysql_num_rows($rsLocation);
  if($rows > 0) {
      mysql_data_seek($rsLocation, 0);
	  $row_rsLocation = mysql_fetch_assoc($rsLocation);
  }
?>
    </select></td>
    <td><select name="salary">
      <option value="0">All Salaries</option>
      <option value="1000">Below RM1,000</option>
      <option value="2000">Below RM2,000</option>
      <option value="3000">Below RM3,000</option>
      <option value="10000">RM10,000 and Below</option>
    </select></td>
    <td><select name="year_exp">
      <option value="0">No Experience</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5 and above</option>
    </select></td>
  </tr>
  <tr>
  	<td colspan="2">Over (<?php echo $row_rsTotalJobsOnline['totalOnline']; ?>) jobs available to be hire</td>
    <td><input name="search_job" id="search_job" type="submit" value="Search"> <input name="search_job" type="reset" value="Reset"></td>
    <td><a href="#">Advanced Search</a></td>
  </tr>
</table>
                  </form>
                </div>
              </div>
              
            <div class="browse_jobopening box">
            	<a href="jobsOpeningAll.php"> Browse all openig jobs in our portal &raquo;</a></div>
            
<div class="browse_location box">
	      <h2 class="title">Browse by Location</h2>
			    <div class="location_lists">
                	<ul>
                    	<?php do { ?>
                   	    <li><a href="jobsByLocation.php?ads_location=<?php echo $row_rsLocation['location_id']; ?>&location=<?php echo $row_rsLocation['location_name']; ?>"><?php echo $row_rsLocation['location_name']; ?></a></li>
                    	  <?php } while ($row_rsLocation = mysql_fetch_assoc($rsLocation)); ?>
                    </ul>
                </div>
              </div>
			  <div class="browse_industry box">
			    <h2 class="title">Browse by Industry</h2>
			    <div class="industry_lists">
                	<ul>
                    	<?php do { ?>
                    	  <li><a href="jobsByIndustry.php?ads_industry_id_fk=<?php echo $row_rsIndustry['indus_id']; ?>&industry=<?php echo $row_rsIndustry['indus_name']; ?>"><?php echo $row_rsIndustry['indus_name']; ?></a></li>
                    	  <?php } while ($row_rsIndustry = mysql_fetch_assoc($rsIndustry)); ?>
                    </ul>
                </div>
              </div>
			  <div class="freatured_employer box">
			    <h2 class="title">Featured Employer</h2>
			    <div class="featured_emplyed_lists">
                	<ul>
                    	<?php do { ?>
                   	    <li><a href="employer.php?emp_id=<?php echo $row_rs14FeaturedEmployed['emp_id']; ?>&employer=<?php echo $row_rs14FeaturedEmployed['emp_name']; ?>"><?php echo $row_rs14FeaturedEmployed['emp_name']; ?></a></li>
                    	  <?php } while ($row_rs14FeaturedEmployed = mysql_fetch_assoc($rs14FeaturedEmployed)); ?>
                    </ul>
                </div>
              </div>
		    <div class="featured_candidate box">
		      <h2 class="title">Featured Candidate</h2>
		      <div class="featured_candidate_list">
               	  <ul>
                   	  <?php do { ?>
                   	    <li><?php echo $row_rs10FeaturedCandidate['users_fname']; ?> <?php echo $row_rs10FeaturedCandidate['users_lname']; ?></li>
                   	    <?php } while ($row_rs10FeaturedCandidate = mysql_fetch_assoc($rs10FeaturedCandidate)); ?>
                  </ul>
              </div>
            </div>
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
            </div><!-- .sidebarFullBox -->
              
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
		

	</section><!-- #middle-->

	</div><!-- #wrapper-->

	<footer id="footer">
		<div class="center">
			Copyright Reserved &copy; 2012
		</div><!-- .center -->
	</footer><!-- #footer -->



</body>
</html>
<script>
$(document).ready(function(){
	$('#search_job').live('click', function(){
		var q = $('#main_q').val();
		
		if(q == ''){
			alert('Fill Job Title / Job Description');
			return false;
		}

	});
});
</script>
<?php
mysql_free_result($rsLocation);

mysql_free_result($rsIndustry);

mysql_free_result($rsTenLatestJob);

mysql_free_result($rs14FeaturedEmployed);

mysql_free_result($rs10FeaturedCandidate);

mysql_free_result($rsAllindustries);

mysql_free_result($rsTotalJobsOnline);
?>
