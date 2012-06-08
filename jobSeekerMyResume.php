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
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "sessionGateway.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

$colname_rsJobSeekerInfo = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsJobSeekerInfo = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsJobSeekerInfo = sprintf("Select   jp_nationality.national_name,   jp_jobseeker.*,   jp_jobseeker.users_id_fk As users_id_fk1 From   jp_jobseeker Inner Join   jp_nationality On jp_jobseeker.jobseeker_nationality =     jp_nationality.national_id Where   jp_jobseeker.users_id_fk = %s", GetSQLValueString($colname_rsJobSeekerInfo, "int"));
$rsJobSeekerInfo = mysql_query($query_rsJobSeekerInfo, $conJobsPerak) or die(mysql_error());
$row_rsJobSeekerInfo = mysql_fetch_assoc($rsJobSeekerInfo);
$totalRows_rsJobSeekerInfo = mysql_num_rows($rsJobSeekerInfo);

$colname_rsCurrentUsers = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsCurrentUsers = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCurrentUsers = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsCurrentUsers, "int"));
$rsCurrentUsers = mysql_query($query_rsCurrentUsers, $conJobsPerak) or die(mysql_error());
$row_rsCurrentUsers = mysql_fetch_assoc($rsCurrentUsers);
$totalRows_rsCurrentUsers = mysql_num_rows($rsCurrentUsers);

$colname_rsUserResume = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserResume = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserResume = sprintf("SELECT * FROM jp_resume WHERE users_id_fk = %s", GetSQLValueString($colname_rsUserResume, "int"));
$rsUserResume = mysql_query($query_rsUserResume, $conJobsPerak) or die(mysql_error());
$row_rsUserResume = mysql_fetch_assoc($rsUserResume);
$totalRows_rsUserResume = mysql_num_rows($rsUserResume);

$colname_rsUserEmpHistory = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserEmpHistory = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserEmpHistory = sprintf("Select   jp_experience.*,   jp_industry.indus_name,   jp_specialize.specialize_name,   jp_level.level_position From   jp_experience Inner Join   jp_industry On jp_experience.industry_id_fk = jp_industry.indus_id Inner Join   jp_specialize On jp_experience.exp_specialize = jp_specialize.specialize_id   Inner Join   jp_level On jp_experience.exp_pos_level = jp_level.level_id Where   jp_experience.users_id_fk = %s", GetSQLValueString($colname_rsUserEmpHistory, "int"));
$rsUserEmpHistory = mysql_query($query_rsUserEmpHistory, $conJobsPerak) or die(mysql_error());
$row_rsUserEmpHistory = mysql_fetch_assoc($rsUserEmpHistory);
$totalRows_rsUserEmpHistory = mysql_num_rows($rsUserEmpHistory);

$colname_rsUserQualification = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserQualification = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserQualification = sprintf("SELECT * FROM jp_education WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserQualification, "int"));
$rsUserQualification = mysql_query($query_rsUserQualification, $conJobsPerak) or die(mysql_error());
$row_rsUserQualification = mysql_fetch_assoc($rsUserQualification);
$totalRows_rsUserQualification = mysql_num_rows($rsUserQualification);

$colname_rsUserSkill = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserSkill = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserSkill = sprintf("SELECT * FROM jp_skills WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserSkill, "int"));
$rsUserSkill = mysql_query($query_rsUserSkill, $conJobsPerak) or die(mysql_error());
$row_rsUserSkill = mysql_fetch_assoc($rsUserSkill);
$totalRows_rsUserSkill = mysql_num_rows($rsUserSkill);

$colname_rsUserLanguage = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserLanguage = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserLanguage = sprintf("SELECT * FROM jp_language WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserLanguage, "int"));
$rsUserLanguage = mysql_query($query_rsUserLanguage, $conJobsPerak) or die(mysql_error());
$row_rsUserLanguage = mysql_fetch_assoc($rsUserLanguage);
$totalRows_rsUserLanguage = mysql_num_rows($rsUserLanguage);

$colname_rsUserJobPrefer = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserJobPrefer = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserJobPrefer = sprintf("SELECT * FROM jp_jobpreferences WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserJobPrefer, "int"));
$rsUserJobPrefer = mysql_query($query_rsUserJobPrefer, $conJobsPerak) or die(mysql_error());
$row_rsUserJobPrefer = mysql_fetch_assoc($rsUserJobPrefer);
$totalRows_rsUserJobPrefer = mysql_num_rows($rsUserJobPrefer);

$colname_rsUserRefer = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUserRefer = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserRefer = sprintf("SELECT * FROM jp_references WHERE user_id_fk = %s", GetSQLValueString($colname_rsUserRefer, "int"));
$rsUserRefer = mysql_query($query_rsUserRefer, $conJobsPerak) or die(mysql_error());
$row_rsUserRefer = mysql_fetch_assoc($rsUserRefer);
$totalRows_rsUserRefer = mysql_num_rows($rsUserRefer);
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
<h2>JobSeeker Dashboard</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  
  <div class="menu_container">
  		<ul id="default_inline_menu">
        	<li><a href="jobSeekerDashboard.php">My Dashboard</a></li>
        	<li><a href="#">My Resume</a></li>
            <li><a href="#">My Application</a></li>
            <li><a href="#">Shortlisted Job</a></li>
            <li><a href="#">Job Alert</a></li>
            <li><a href="#">Edit Profile</a></li>
        </ul>
  	</div>
    
    <div class="box">
    	<h3>My Resume</h3>
    	</div>
        
    <div class="box resumebox">
    	<strong>Uploaded Resume</strong>
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="32">&nbsp;</td>  
    <td class="def_width_box_3">File name</td>
    <td width="22">:</td>
    <td><a href="<?php echo $row_rsUserResume['resume_path']; ?>"><?php echo $row_rsUserResume['resume_title']; ?></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Uploaded On</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserResume['resume_upload_on']; ?></td>
  </tr>
</table></div>
        
    <div class="box resumebox">
    	<strong>Personal Particulars</strong> &middot;
        <?php if ($totalRows_rsJobSeekerInfo == 0) { // Show if recordset empty ?>
        	<a href="particularAdd.php?cuid=<?php echo $_SESSION['MM_UserID']; ?>">Add</a>
		<?php } // Show if recordset empty ?>
        <?php if ($totalRows_rsJobSeekerInfo > 0) { // Show if recordset not empty ?>
          <a href="particularEdit.php?cuid=<?php echo $_SESSION['MM_UserID']; ?>">Edit</a>
          <?php } // Show if recordset not empty ?>
          <?php if ($totalRows_rsCurrentUsers > 0) { // Show if recordset not empty ?>
            <table width="500" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="def_width_box">Name</td>
                <td width="22">:</td>
                <td><?php echo $row_rsCurrentUsers['users_fname']; ?> <?php echo $row_rsCurrentUsers['users_lname']; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td width="22">:</td>
                <td><?php echo $row_rsCurrentUsers['users_email']; ?></td>
              </tr>
              <tr>
                <td>Telephone No.</td>
                <td width="22">:</td>
                <td><?php echo $row_rsJobSeekerInfo['jobseeker_tel']; ?></td>
              </tr>
              <tr>
                <td>Mobile No.</td>
                <td width="22">:</td>
                <td><?php echo $row_rsJobSeekerInfo['jobseeker_mobile']; ?></td>
              </tr>
              <tr>
                <td>Address</td>
                <td width="22">:</td>
                <td><?php echo $row_rsJobSeekerInfo['jobseeker_address']; ?></td>
              </tr>
            </table>
            <table width="500" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="def_width_box">Date of Birth</td>
                <td width="22">:</td>
                <td><?php echo $row_rsJobSeekerInfo['jobseeker_dob_d']; ?> <?php echo $row_rsJobSeekerInfo['jobseeker_dob_m']; ?> <?php echo $row_rsJobSeekerInfo['jobseeker_dob_y']; ?></td>
              </tr>
              <tr>
                <td>Gender</td>
                <td width="22">:</td>
                <td><?php if($row_rsJobSeekerInfo['jobseeker_gender'] == 1){echo "Female";}else{echo"Male";} ?></td>
              </tr>
              <tr>
                <td>Nationality</td>
                <td width="22">:</td>
                <td><?php echo $row_rsJobSeekerInfo['national_name']; ?></td>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?>
    </div>
        
    <div class="box resumebox">
    	<strong>Experience</strong><br/><br/>
        <strong>Employment History</strong><?php echo $totalRows_rsUserEmpHistory ?><br/><br/>

        <table width="500" border="0" cellspacing="0" cellpadding="2">
        <?php for($i=1; $i <= ($totalRows_rsUserEmpHistory+1); $i++){?>
          <?php do { ?>
            <tr>
              <td width="10"><?php echo $i; ?></td>
              <td class="def_width_box_2">Company Name</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_co_name']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Position Title</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_pos_title']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Specialization</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['specialize_name']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Role</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_role']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Monthly Salary</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_monthlysalary']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Work Description</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_word_desc']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>From / To</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['exp_from_to']; ?> / <?php echo $row_rsUserEmpHistory['exp_from_to_y']; ?> - <?php echo $row_rsUserEmpHistory['exp_to_m']; ?> / <?php echo $row_rsUserEmpHistory['exp_to_y']; ?></td>
            </tr>
            <tr>
              <td></td>
              <td>Position Level</td>
              <td width="22">:</td>
              <td><?php echo $row_rsUserEmpHistory['level_position']; ?></td>
            </tr>
            <?php } while ($row_rsUserEmpHistory = mysql_fetch_assoc($rsUserEmpHistory)); ?>
            <?php } ?>
<tr><td colspan="4">&nbsp;</td></tr>
</table></div>
        
    <div class="box resumebox">
    	<strong>Qualification</strong><br/><br/>
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10">1</td>
    <td class="def_width_box_2">Qualification</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_qualification']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>CGPA</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_cgpa']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>Field of Study</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_fieldStudy']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>Major</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_major']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>Institute / University</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_university']; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>Graduated</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserQualification['edu_date_graduate_month']; ?> <?php echo $row_rsUserQualification['edu_date_graduate_year']; ?></td>
  </tr>
  <tr><td colspan="4">&nbsp;</td></tr>
</table></div>
        
    <div class="box resumebox">
    	<strong>Skills</strong>
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <th>Skill</th>
    <th>Years of Experience</th>
    <th>Proficiency</th>
  </tr>
  <tr>
    <th><?php echo $row_rsUserSkill['skills_name']; ?></th>
    <th><?php echo $row_rsUserSkill['skills_y_exp']; ?></th>
    <th><?php echo $row_rsUserSkill['skills_proficiency']; ?></th>
  </tr>
  
</table></div>
        
        
     <div class="box resumebox">
    	<strong>Languages</strong><br/><br/>
        <span style="text-align:center"><strong>Proficiency</strong> (0=Poor - 10=Excellent)</span>
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <th align="left">Language</th>
    <th>Spoken</th>
    <th>Written</th>
  </tr>
  <tr>
    <th><?php echo $row_rsUserLanguage['lang_name']; ?></th>
    <th><?php echo $row_rsUserLanguage['lang_spoken']; ?></th>
    <th><?php echo $row_rsUserLanguage['lang_written']; ?></th>
  </tr>
  
</table></div>
        
     <div class="box resumebox">
    	<strong>Additional Info</strong><br/><br/>
        <?php echo $row_rsJobSeekerInfo['jobseeker_moreinfo']; ?></div>
        
     <div class="box resumebox">
    	<strong>Job Preferences</strong><br/><br/>
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="def_width_box">Preferred Work Location(s)</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserJobPrefer['jobP_1']; ?></td>
  </tr>
  <tr>
    <td>Preferred Job Type(s)</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserJobPrefer['jobP_2']; ?></td>
  </tr>
  <tr>
    <td>Expected Monthly Salary</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserJobPrefer['jobP_salary']; ?></td>
  </tr>
  
</table></div>
        
     <div class="box resumebox">
    	<strong>References</strong><br /><br />
        <table width="500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="def_width_box">Name</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_name']; ?></td>
  </tr>
  <tr>
    <td>Relationship </td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_relationship']; ?></td>
  </tr>
  <tr>
    <td>Email </td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_email']; ?></td>
  </tr>
  <tr>
    <td>Telephone  </td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_phone']; ?></td>
  </tr>
  <tr>
    <td>Position Title</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_pos_title']; ?></td>
  </tr>
  <tr>
    <td>Company Name</td>
    <td width="22">:</td>
    <td><?php echo $row_rsUserRefer['ref_comp_name']; ?></td>
  </tr>
  
</table></div>
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
              </div><!-- .sidebarBox -->
              
			  <div class="sidebarBox hide">
              	<strong>Recent Jobs</strong>
            	<div class="sidebar_recentjob">
                	<ul>
                      <li><a></a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
           	  <strong>Jobs Posted under </strong>
              	<ul>
                  <li><a></a></li>
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
mysql_free_result($rsJobSeekerInfo);

mysql_free_result($rsCurrentUsers);

mysql_free_result($rsUserResume);

mysql_free_result($rsUserEmpHistory);

mysql_free_result($rsUserQualification);

mysql_free_result($rsUserSkill);

mysql_free_result($rsUserLanguage);

mysql_free_result($rsUserJobPrefer);

mysql_free_result($rsUserRefer);
?>
