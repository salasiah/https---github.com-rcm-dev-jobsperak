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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_employer (emp_id, emp_name, emp_desc, emp_industry_id_fk, emp_address, emp_tel, emp_email, emp_web, users_id_fk) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['emp_id'], "int"),
                       GetSQLValueString($_POST['emp_name'], "text"),
                       GetSQLValueString($_POST['emp_desc'], "text"),
                       GetSQLValueString($_POST['emp_industry_id_fk'], "int"),
                       GetSQLValueString($_POST['emp_address'], "text"),
                       GetSQLValueString($_POST['emp_tel'], "text"),
                       GetSQLValueString($_POST['emp_email'], "text"),
                       GetSQLValueString($_POST['emp_web'], "text"),
                       GetSQLValueString($_POST['users_id_fk'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());

  $insertGoTo = "employerDashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsEmployerProfile = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsEmployerProfile = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerProfile = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsEmployerProfile, "int"));
$rsEmployerProfile = mysql_query($query_rsEmployerProfile, $conJobsPerak) or die(mysql_error());
$row_rsEmployerProfile = mysql_fetch_assoc($rsEmployerProfile);
$totalRows_rsEmployerProfile = mysql_num_rows($rsEmployerProfile);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIndustry = "SELECT * FROM jp_industry WHERE industry_parent = 0";
$rsIndustry = mysql_query($query_rsIndustry, $conJobsPerak) or die(mysql_error());
$row_rsIndustry = mysql_fetch_assoc($rsIndustry);
$totalRows_rsIndustry = mysql_num_rows($rsIndustry);

$colname_rsCompanyInfoDetail = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsCompanyInfoDetail = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCompanyInfoDetail = sprintf("SELECT * FROM jp_employer WHERE users_id_fk = %s", GetSQLValueString($colname_rsCompanyInfoDetail, "int"));
$rsCompanyInfoDetail = mysql_query($query_rsCompanyInfoDetail, $conJobsPerak) or die(mysql_error());
$row_rsCompanyInfoDetail = mysql_fetch_assoc($rsCompanyInfoDetail);
$totalRows_rsCompanyInfoDetail = mysql_num_rows($rsCompanyInfoDetail);
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
$MM_authorizedUsers = "2";
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
<h2>Employer Profile</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  <?php include("employer_menu.php"); ?>
<br/>
  <strong>Company Profile</strong><br/><br/>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td nowrap align="right">Company Name:</td>
        <td><input type="text" name="emp_name" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="top">Description</td>
        <td><textarea name="emp_desc" cols="50" rows="5"></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Industry</td>
        <td><select name="emp_industry_id_fk">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsIndustry['indus_id']?>" ><?php echo $row_rsIndustry['indus_name']?></option>
          <?php
} while ($row_rsIndustry = mysql_fetch_assoc($rsIndustry));
?>
        </select></td>
      <tr>
      <tr valign="baseline">
        <td nowrap align="right">Address:</td>
        <td><input type="text" name="emp_address" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Telephone</td>
        <td><input type="text" name="emp_tel" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Email:</td>
        <td><input type="text" name="emp_email" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Website:</td>
        <td><input type="text" name="emp_web" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Add Details"></td>
      </tr>
    </table>
    <input type="hidden" name="emp_id" value="">
    <input type="hidden" name="users_id_fk" value="<?php echo $_SESSION['MM_UserID']; ?>">
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <p>&nbsp;</p>
</div>

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
mysql_free_result($rsEmployerProfile);

mysql_free_result($rsIndustry);

mysql_free_result($rsCompanyInfoDetail);
?>
