<?php require_once('../Connections/conJobsPerak.php'); ?>
<?php

$get_user_id  = $_GET['uid'];

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


$colname_rsEditUser = "-1";
if (isset($_GET['uid'])) {
  $colname_rsEditUser = $_GET['uid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEditUser = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsEditUser, "int"));
$rsEditUser = mysql_query($query_rsEditUser, $conJobsPerak) or die(mysql_error());
$row_rsEditUser = mysql_fetch_assoc($rsEditUser);
$totalRows_rsEditUser = mysql_num_rows($rsEditUser);

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
<?php
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE jp_users SET users_type=%s WHERE users_id=%s",
                       GetSQLValueString($_POST['user_cat'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($updateSQL, $conJobsPerak) or die(mysql_error());

  $updateGoTo = "manageUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
                    <ul>
                    <li><a href="dashboard.php">Admin Home</a></li>
                    <li><a href="manageJobseeker.php">Manage Jobseekers<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a href="manageEmployer.php">Manage Employers<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a class="current" href="manageUser.php">Manage Users<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a href="manageAds.php">Manage Ads<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content"> 

    <?php include 'sidemenu.php'; ?>
    
    <div class="right_content">            
        
     <h2>Edit User - <?php echo $row_rsEditUser['users_fname']; ?> <?php echo $row_rsEditUser['users_lname']; ?></h2>
     
      <div class="form">
<form name="form" action="<?php echo $editFormAction; ?>" method="POST" class="niceform">
         
                <fieldset>
                <input name="id" type="hidden" value="<?php echo $row_rsEditUser['users_id']; ?>" />
                    <dl>
                        <dt><label for="user_fname">First Name:</label></dt>
                        <dd><input name="user_fname" type="text" id="" value="<?php echo $row_rsEditUser['users_fname']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="user_lname">Last Name:</label></dt>
                        <dd><input name="user_lname" type="text" id="" value="<?php echo $row_rsEditUser['users_lname']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="user_email">Email:</label></dt>
                        <dd><input name="user_email" type="text" id="" value="<?php echo $row_rsEditUser['users_email']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="user_act">Active:</label></dt>
                        <?php 
                        $active = "Active";
                        $not_active = "Not Active";
                        if ($row_rsEditUser['user_active'] == 0) { ?>
                          <dd><input name="user_act" type="text" id="" value="<?php echo $not_active; ?>" size="54" readonly="readonly" /></dd>
                        <?php }
                        elseif ($row_rsEditUser['user_active'] == 1) { ?>
                          <dd><input name="user_act" type="text" id="" value="<?php echo $active; ?>" size="54" readonly="readonly" /></dd>
                        <?php } ?>
                    </dl>
                    <dl>
                        <dt><label for="user_cat">Category:</label></dt>
                        <dd>
                            <select size="1" name="user_cat" id="">
                              <?php 
                                if ($row_rsEditUser['users_type'] == 1) { ?>
                                <option value="1" selected="selected">Jobseeker</option>
                                <option value="2">Employer</option>
                                <option value="3">Super Administrator</option>
                              <?php } 
                                elseif ($row_rsEditUser['users_type'] == 2) { ?>
                                <option value="1">Jobseeker</option>
                                <option value="2" selected="selected">Employer</option>
                                <option value="3">Super Administrator</option>
                              <?php } 
                                elseif ($row_rsEditUser['users_type'] == 3) { ?>
                                <option value="1">Jobseeker</option>
                                <option value="2">Employer</option>
                                <option value="3" selected="selected">Super Administrator</option>
                              <?php } ?>
                                
                            </select>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                        <input type="submit" name="submit" id="submit" value="Update" />

                     </dl>

                </fieldset>
                <input type="hidden" name="MM_update" value="form" />
</form>
         
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
mysql_free_result($rsEditUser);

?>
