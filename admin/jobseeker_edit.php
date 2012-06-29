<?php require_once('../Connections/conJobsPerak.php'); 

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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEditJobseeker = "SELECT jp_users.users_id, jp_users.users_email, jp_users.users_fname, jp_users.users_lname, jp_users.user_active, jp_jobseeker.jobseeker_tel, jp_jobseeker.jobseeker_mobile, jp_jobseeker.jobseeker_address, jp_jobseeker.jobseeker_dob_y, jp_jobseeker.jobseeker_dob_m, jp_jobseeker.jobseeker_dob_d, jp_jobseeker.jobseeker_gender, jp_jobseeker.jobseeker_nationality, jp_jobseeker.jobseeker_moreinfo, jp_jobseeker.jobseeker_pic, jp_nationality.national_name, jp_gender.gender_desc FROM jp_users Inner Join jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join jp_nationality On jp_jobseeker.jobseeker_nationality = national_id Inner Join jp_gender on jp_jobseeker.jobseeker_gender = jp_gender.gender_id WHERE jp_users.users_id = '$get_user_id'";
$rsEditJobseeker = mysql_query($query_rsEditJobseeker, $conJobsPerak) or die(mysql_error());
$row_rsEditJobseeker = mysql_fetch_assoc($rsEditJobseeker);
$totalRows_rsEditJobseeker = mysql_num_rows($rsEditJobseeker);

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
                    <li><a class="current" href="manageJobseeker.php">Manage Jobseekers<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a href="manageEmployer.php">Manage Employers<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a href="manageUser.php">Manage Users<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    <li><a href="manageAds.php">Manage Ads<!--[if IE 7]><!--></a><!--<![endif]-->
                    </li>
                    
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content"> 

    <?php include 'sidemenu.php'; ?>
    
    <div class="right_content">            
        
     <h2>Edit User - <?php echo $row_rsEditJobseeker['users_fname']; ?> <?php echo $row_rsEditJobseeker['users_lname']; ?></h2>
     
      <div class="form">
  <form name="form" action="" method="POST" class="niceform">
         
                <fieldset>
                	<input name="id" type="hidden" value="<?php echo $row_rsEditJobseeker['users_id']; ?>">
                    <dl>
                        <dt><label for="js_pic">Picture:</label></dt>
                        <dd><img src="<?php echo $row_rsEditJobseeker['jobseeker_pic']; ?>" name="js_pic"></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_fname">First Name:</label></dt>
                        <dd><input name="js_fname" type="text" id="" value="<?php echo $row_rsEditJobseeker['users_fname']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_lname">Last Name:</label></dt>
                        <dd><input name="js_lname" type="text" id="" value="<?php echo $row_rsEditJobseeker['users_lname']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_gender">Gender:</label></dt>
                        <dd><input name="js_gender" type="text" id="" value="<?php echo $row_rsEditJobseeker['gender_desc']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_dob">DOB:</label></dt>
                        <dd><input name="js_dob" type="text" id="" value="<?php echo $row_rsEditJobseeker['jobseeker_dob_d']; ?>/<?php echo $row_rsEditJobseeker['jobseeker_dob_m']; ?>/<?php echo $row_rsEditJobseeker['jobseeker_dob_y']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_nat">Nationality:</label></dt>
                        <dd><input name="js_nat" type="text" id="" value="<?php echo $row_rsEditJobseeker['national_name']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_email">Email:</label></dt>
                        <dd><input name="js_email" type="text" id="" value="<?php echo $row_rsEditJobseeker['users_email']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_add">Address:</label></dt>
                        <dd><textarea name="js_add" cols="43" rows="5" readonly="readonly" id="js_add"><?php echo $row_rsEditJobseeker['jobseeker_address']; ?></textarea>
                        </dd>
                    </dl>
                    <dl>
                    <dt><label for="js_tel">Telephone:</label></dt>
                        <dd><input name="js_tel" type="text" id="" value="<?php echo $row_rsEditJobseeker['jobseeker_tel']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_mobile">Mobile:</label></dt>
                        <dd><input name="js_mobile" type="text" id="" value="<?php echo $row_rsEditJobseeker['jobseeker_mobile']; ?>" size="54" readonly="readonly" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="js_more">More Info:</label></dt>
                        <dd><textarea name="js_more" cols="43" rows="5" readonly="readonly" id="js_more"><?php echo $row_rsEditJobseeker['jobseeker_moreinfo']; ?></textarea>
                        </dd>
                    </dl>
                    <!--
                     <dl class="submit">
                        <input type="submit" name="submit" id="submit" value="Update" />

                     </dl>-->

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
mysql_free_result($rsEditJobseeker);
?>
