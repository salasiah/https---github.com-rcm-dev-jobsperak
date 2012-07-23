<?php require_once('../Connections/conJobsPerak.php'); ?><?php require_once('../Connections/conJobsPerak.php'); ?>
<?php require_once('../Connections/conJobsPerak.php'); ?>
<?php require_once('../Connections/conJobsPerak.php'); ?>
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
  $_SESSION['MM_Admin'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Admin']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
    
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}



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
$query_rsAdsInd = "SELECT jp_ads.ads_id, jp_ads.ads_industry_id_fk AS ind_id, jp_industry.indus_id, jp_industry.indus_name AS ind_name, COUNT(jp_industry.indus_name) AS ind_count FROM jp_ads Inner Join jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Group By jp_industry.indus_name";
$rsAdsInd = mysql_query($query_rsAdsInd, $conJobsPerak) or die(mysql_error());
$row_rsAdsInd = mysql_fetch_assoc($rsAdsInd);
$totalRows_rsAdsInd = mysql_num_rows($rsAdsInd);

?>

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
if (!((isset($_SESSION['MM_Admin'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Admin'], $_SESSION['MM_UserGroup'])))) {   
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
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAdsLoc = "SELECT jp_location.location_id AS loc_id, jp_location.location_name AS loc_name FROM jp_location GROUP BY jp_location.location_id limit 0, 14";
$rsAdsLoc = mysql_query($query_rsAdsLoc, $conJobsPerak) or die(mysql_error());
$row_rsAdsLoc = mysql_fetch_assoc($rsAdsLoc);
$totalRows_rsAdsLoc = mysql_num_rows($rsAdsLoc);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAdsLocVal = "SELECT jp_ads.ads_id AS id, jp_ads.ads_location, COUNT(jp_ads.ads_location) AS location FROM jp_ads GROUP BY jp_ads.ads_location";
$rsAdsLocVal = mysql_query($query_rsAdsLocVal, $conJobsPerak) or die(mysql_error());
$row_rsAdsLocVal = mysql_fetch_assoc($rsAdsLocVal);
$totalRows_rsAdsLocVal = mysql_num_rows($rsAdsLocVal);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlUser = "Select   Count(*) As totalUser From   jp_users";
$ttlUser = mysql_query($query_ttlUser, $conJobsPerak) or die(mysql_error());
$row_ttlUser = mysql_fetch_assoc($ttlUser);
$totalRows_ttlUser = mysql_num_rows($ttlUser);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlUserActive = "Select   Count(*) As totalUser From   jp_users Where   jp_users.user_active = 1 Group By   jp_users.user_active";
$ttlUserActive = mysql_query($query_ttlUserActive, $conJobsPerak) or die(mysql_error());
$row_ttlUserActive = mysql_fetch_assoc($ttlUserActive);
$totalRows_ttlUserActive = mysql_num_rows($ttlUserActive);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlJs = "Select   Count(*) As ttlJs From   jp_jobseeker";
$ttlJs = mysql_query($query_ttlJs, $conJobsPerak) or die(mysql_error());
$row_ttlJs = mysql_fetch_assoc($ttlJs);
$totalRows_ttlJs = mysql_num_rows($ttlJs);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlEmp = "Select   Count(*) As ttlEmp From   jp_employer";
$ttlEmp = mysql_query($query_ttlEmp, $conJobsPerak) or die(mysql_error());
$row_ttlEmp = mysql_fetch_assoc($ttlEmp);
$totalRows_ttlEmp = mysql_num_rows($ttlEmp);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlAds = "Select   Count(*) As ttlAds From   jp_ads Where   jp_ads.ads_enable_view = 1 Group By   jp_ads.ads_enable_view";
$ttlAds = mysql_query($query_ttlAds, $conJobsPerak) or die(mysql_error());
$row_ttlAds = mysql_fetch_assoc($ttlAds);
$totalRows_ttlAds = mysql_num_rows($ttlAds);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlJbApp = "Select   Count(*) As ttljsapp From   jp_application";
$ttlJbApp = mysql_query($query_ttlJbApp, $conJobsPerak) or die(mysql_error());
$row_ttlJbApp = mysql_fetch_assoc($ttlJbApp);
$totalRows_ttlJbApp = mysql_num_rows($ttlJbApp);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlShortlisted = "Select   Count(*) As ttlShortlisted From   jp_shortlisted";
$ttlShortlisted = mysql_query($query_ttlShortlisted, $conJobsPerak) or die(mysql_error());
$row_ttlShortlisted = mysql_fetch_assoc($ttlShortlisted);
$totalRows_ttlShortlisted = mysql_num_rows($ttlShortlisted);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlReject = "Select   Count(*) As ttlRejected From   jp_shortlisted Where   jp_shortlisted.is_reject = 1 Group By   jp_shortlisted.is_reject";
$ttlReject = mysql_query($query_ttlReject, $conJobsPerak) or die(mysql_error());
$row_ttlReject = mysql_fetch_assoc($ttlReject);
$totalRows_ttlReject = mysql_num_rows($ttlReject);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlApproved = "Select   Count(*) As ttlApproved From   jp_shortlisted Where   jp_shortlisted.is_approve = 1 Group By   jp_shortlisted.is_approve";
$ttlApproved = mysql_query($query_ttlApproved, $conJobsPerak) or die(mysql_error());
$row_ttlApproved = mysql_fetch_assoc($ttlApproved);
$totalRows_ttlApproved = mysql_num_rows($ttlApproved);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_ttlPending = "Select   Count(*) As ttlPending From   jp_ads Where   jp_ads.ads_enable_view = 0 Group By   jp_ads.ads_enable_view";
$ttlPending = mysql_query($query_ttlPending, $conJobsPerak) or die(mysql_error());
$row_ttlPending = mysql_fetch_assoc($ttlPending);
$totalRows_ttlPending = mysql_num_rows($ttlPending);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_outData = "Select   Count(*) As outData From jp_outside_successful";
$outData = mysql_query($query_outData, $conJobsPerak) or die(mysql_error());
$row_outData = mysql_fetch_assoc($outData);
$totalRows_outData = mysql_num_rows($outData);

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
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_DetailRS1 = sprintf("SELECT * FROM jp_roadshow WHERE rs_id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $conJobsPerak) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jobsperak Admin</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="clockp.js"></script>
<script type="text/javascript" src="clockh.js"></script> 
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
    headerclass: "submenuheader", //Shared CSS class name of headers group
    contentclass: "submenu", //Shared CSS class name of contents group
    revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
    mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
    collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
    defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
    onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
    animatedefault: false, //Should contents open by default be animated into view?
    persiststate: true, //persist state of opened contents within browser session?
    toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
    togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
    animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
    oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
        //do nothing
    },
    onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
        //do nothing
    }
})
</script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        $('.ask').jConfirmAction();
    });
    
</script>

<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

</head>
<body>
<div id="main_container">

    <div class="header">
    <div class="logo"><a href="dashboard.php"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Welcome <?php echo $_SESSION['MM_Admin']; ?>, | <a href="<?php echo $logoutAction ?>" class="logout">Logout</a></div>
    <div id="clock_a"></div>
    </div>
    
    <div class="main_content">
    
                    <div class="menu">
                    <?php include('admin_menu.php'); ?>
                    </div> 
                    
                    
                    
    <div class="center_content">  
    
    <?php include 'sidemenu.php'; ?>
    
    <div class="right_content">

		<h2>Road Show List</h2>
        
<table border="1" align="center">
  <tr>
    <td>rs_id</td>
    <td><?php echo $row_DetailRS1['rs_id']; ?></td>
  </tr>
  <tr>
    <td>rs_name</td>
    <td><?php echo $row_DetailRS1['rs_name']; ?></td>
  </tr>
  <tr>
    <td>rs_address</td>
    <td><?php echo $row_DetailRS1['rs_address']; ?></td>
  </tr>
  <tr>
    <td>rs_lat</td>
    <td><?php echo $row_DetailRS1['rs_lat']; ?></td>
  </tr>
  <tr>
    <td>rs_long</td>
    <td><?php echo $row_DetailRS1['rs_long']; ?></td>
  </tr>
  <tr>
    <td>rs_date</td>
    <td><?php echo $row_DetailRS1['rs_date']; ?></td>
  </tr>
  <tr>
    <td>status</td>
    <td><?php echo $row_DetailRS1['status']; ?></td>
  </tr>
</table>
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    <?php include 'footer.php'; ?>
    

</div>
		
</body>
</html>
<?php
mysql_free_result($rsAdsInd);

mysql_free_result($rsAdsLoc);

mysql_free_result($rsAdsLocVal);

mysql_free_result($ttlUser);

mysql_free_result($ttlUserActive);

mysql_free_result($ttlJs);

mysql_free_result($ttlEmp);

mysql_free_result($ttlAds);

mysql_free_result($ttlJbApp);

mysql_free_result($ttlShortlisted);

mysql_free_result($ttlReject);

mysql_free_result($ttlApproved);

mysql_free_result($ttlPending);

mysql_free_result($outData);

mysql_free_result($DetailRS1);

?>