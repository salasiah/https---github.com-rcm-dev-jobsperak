<?php require_once('../Connections/conJobsPerak.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsSuccessfulAction = 50;
$pageNum_rsSuccessfulAction = 0;
if (isset($_GET['pageNum_rsSuccessfulAction'])) {
  $pageNum_rsSuccessfulAction = $_GET['pageNum_rsSuccessfulAction'];
}
$startRow_rsSuccessfulAction = $pageNum_rsSuccessfulAction * $maxRows_rsSuccessfulAction;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsSuccessfulAction = "SELECT jp_users.users_email, jp_users.users_fname,   jp_users.users_lname,   jp_employer.emp_name,   jp_shortlisted.is_approve,   jp_ads.ads_title, jp_jobseeker.jobseeker_mobile FROM jp_shortlisted Inner Join   jp_jobseeker On jp_shortlisted.joseeker_id_fk = jp_jobseeker.jobseeker_id   Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id Inner Join   jp_employer On jp_shortlisted.employer_id_fk = jp_employer.emp_id Inner Join   jp_ads On jp_shortlisted.ads_id_fk = jp_ads.ads_id WHERE jp_shortlisted.is_approve = 2";
$query_limit_rsSuccessfulAction = sprintf("%s LIMIT %d, %d", $query_rsSuccessfulAction, $startRow_rsSuccessfulAction, $maxRows_rsSuccessfulAction);
$rsSuccessfulAction = mysql_query($query_limit_rsSuccessfulAction, $conJobsPerak) or die(mysql_error());
$row_rsSuccessfulAction = mysql_fetch_assoc($rsSuccessfulAction);

if (isset($_GET['totalRows_rsSuccessfulAction'])) {
  $totalRows_rsSuccessfulAction = $_GET['totalRows_rsSuccessfulAction'];
} else {
  $all_rsSuccessfulAction = mysql_query($query_rsSuccessfulAction);
  $totalRows_rsSuccessfulAction = mysql_num_rows($all_rsSuccessfulAction);
}
$totalPages_rsSuccessfulAction = ceil($totalRows_rsSuccessfulAction/$maxRows_rsSuccessfulAction)-1;$maxRows_rsSuccessfulAction = 50;
$pageNum_rsSuccessfulAction = 0;
if (isset($_GET['pageNum_rsSuccessfulAction'])) {
  $pageNum_rsSuccessfulAction = $_GET['pageNum_rsSuccessfulAction'];
}
$startRow_rsSuccessfulAction = $pageNum_rsSuccessfulAction * $maxRows_rsSuccessfulAction;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsSuccessfulAction = "SELECT jp_users.users_email, jp_users.users_fname,   jp_users.users_lname,   jp_employer.emp_name,   jp_shortlisted.is_approve,   jp_ads.ads_title, jp_jobseeker.jobseeker_mobile,  jp_shortlisted.shortlisted_id FROM jp_shortlisted Inner Join   jp_jobseeker On jp_shortlisted.joseeker_id_fk = jp_jobseeker.jobseeker_id   Inner Join   jp_users On jp_jobseeker.users_id_fk = jp_users.users_id Inner Join   jp_employer On jp_shortlisted.employer_id_fk = jp_employer.emp_id Inner Join   jp_ads On jp_shortlisted.ads_id_fk = jp_ads.ads_id WHERE jp_shortlisted.is_approve = 2";
$query_limit_rsSuccessfulAction = sprintf("%s LIMIT %d, %d", $query_rsSuccessfulAction, $startRow_rsSuccessfulAction, $maxRows_rsSuccessfulAction);
$rsSuccessfulAction = mysql_query($query_limit_rsSuccessfulAction, $conJobsPerak) or die(mysql_error());
$row_rsSuccessfulAction = mysql_fetch_assoc($rsSuccessfulAction);

if (isset($_GET['totalRows_rsSuccessfulAction'])) {
  $totalRows_rsSuccessfulAction = $_GET['totalRows_rsSuccessfulAction'];
} else {
  $all_rsSuccessfulAction = mysql_query($query_rsSuccessfulAction);
  $totalRows_rsSuccessfulAction = mysql_num_rows($all_rsSuccessfulAction);
}
$totalPages_rsSuccessfulAction = ceil($totalRows_rsSuccessfulAction/$maxRows_rsSuccessfulAction)-1;

$queryString_rsSuccessfulAction = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsSuccessfulAction") == false && 
        stristr($param, "totalRows_rsSuccessfulAction") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsSuccessfulAction = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsSuccessfulAction = sprintf("&totalRows_rsSuccessfulAction=%d%s", $totalRows_rsSuccessfulAction, $queryString_rsSuccessfulAction);
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

  // When a visitor has logged into this site, the Session variable MM_Admin set equal to their username. 
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
        
    <h2>Successful Pending</h2>
    <?php if ($totalRows_rsSuccessfulAction == 0) { // Show if recordset empty ?>
      <p>No Applicant Yet</p>
  <?php } // Show if recordset empty ?>
    <?php if ($totalRows_rsSuccessfulAction > 0) { // Show if recordset is not empty ?>
  <table id="rounded-corner">
    <thead>
      <tr>
        <th scope="col" class="rounded">Name</th>
        <th scope="col" class="rounded">Phone</th>
        <th scope="col" class="rounded">Title / Employer</th>
        <th scope="col" class="rounded">Status</th>
        <th scope="col" class="rounded">Edit</th>
        <th scope="col" class="rounded">Delete</th>
        </tr>
    </thead>
    
    <tbody>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsSuccessfulAction['users_fname']; ?>, <?php echo $row_rsSuccessfulAction['users_lname']; ?></td>
          <td><?php echo $row_rsSuccessfulAction['jobseeker_mobile']; ?></td>
          <td align="center" valign="middle"><?php echo $row_rsSuccessfulAction['ads_title']; ?> by <?php echo $row_rsSuccessfulAction['emp_name']; ?></td>
          <td align="center" valign="middle">
            <?php 
		
		if($row_rsSuccessfulAction['is_approve'] == 2) {
			echo "<span style=\"font-weight:bold;color:red;\">Pending Approval</span>";
		}
		
		?></td>
          <td><a href="successfulActionDone.php?shortlisted_id=<?php echo $row_rsSuccessfulAction['shortlisted_id']; ?>"><img src="images/user_edit.png" width="16" height="16" /></a></td>
          <td><img src="images/trash.png" alt="" title="" border="0" /></td>
        </tr>
        <?php } while ($row_rsSuccessfulAction = mysql_fetch_assoc($rsSuccessfulAction)); ?>
    </tbody>
  </table>
  <?php } // Show if recordset empty ?>
<div class="pagination">
          <table border="0">
            <tr>
              <td><?php if ($pageNum_rsSuccessfulAction > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_rsSuccessfulAction=%d%s", $currentPage, 0, $queryString_rsSuccessfulAction); ?>">First</a>
              <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_rsSuccessfulAction > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_rsSuccessfulAction=%d%s", $currentPage, max(0, $pageNum_rsSuccessfulAction - 1), $queryString_rsSuccessfulAction); ?>">Previous</a>
              <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_rsSuccessfulAction < $totalPages_rsSuccessfulAction) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_rsSuccessfulAction=%d%s", $currentPage, min($totalPages_rsSuccessfulAction, $pageNum_rsSuccessfulAction + 1), $queryString_rsSuccessfulAction); ?>">Next</a>
              <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_rsSuccessfulAction < $totalPages_rsSuccessfulAction) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_rsSuccessfulAction=%d%s", $currentPage, $totalPages_rsSuccessfulAction, $queryString_rsSuccessfulAction); ?>">Last</a>
              <?php } // Show if not last page ?></td>
            </tr>
          </table>
        </div>
        
        <div class="pagination" style="display:none">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>…<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div>
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
     <?php include 'footer.php'; ?>

</div>		
</body>
</html>
<?php
mysql_free_result($rsSuccessfulAction);
?>
