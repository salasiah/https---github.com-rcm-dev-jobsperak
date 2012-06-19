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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_experience (exp_id, users_id_fk, exp_co_name, industry_id_fk, exp_pos_title, exp_specialize, exp_role, exp_monthlysalary, exp_word_desc, exp_from_to, exp_to_m, exp_to_y, exp_from_to_y, exp_pos_level) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['exp_id'], "int"),
                       GetSQLValueString($_POST['users_id_fk'], "int"),
                       GetSQLValueString($_POST['exp_co_name'], "text"),
                       GetSQLValueString($_POST['industry_id_fk'], "int"),
                       GetSQLValueString($_POST['exp_pos_title'], "text"),
                       GetSQLValueString($_POST['exp_specialize'], "int"),
                       GetSQLValueString($_POST['exp_role'], "text"),
                       GetSQLValueString($_POST['exp_monthlysalary'], "int"),
                       GetSQLValueString($_POST['exp_word_desc'], "text"),
                       GetSQLValueString($_POST['exp_from_to'], "int"),
                       GetSQLValueString($_POST['exp_to_m'], "int"),
                       GetSQLValueString($_POST['exp_to_y'], "int"),
                       GetSQLValueString($_POST['exp_from_to_y'], "int"),
                       GetSQLValueString($_POST['exp_pos_level'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());

  $insertGoTo = "jobSeekerMyResume.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIndustryList = "SELECT * FROM jp_industry";
$rsIndustryList = mysql_query($query_rsIndustryList, $conJobsPerak) or die(mysql_error());
$row_rsIndustryList = mysql_fetch_assoc($rsIndustryList);
$totalRows_rsIndustryList = mysql_num_rows($rsIndustryList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsSpecializeList = "SELECT * FROM jp_specialize";
$rsSpecializeList = mysql_query($query_rsSpecializeList, $conJobsPerak) or die(mysql_error());
$row_rsSpecializeList = mysql_fetch_assoc($rsSpecializeList);
$totalRows_rsSpecializeList = mysql_num_rows($rsSpecializeList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLevelList = "SELECT * FROM jp_level";
$rsLevelList = mysql_query($query_rsLevelList, $conJobsPerak) or die(mysql_error());
$row_rsLevelList = mysql_fetch_assoc($rsLevelList);
$totalRows_rsLevelList = mysql_num_rows($rsLevelList);
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
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php //echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  
  <div class="master_details boxcenter">
	<h3>Add new experience</h3><br/>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Company Name:</td>
          <td><input type="text" name="exp_co_name" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Industry:</td>
          <td><select name="industry_id_fk" class="date">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsIndustryList['indus_id']?>" ><?php echo $row_rsIndustryList['indus_name']?></option>
            <?php
} while ($row_rsIndustryList = mysql_fetch_assoc($rsIndustryList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Position Title</td>
          <td><input type="text" name="exp_pos_title" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Specialize</td>
          <td><select name="exp_specialize" class="date">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsSpecializeList['specialize_id']?>" ><?php echo $row_rsSpecializeList['specialize_name']?></option>
            <?php
} while ($row_rsSpecializeList = mysql_fetch_assoc($rsSpecializeList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">Role:</td>
          <td><input type="text" name="exp_role" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Monthly Salary</td>
          <td><input type="text" name="exp_monthlysalary" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right" valign="top">Work Description</td>
          <td><textarea name="exp_word_desc" cols="50" rows="5"></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Period From</td>
          <td><select name="exp_from_to" class="date">
        <option value="13">Month</option>
        <?php 
		for($i = 1; $i <= 12; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select> <select name="exp_from_to_y" class="date">
        <option value="1900">Year</option>
        <?php 
		for($i = 1960; $i <= date('Y'); $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">To</td>
          <td><select name="exp_to_m" class="date">
        <option value="13">Month</option>
        <?php 
		for($i = 1; $i <= 12; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select> <select name="exp_to_y" class="date">
        <option value="1900">Year</option>
        <?php 
		for($i = 1960; $i <= date('Y'); $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Position Level</td>
          <td><select name="exp_pos_level" class="date">
            <?php 
do {  
?>
            <option value="<?php echo $row_rsLevelList['level_id']?>" ><?php echo $row_rsLevelList['level_position']?></option>
            <?php
} while ($row_rsLevelList = mysql_fetch_assoc($rsLevelList));
?>
          </select></td>
        <tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insert record"></td>
        </tr>
      </table>
      <input type="hidden" name="exp_id" value="">
      <input type="hidden" name="users_id_fk" value="<?php echo $_SESSION['MM_UserID']; ?>">
      <input type="hidden" name="MM_insert" value="form1">
    </form>
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
mysql_free_result($rsIndustryList);

mysql_free_result($rsSpecializeList);

mysql_free_result($rsLevelList);
?>
