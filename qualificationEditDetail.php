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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE jp_education SET edu_qualification=%s, edu_fieldStudy=%s, edu_major=%s, edu_grade=%s, edu_cgpa=%s, edu_university=%s, edu_located=%s, edu_date_graduate_month=%s, edu_date_graduate_year=%s, user_id_fk=%s WHERE edu_id=%s",
                       GetSQLValueString($_POST['edu_qualification'], "int"),
                       GetSQLValueString($_POST['edu_fieldStudy'], "int"),
                       GetSQLValueString($_POST['edu_major'], "text"),
                       GetSQLValueString($_POST['edu_grade'], "int"),
                       GetSQLValueString($_POST['edu_cgpa'], "double"),
                       GetSQLValueString($_POST['edu_university'], "text"),
                       GetSQLValueString($_POST['edu_located'], "int"),
                       GetSQLValueString($_POST['edu_date_graduate_month'], "int"),
                       GetSQLValueString($_POST['edu_date_graduate_year'], "int"),
                       GetSQLValueString($_POST['user_id_fk'], "int"),
                       GetSQLValueString($_POST['edu_id'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($updateSQL, $conJobsPerak) or die(mysql_error());

  $updateGoTo = "jobSeekerMyResume.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEduList = "SELECT * FROM jp_edu_lists";
$rsEduList = mysql_query($query_rsEduList, $conJobsPerak) or die(mysql_error());
$row_rsEduList = mysql_fetch_assoc($rsEduList);
$totalRows_rsEduList = mysql_num_rows($rsEduList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFieldList = "SELECT * FROM jp_field_list";
$rsFieldList = mysql_query($query_rsFieldList, $conJobsPerak) or die(mysql_error());
$row_rsFieldList = mysql_fetch_assoc($rsFieldList);
$totalRows_rsFieldList = mysql_num_rows($rsFieldList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsGradeList = "SELECT * FROM jp_grade_list";
$rsGradeList = mysql_query($query_rsGradeList, $conJobsPerak) or die(mysql_error());
$row_rsGradeList = mysql_fetch_assoc($rsGradeList);
$totalRows_rsGradeList = mysql_num_rows($rsGradeList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLocatedList = "SELECT * FROM jp_nationality";
$rsLocatedList = mysql_query($query_rsLocatedList, $conJobsPerak) or die(mysql_error());
$row_rsLocatedList = mysql_fetch_assoc($rsLocatedList);
$totalRows_rsLocatedList = mysql_num_rows($rsLocatedList);

$colname_rsUserEdu = "-1";
if (isset($_GET['edu_id'])) {
  $colname_rsUserEdu = $_GET['edu_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUserEdu = sprintf("SELECT * FROM jp_education WHERE edu_id = %s", GetSQLValueString($colname_rsUserEdu, "int"));
$rsUserEdu = mysql_query($query_rsUserEdu, $conJobsPerak) or die(mysql_error());
$row_rsUserEdu = mysql_fetch_assoc($rsUserEdu);
$totalRows_rsUserEdu = mysql_num_rows($rsUserEdu);
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

		<div id="container" class="full">
		  <div id="content_full">
<h2>Update</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  
  <div class="master_details boxcenter">
	<h3>Update Qualification</h3><br/>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Qualification</td>
          <td><select name="edu_qualification">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsEduList['edu_id']?>" <?php if (!(strcmp($row_rsEduList['edu_id'], htmlentities($row_rsUserEdu['edu_qualification'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rsEduList['edu_name']?></option>
            <?php
} while ($row_rsEduList = mysql_fetch_assoc($rsEduList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Field of Study</td>
          <td><select name="edu_fieldStudy">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsFieldList['field_id']?>" <?php if (!(strcmp($row_rsFieldList['field_id'], htmlentities($row_rsUserEdu['edu_fieldStudy'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rsFieldList['field_name']?></option>
            <?php
} while ($row_rsFieldList = mysql_fetch_assoc($rsFieldList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Major</td>
          <td><input name="edu_major" type="text" value="<?php echo $row_rsUserEdu['edu_major']; ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Grade</td>
          <td><select name="edu_grade">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsGradeList['grade_id']?>" <?php if (!(strcmp($row_rsGradeList['grade_id'], htmlentities($row_rsUserEdu['edu_grade'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rsGradeList['grade_name']?></option>
            <?php
} while ($row_rsGradeList = mysql_fetch_assoc($rsGradeList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">CGPA</td>
          <td><input type="text" name="edu_cgpa" value="<?php echo htmlentities($row_rsUserEdu['edu_cgpa'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Insititute/University</td>
          <td><input type="text" name="edu_university" value="<?php echo htmlentities($row_rsUserEdu['edu_university'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Located In</td>
          <td><select name="edu_located">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsLocatedList['national_id']?>" <?php if (!(strcmp($row_rsLocatedList['national_id'], htmlentities($row_rsUserEdu['edu_located'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rsLocatedList['national_name']?></option>
            <?php
} while ($row_rsLocatedList = mysql_fetch_assoc($rsLocatedList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Graduation Date:</td>
          <td>
          <select name="edu_date_graduate_month" class="date">
        <option value="13">Month</option>
        <?php 
		for($i = 1; $i <= 12; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select>
        <select name="edu_date_graduate_year" class="date">
        <option value="1900">Year</option>
        <?php 
		for($i = 1960; $i <= date('Y'); $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Update Qualification"></td>
        </tr>
      </table>
      <input type="hidden" name="edu_id" value="<?php echo $row_rsUserEdu['edu_id']; ?>">
      <input type="hidden" name="user_id_fk" value="<?php echo htmlentities($_SESSION['MM_UserID']); ?>">
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="edu_id" value="<?php echo $row_rsUserEdu['edu_id']; ?>">
    </form>
    <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
  </div>
</div>

          </div><!-- #content-->
	
		  <aside id="sideRight" class="hide">
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
			<?php include("footer.php"); ?>
		</div><!-- .center -->
	</footer><!-- #footer -->



</body>
</html>
<?php
mysql_free_result($rsEduList);

mysql_free_result($rsFieldList);

mysql_free_result($rsGradeList);

mysql_free_result($rsLocatedList);

mysql_free_result($rsUserEdu);
?>
