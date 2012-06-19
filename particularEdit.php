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
  $updateSQL = sprintf("UPDATE jp_jobseeker SET jobseeker_tel=%s, jobseeker_mobile=%s, jobseeker_address=%s, jobseeker_dob_y=%s, jobseeker_dob_m=%s, jobseeker_dob_d=%s, jobseeker_gender=%s, jobseeker_nationality=%s, jobseeker_moreinfo=%s, jobseeker_last_edited=%s WHERE users_id_fk=%s",
                       GetSQLValueString($_POST['jobseeker_tel'], "text"),
                       GetSQLValueString($_POST['jobseeker_mobile'], "text"),
                       GetSQLValueString($_POST['jobseeker_address'], "text"),
                       GetSQLValueString($_POST['jobseeker_dob_y'], "int"),
                       GetSQLValueString($_POST['jobseeker_dob_m'], "int"),
                       GetSQLValueString($_POST['jobseeker_dob_d'], "int"),
                       GetSQLValueString($_POST['jobseeker_gender'], "int"),
                       GetSQLValueString($_POST['jobseeker_nationality'], "int"),
                       GetSQLValueString($_POST['jobseeker_moreinfo'], "text"),
                       GetSQLValueString($_POST['jobseeker_last_edited'], "date"),
                       GetSQLValueString($_POST['users_id_fk'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($updateSQL, $conJobsPerak) or die(mysql_error());

  $updateGoTo = "jobSeekerDashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsNationality = "SELECT * FROM jp_nationality";
$rsNationality = mysql_query($query_rsNationality, $conJobsPerak) or die(mysql_error());
$row_rsNationality = mysql_fetch_assoc($rsNationality);
$totalRows_rsNationality = mysql_num_rows($rsNationality);

$colname_rsUpdateJobSeeker = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsUpdateJobSeeker = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsUpdateJobSeeker = sprintf("SELECT * FROM jp_jobseeker WHERE users_id_fk = %s", GetSQLValueString($colname_rsUpdateJobSeeker, "int"));
$rsUpdateJobSeeker = mysql_query($query_rsUpdateJobSeeker, $conJobsPerak) or die(mysql_error());
$row_rsUpdateJobSeeker = mysql_fetch_assoc($rsUpdateJobSeeker);
$totalRows_rsUpdateJobSeeker = mysql_num_rows($rsUpdateJobSeeker);
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
  
  <div class="master_details"><h3>Edit Particular Profile</h3></div>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <table width="600" align="center">
      <tr valign="baseline">
        <td nowrap align="right">Telephone:</td>
        <td><input type="text" name="jobseeker_tel" value="<?php echo $row_rsUpdateJobSeeker['jobseeker_tel']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Mobile Phone</td>
        <td><input type="text" name="jobseeker_mobile" value="<?php echo $row_rsUpdateJobSeeker['jobseeker_mobile']; ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="middle" nowrap>Address</td>
        <td><textarea name="jobseeker_address" cols="50" rows="5"><?php echo $row_rsUpdateJobSeeker['jobseeker_address']; ?></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Date Of Birth</td>
        <td><select name="jobseeker_dob_d" class="date">
        <option value="<?php echo $row_rsUpdateJobSeeker['jobseeker_dob_d']; ?>"><?php echo $row_rsUpdateJobSeeker['jobseeker_dob_d']; ?></option>
        <?php 
		for($i = 1; $i <= 31; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select> 
        <select name="jobseeker_dob_m" class="date">
        <option value="<?php echo $row_rsUpdateJobSeeker['jobseeker_dob_m']; ?>"><?php echo $row_rsUpdateJobSeeker['jobseeker_dob_m']; ?></option>
        <?php 
		for($i = 1; $i <= 12; $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select>
        <select name="jobseeker_dob_y" class="date">
        <option value="<?php echo $row_rsUpdateJobSeeker['jobseeker_dob_y']; ?>"><?php echo $row_rsUpdateJobSeeker['jobseeker_dob_y']; ?></option>
        <?php 
		for($i = 1960; $i <= date('Y'); $i++) { ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Gender</td>
        <td><select name="jobseeker_gender" class="date">
          <option value="2">Male</option>
          <option value="1">Female</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Nationality</td>
        <td><select name="jobseeker_nationality" class="date">
          <?php
do {  
?>
          <option value="<?php echo $row_rsNationality['national_id']?>"><?php echo $row_rsNationality['national_name']?></option>
          <?php
} while ($row_rsNationality = mysql_fetch_assoc($rsNationality));
  $rows = mysql_num_rows($rsNationality);
  if($rows > 0) {
      mysql_data_seek($rsNationality, 0);
	  $row_rsNationality = mysql_fetch_assoc($rsNationality);
  }
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right" valign="middle">Additional Info</td>
        <td><textarea name="jobseeker_moreinfo" cols="50" rows="5"><?php echo $row_rsUpdateJobSeeker['jobseeker_moreinfo']; ?></textarea></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Update Profile Info"></td>
      </tr>
    </table>
    <input type="hidden" name="users_id_fk" value="<?php echo $_SESSION['MM_UserID']; ?>">
    <input type="hidden" name="jobseeker_last_edited" value="">
    <input type="hidden" name="MM_update" value="form1">
  </form>
  <p>&nbsp;</p>
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
mysql_free_result($rsNationality);

mysql_free_result($rsUpdateJobSeeker);
?>
