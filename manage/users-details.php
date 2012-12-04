<?php require_once('Connections/conPerak.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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

$colname_rsAdminName = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsAdminName = $_SESSION['MM_Username'];
}
mysql_select_db($database_conPerak, $conPerak);
$query_rsAdminName = sprintf("SELECT admin_name FROM jp_admin WHERE admin_name = %s", GetSQLValueString($colname_rsAdminName, "text"));
$rsAdminName = mysql_query($query_rsAdminName, $conPerak) or die(mysql_error());
$row_rsAdminName = mysql_fetch_assoc($rsAdminName);
$totalRows_rsAdminName = mysql_num_rows($rsAdminName);

mysql_select_db($database_conPerak, $conPerak);
$query_rsLanguageList = "SELECT * FROM jp_language_list";
$rsLanguageList = mysql_query($query_rsLanguageList, $conPerak) or die(mysql_error());
$row_rsLanguageList = mysql_fetch_assoc($rsLanguageList);
$totalRows_rsLanguageList = mysql_num_rows($rsLanguageList);

mysql_select_db($database_conPerak, $conPerak);
$query_rsUserLists = "SELECT * FROM jp_users";
$rsUserLists = mysql_query($query_rsUserLists, $conPerak) or die(mysql_error());
$row_rsUserLists = mysql_fetch_assoc($rsUserLists);
$totalRows_rsUserLists = mysql_num_rows($rsUserLists);

$maxRows_DetailRS1 = 50;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_conPerak, $conPerak);
$query_DetailRS1 = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $conPerak) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

mysql_select_db($database_conPerak, $conPerak);
$query_rsEmployerDetails = "Select   jp_industry.indus_name,   jp_employer.*,   jp_employer.users_id_fk As users_id_fk1 From   jp_employer Inner Join   jp_industry On jp_employer.emp_industry_id_fk = jp_industry.indus_id Where   jp_employer.users_id_fk = ".$colname_DetailRS1;
$rsEmployerDetails = mysql_query($query_rsEmployerDetails, $conPerak) or die(mysql_error());
$row_rsEmployerDetails = mysql_fetch_assoc($rsEmployerDetails);
$totalRows_rsEmployerDetails = mysql_num_rows($rsEmployerDetails);

mysql_select_db($database_conPerak, $conPerak);
$query_rsJobseekerDetails = "SELECT * FROM jp_jobseeker WHERE users_id_fk = ".$colname_DetailRS1;
$rsJobseekerDetails = mysql_query($query_rsJobseekerDetails, $conPerak) or die(mysql_error());
$row_rsJobseekerDetails = mysql_fetch_assoc($rsJobseekerDetails);
$totalRows_rsJobseekerDetails = mysql_num_rows($rsJobseekerDetails);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Jobsperak Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <?php include("header.php"); ?>

    <div class="container">

		<div style="text-align:center">
      
      <h1>Hello, <?php echo $row_rsAdminName['admin_name']; ?>! Here the list of all users.</h1>
      <p>I was listed all the users registered and here the details.</p><br/><br/>
      </div>
      <div>
      <h3>User Details</h3>
      <table border="0" class="table table-hover table-striped" width="100%" align="center">
  
  <tr>
    <td width="20%" align="left" valign="middle">users_email</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_email']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_pass</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_pass']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_register</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_register']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_last_login</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_last_login']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_fname</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_fname']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_lname</td>
    <td align="left" valign="middle"><?php echo $row_DetailRS1['users_lname']; ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">users_type</td>
    <td align="left" valign="middle"><?php if($row_DetailRS1['users_type'] == 1){echo "Employer";}else{echo "Jobseeker";} ?> </td>
  </tr>
  <tr>
    <td align="left" valign="middle">user_active</td>
    <td align="left" valign="middle"><?php if($row_DetailRS1['user_active'] == 1){echo "Active";}else{echo"Not Active";} ?> </td>
  </tr>
  
  
</table>
	  </div>
      
      <?php if($totalRows_rsJobseekerDetails > 0) { ?>
      
      <div>
      <h3>Jobseeker Details</h3>
      <table width="100%" border="0" class="table table-hover table-striped">
  <tr>
    <td align="left" valign="middle" scope="col">&nbsp;</td>
    <td align="left" valign="middle" scope="col"><a href="jobSeekerResume.php?js_id=<?php echo $row_DetailRS1['users_id']; ?>">Full Resume View</a></td>
  </tr>
  <tr>
    <td width="20%" align="left" valign="middle" scope="col">Pic</td>
    <td align="left" valign="middle" scope="col"><img src="http://jobsperak.com/v1/<?php echo $row_rsJobseekerDetails['jobseeker_pic']; ?>" alt="Image" width="120" height="100%" vspace="0" class="img-polaroid"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">IC</td>
    <td align="left" valign="middle" scope="col"><?php if($row_rsJobseekerDetails['joobseeker_ic'] == ''){echo "Not Provided";}else{echo $row_rsJobseekerDetails['joobseeker_ic'];} ?></td>
    </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Tel</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_tel']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Mobile</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_mobile']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Address</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_address']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Poscode</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_address_poscode']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">State</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_address_state']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">District</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_address_district']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Subdistrict</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_address_subdistrict']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">DOB</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_dob_y']; ?> / <?php echo $row_rsJobseekerDetails['jobseeker_dob_m']; ?> / <?php echo $row_rsJobseekerDetails['jobseeker_dob_d']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Male</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_gender']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Nationality</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_nationality']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">More info</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['jobseeker_moreinfo']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Marital</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsJobseekerDetails['employment_status']; ?></td>
  </tr>
      </table>

		
      </div>
      <?php } ?>
      
      
      <?php if($totalRows_rsEmployerDetails > 0) { ?>
      <div>
      <h3>Employer Details</h3>
      <table width="100%" border="0" class="table table-hover table-striped">
  <tr>
    <td width="20%" align="left" valign="middle" scope="col">Pic</td>
    <td align="left" valign="middle" scope="col"><img src="http://jobsperak.com/v1/media/employer/img/<?php echo $row_rsEmployerDetails['emp_pic']; ?>" alt="Image" vspace="0" class="img-polaroid"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Name</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_name']; ?></td>
    </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Description</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_desc']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Industry</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['indus_name']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Address</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_address']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Tel</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_tel']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Email</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_email']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle" scope="col">Website</td>
    <td align="left" valign="middle" scope="col"><?php echo $row_rsEmployerDetails['emp_web']; ?></td>
  </tr>
      </table>

      </div>
      <?php } ?>

    </div> <!-- /container -->

	<?php include("footer.php"); ?>
	    
  </body>
</html>
<?php
mysql_free_result($rsAdminName);

mysql_free_result($rsLanguageList);

mysql_free_result($rsUserLists);

mysql_free_result($DetailRS1);

mysql_free_result($rsEmployerDetails);

mysql_free_result($rsJobseekerDetails);
?>
