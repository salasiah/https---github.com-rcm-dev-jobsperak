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
  $insertSQL = sprintf("INSERT INTO jp_ads (ads_id, ads_title, ads_details, emp_id_fk, ads_location, ads_salary, ads_y_exp, ads_enable_view, ads_featured, ads_industry_id_fk) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ads_id'], "int"),
                       GetSQLValueString($_POST['ads_title'], "text"),
                       GetSQLValueString($_POST['ads_details'], "text"),
                       GetSQLValueString($_POST['emp_id_fk'], "int"),
                       GetSQLValueString($_POST['ads_location'], "int"),
                       GetSQLValueString($_POST['ads_salary'], "text"),
                       GetSQLValueString($_POST['ads_y_exp'], "int"),
                       GetSQLValueString($_POST['ads_enable_view'], "int"),
                       GetSQLValueString($_POST['ads_featured'], "int"),
                       GetSQLValueString($_POST['ads_industry_id_fk'], "int"));

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
$query_rsIndustry = "SELECT * FROM jp_industry WHERE industry_parent = 0 LIMIT 0, 60";
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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLoc = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsLoc = mysql_query($query_rsLoc, $conJobsPerak) or die(mysql_error());
$row_rsLoc = mysql_fetch_assoc($rsLoc);
$totalRows_rsLoc = mysql_num_rows($rsLoc);

$colname_rsEmployerId = @$_SESSION['MM_UserID'];
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsEmployerId = $_SESSION['MM_UserID'];
}
$colname_rsEmployerId = "-1";
if (isset($_GET['emp_id'])) {
  $colname_rsEmployerId = $_GET['emp_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerId = sprintf("SELECT emp_id FROM jp_employer WHERE emp_id = %s", GetSQLValueString($colname_rsEmployerId, "int"));
$rsEmployerId = mysql_query($query_rsEmployerId, $conJobsPerak) or die(mysql_error());
$row_rsEmployerId = mysql_fetch_assoc($rsEmployerId);
$totalRows_rsEmployerId = mysql_num_rows($rsEmployerId);
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
<script src="scripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2204022" binding="#postContent" />
</oa:widgets>
-->
</script>
</head>

<body>
<script type="text/javascript">
// BeginOAWidget_Instance_2204022: #postContent

	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "postContent",
		theme : "advanced",
		skin : "default",
		content_css : "css/custom_content.css",
theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,link,unlink,anchor,",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "none",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "/css/editor_styles.css",

		// Drop lists for link/image/media/template dialogs, You shouldn't need to touch this
		template_external_list_url : "/lists/template_list.js",
		external_link_list_url : "/lists/link_list.js",
		external_image_list_url : "/lists/image_list.js",
		media_external_list_url : "/lists/media_list.js",

		// Style formats: You must add here all the inline styles and css classes exposed to the end user in the styles menus
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		]
	});
		
// EndOAWidget_Instance_2204022
</script>
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
  <?php include("employer_menu.php"); ?><br/> 
<strong>Add New Job Ads</strong><br/><br/>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Job Title:</td>
      <td><input type="text" name="ads_title" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Job Details:</td>
      <td><textarea name="ads_details" cols="80" id="postContent" rows="11" style="width:440px"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Location:</td>
      <td><select name="ads_location" class="date">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsLoc['location_id']?>" ><?php echo $row_rsLoc['location_name']?></option>
        <?php
} while ($row_rsLoc = mysql_fetch_assoc($rsLoc));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Salary</td>
      <td><input type="text" name="ads_salary" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Year Experience</td>
      <td><select name="ads_y_exp" class="date">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>4</option>
        <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>5</option>
        <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>6</option>
        <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>7</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Industry</td>
      <td><select name="ads_industry_id_fk" class="date">
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
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Submit Job Ads"></td>
    </tr>
  </table>
  <input type="hidden" name="ads_id" value="">
  <input type="hidden" name="emp_id_fk" value="<?php echo $row_rsEmployerId['emp_id']; ?>">
  <input type="hidden" name="ads_enable_view" value="0">
  <input type="hidden" name="ads_featured" value="0">
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

mysql_free_result($rsLoc);

mysql_free_result($rsEmployerId);
?>
