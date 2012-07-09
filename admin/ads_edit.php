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
<?php require_once('../Connections/conJobsPerak.php'); 

$get_ads_id  = $_GET['uid'];

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
$query_rsEditAds = "SELECT jp_ads.ads_id, jp_ads.ads_title, jp_ads.ads_details, jp_ads.emp_id_fk, jp_ads.ads_location, jp_ads.ads_salary, jp_ads.ads_y_exp, jp_ads.ads_industry_id_fk, jp_ads.ads_enable_view, jp_ads.ads_featured, jp_ads.ads_date_expired, jp_employer.emp_name, jp_employer.emp_id, jp_industry.indus_id, jp_industry.indus_name, jp_location.location_id, jp_location.location_name, jp_ads.ads_minimum FROM jp_ads Inner Join jp_employer On jp_ads.emp_id_fk = jp_employer.emp_id Inner Join jp_industry On jp_ads.ads_industry_id_fk = jp_industry.indus_id Inner Join jp_location On jp_ads.ads_location = jp_location.location_id Where jp_ads.ads_id = '$get_ads_id'";
$rsEditAds = mysql_query($query_rsEditAds, $conJobsPerak) or die(mysql_error());
$row_rsEditAds = mysql_fetch_assoc($rsEditAds);
$totalRows_rsEditAds = mysql_num_rows($rsEditAds);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE jp_ads SET ads_enable_view=1 WHERE ads_id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($updateSQL, $conJobsPerak) or die(mysql_error());

  $updateGoTo = "manageAds.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE jp_ads SET ads_featured=%s WHERE ads_id=%s",
                       GetSQLValueString($_POST['ads_fet'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  $updateSQL2 = sprintf("UPDATE jp_ads SET ads_featured=%s WHERE ads_id=%s",
                       GetSQLValueString($_POST['ads_fet'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($updateSQL, $conJobsPerak) or die(mysql_error());
  $Result2 = mysql_query($updateSQL2, $conJobsPerak) or die(mysql_error());

  $updateGoTo = "manageAds.php";
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
                    <li><a href="manageUser.php">Manage Users<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a class="current" href="manageAds.php">Manage Ads<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content"> 

    <?php include 'sidemenu.php'; ?>
    
    <div class="right_content">            
        
     <h2>Edit Ads - <?php echo $row_rsEditAds['ads_title']; ?></h2>
     
      <div class="form">
<form name="form" action="<?php echo $editFormAction; ?>" method="POST" class="niceform">
         
                <fieldset>
                	<input name="id" type="hidden" value="<?php echo $row_rsEditAds['ads_id']; ?>" />
                    <dl>
                        <dt><label for="ads_title">Title:</label></dt>
                        <dd><input name="ads_title" type="text" id="" value="<?php echo $row_rsEditAds['ads_title']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_det">Details:</label></dt>
                        <dd><textarea name="ads_det" cols="43" rows="5" readonly="readonly" id="comments"><?php echo $row_rsEditAds['ads_details']; ?></textarea>
                        </dd>
                    </dl>
              		<dl>
                        <dt><label for="ads_adv">Advertiser:</label></dt>
                        <dd><input name="ads_adv" type="text" id="" value="<?php echo $row_rsEditAds['emp_name']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_loc">Location:</label></dt>
                        <dd><input name="ads_loc" type="text" id="" value="<?php echo $row_rsEditAds['location_name']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_sal">Salary (RM):</label></dt>
                        <dd><input name="ads_sal" type="text" id="" value="<?php echo $row_rsEditAds['ads_salary']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_year">Year(s) Experience:</label></dt>
                        <dd><input name="ads_year" type="text" id="" value="<?php echo $row_rsEditAds['ads_y_exp']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
              		<dl>
                        <dt><label for="ads_ind">Industry:</label></dt>
                        <dd><input name="ads_ind" type="text" id="" value="<?php echo $row_rsEditAds['indus_name']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_exp">Expired Date:</label></dt>
                        <dd><input name="ads_exp" type="text" id="" value="<?php echo $row_rsEditAds['ads_date_expired']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_exp">Job Minimum:</label></dt>
                        <dd>
                        <?php 

                        $minimum = $row_rsEditAds['ads_minimum']; 

                        switch ($minimum) {
                          case '1':
                            # code...
                          echo "PMR";
                            break;

                          case '2':
                            # code...
                          echo "SPM";
                            break;

                          case '3':
                            # code...
                          echo "STPM";
                            break;

                          case '4':
                            # code...
                          echo "Diploma";
                            break;

                          case '5':
                            # code...
                          echo "Degree";
                            break;

                          case '6':
                            # code...
                          echo "Master";
                            break;

                          case '7':
                            # code...
                          echo "PHD";
                            break;
                          
                          default:
                            # code...
                            break;
                        }

                        ?></dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_view">Enable View:</label></dt>
                      <dd>
                        <?php if($row_rsEditAds['ads_enable_view'] == 0){ ?>
                        <input name="ads_view" type="radio" value="1" /> 
                        <label class="check_label">Yes</label>
                        <input name="ads_view" type="radio" value="0" />
                        <label class="check_label">No</label>
                        <?php } else { ?>
                        Live
                        <?php } ?>
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="ads_fet">Featured:</label></dt>
                        <dd>
                          <?php
                            if ($row_rsEditAds['ads_featured'] == 0) { ?>
                            <input type="radio" name="ads_fet" id="" value="1" /><label class="check_label">Yes</label>
                              <input type="radio" name="ads_fet" id="" value="0" checked="checked"/><label class="check_label">No</label>
                          <?php  }
                          elseif ($row_rsEditAds['ads_featured'] == 1) { ?>
                            <input type="radio" name="ads_fet" id="" value="1" checked="checked"/><label class="check_label">Yes</label>
                            <input type="radio" name="ads_fet" id="" value="0"/><label class="check_label">No</label>
                         <?php } ?>
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
mysql_free_result($rsEditAds);

?>
