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
$query_rsEduLists = "SELECT * FROM jp_edu_lists";
$rsEduLists = mysql_query($query_rsEduLists, $conPerak) or die(mysql_error());
$row_rsEduLists = mysql_fetch_assoc($rsEduLists);
$totalRows_rsEduLists = mysql_num_rows($rsEduLists);

mysql_select_db($database_conPerak, $conPerak);
$query_rsState = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsState = mysql_query($query_rsState, $conPerak) or die(mysql_error());
$row_rsState = mysql_fetch_assoc($rsState);
$totalRows_rsState = mysql_num_rows($rsState);

mysql_select_db($database_conPerak, $conPerak);
$query_rsLocation = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsLocation = mysql_query($query_rsLocation, $conPerak) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_conPerak, $conPerak);
$query_rsIndustry = "SELECT * FROM jp_industry";
$rsIndustry = mysql_query($query_rsIndustry, $conPerak) or die(mysql_error());
$row_rsIndustry = mysql_fetch_assoc($rsIndustry);
$totalRows_rsIndustry = mysql_num_rows($rsIndustry);

mysql_select_db($database_conPerak, $conPerak);
$query_rsFieldStudy = "SELECT * FROM jp_field_list";
$rsFieldStudy = mysql_query($query_rsFieldStudy, $conPerak) or die(mysql_error());
$row_rsFieldStudy = mysql_fetch_assoc($rsFieldStudy);
$totalRows_rsFieldStudy = mysql_num_rows($rsFieldStudy);
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
      
      <h1>Hello, <?php echo $row_rsAdminName['admin_name']; ?>! What are you looking for?</h1>
      <p>Our system will try the best for you to find out what exactly do you want.</p><br/><br/>
      <form action="result-filter.php" method="get" name="advancefiltering" target="_blank">
        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="table-striped">
          <tr>
            <th colspan="3" align="left" valign="middle" scope="col"><h4>Basic</h4></th>
          </tr>
          <tr>
            <td width="20%" align="left" valign="middle" scope="col">Name</td>
            <td width="2%" align="center" valign="middle" scope="col">:</td>
            <td width="70%" align="left" valign="bottom" scope="col"><input name="name" type="text" class="input-xxlarge" id="name"></td>
          </tr>
          <tr>
            <td width="20%" align="left" valign="middle" scope="col">Email</td>
            <td width="2%" align="center" valign="middle" scope="col">:</td>
            <td width="70%" align="left" valign="bottom" scope="col"><input name="email" type="text" class="input-xxlarge" id="email"></td>
          </tr>
          <tr>
            <td align="left" valign="middle" scope="col">IC</td>
            <td align="center" valign="middle" scope="col">:</td>
            <td align="left" valign="bottom" scope="col"><input name="ic" type="text" class="input-xxlarge" id="ic"></td>
          </tr>
          <tr>
            <td align="left" valign="middle" scope="col">Employment Status</td>
            <td align="center" valign="middle" scope="col">:</td>
            <td align="left" valign="bottom" scope="col"><select name="employ_status" id="employ_status">
              <option>All</option>
              <option value="unemployed">Unemployed</option>
              <option value="employed">Employed</option>
              <option value="study">Study</option>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle" scope="col">Gender</td>
            <td align="center" valign="middle" scope="col">:</td>
            <td align="left" valign="bottom" scope="col"><select name="gender" id="gender">
              <option value="0">All</option>
              <option value="2">Male</option>
              <option value="1">Female</option>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Age</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="bottom"><select name="age" id="age">
              <option value="0">All</option>
              <option value="b20">18 - 20</option>
              <option value="b25">20 - 25</option>
              <option value="b29">25 - 29</option>
              <option value="a30">30 and above</option>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Marital Status</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="bottom"><select name="marital_status" id="marital_status">
              <option value="0">All</option>
              <option value="1">Single</option>
              <option value="2">Married</option>
            </select></td>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle">&nbsp;</th>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle"><h4>Experience</h4></th>
          </tr>
          <tr>
            <td align="left" valign="middle">Total Year</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="year_experience" id="year_experience">
              <option value="0">All</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="a3">3 and above</option>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Position</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><input type="text" name="position" id="position" class="input-xxlarge"></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle"><h4>Education</h4></th>
          </tr>
          <tr>
            <td align="left" valign="middle">Qualification</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="bottom"><select name="qualification" id="qualification">
              <option value="All">All</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsEduLists['edu_id']?>"><?php echo $row_rsEduLists['edu_name']?></option>
              <?php
} while ($row_rsEduLists = mysql_fetch_assoc($rsEduLists));
  $rows = mysql_num_rows($rsEduLists);
  if($rows > 0) {
      mysql_data_seek($rsEduLists, 0);
    $row_rsEduLists = mysql_fetch_assoc($rsEduLists);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Institution</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><input type="text" name="institution" id="institution" class="input-xxlarge"></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Field of Study</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">
              <select name="fieldStudy" id="fieldStudy">
                <option value="">All</option>
                <?php
do {  
?>
                <option value="<?php echo $row_rsFieldStudy['field_id']?>"><?php echo $row_rsFieldStudy['field_name']?></option>
                <?php
} while ($row_rsFieldStudy = mysql_fetch_assoc($rsFieldStudy));
  $rows = mysql_num_rows($rsFieldStudy);
  if($rows > 0) {
      mysql_data_seek($rsFieldStudy, 0);
	  $row_rsFieldStudy = mysql_fetch_assoc($rsFieldStudy);
  }
?>
              </select>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle">CGPA</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="cgpa" id="cgpa">
              <option value="0">All</option>
              <option value="b25">2 to 2.49</option>
              <option value="b299">2.5 to 2.99</option>
              <option value="b349">3 to 3.49</option>
              <option value="35">3.5 and above</option>
            </select></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle"><h4>Skills</h4></th>
          </tr>
          <tr>
            <td align="left" valign="middle">Language</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="language" id="language">
              <option value="0">All</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsLanguageList['languList_id']?>"><?php echo $row_rsLanguageList['languList_name']?></option>
              <?php
} while ($row_rsLanguageList = mysql_fetch_assoc($rsLanguageList));
  $rows = mysql_num_rows($rsLanguageList);
  if($rows > 0) {
      mysql_data_seek($rsLanguageList, 0);
	  $row_rsLanguageList = mysql_fetch_assoc($rsLanguageList);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Skill type</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><input type="text" name="skills" id="skills" class="input-xxlarge"></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Licences</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle">
              <select name="licences">
                <option value="">All</option>
                <option value="LDL">LDL</option>
                <option value="PDL">PDL</option>
                <option value="CDL">CDL</option>
                <option value="VDL">VDL</option>
                <option value="IDP">IDP</option>
                <optgroup label="Kelas">
                  <option value="A">Kelas A</option>
                  <option value="B">Kelas B</option>
                  <option value="B1">Kelas B1</option>
                  <option value="B2">Kelas B2</option>
                  <option value="C">Kelas C</option>
                  <option value="D">Kelas D</option>
                  <option value="E">Kelas E</option>
                  <option value="E1">Kelas E1</option>
                  <option value="E2">Kelas E2</option>
                  <option value="F">Kelas F</option>
                  <option value="G">Kelas G</option>
                  <option value="H">Kelas H</option>
                  <option value="I">Kelas I</option>
                </optgroup>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle"><h4>Location</h4></th>
          </tr>
          <tr>
            <td align="left" valign="middle">State</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="state" id="state">
              <option value="0">All</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsState['location_id']?>"><?php echo $row_rsState['location_name']?></option>
              <?php
} while ($row_rsState = mysql_fetch_assoc($rsState));
  $rows = mysql_num_rows($rsState);
  if($rows > 0) {
      mysql_data_seek($rsState, 0);
	  $row_rsState = mysql_fetch_assoc($rsState);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Distinct</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="distinct" id="distinct">
              <option value="0">All</option>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Sub-Distinct</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="subdistinct" id="subdistinct">
              <option value="0">All</option>
            </select></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="middle"><h4>Job Preference</h4></th>
          </tr>
          <tr>
            <td align="left" valign="middle">Work Location</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="job_prefer_location" id="job_prefer_location">
              <option value="0">All</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsLocation['location_id']?>"><?php echo $row_rsLocation['location_name']?></option>
              <?php
} while ($row_rsLocation = mysql_fetch_assoc($rsLocation));
  $rows = mysql_num_rows($rsLocation);
  if($rows > 0) {
      mysql_data_seek($rsLocation, 0);
	  $row_rsLocation = mysql_fetch_assoc($rsLocation);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Job Industry</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="job_prefer_industry" id="job_prefer_industry">
              <option value="0">All</option>
              <?php
do {  
?>
              <option value="<?php echo $row_rsIndustry['indus_id']?>"><?php echo $row_rsIndustry['indus_name']?></option>
              <?php
} while ($row_rsIndustry = mysql_fetch_assoc($rsIndustry));
  $rows = mysql_num_rows($rsIndustry);
  if($rows > 0) {
      mysql_data_seek($rsIndustry, 0);
	  $row_rsIndustry = mysql_fetch_assoc($rsIndustry);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="middle">Expected Salary</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><select name="job_prefer_salary" id="job_prefer_salary">
              <option value="0">All</option>
              <option value="1">Below 1K</option>
              <option value="2">Below 2K</option>
              <option value="3b">Below 3K</option>
              <option value="3a">3K and Above</option>
            </select></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle">DISC Test</td>
            <td align="center" valign="middle">:</td>
            <td align="left" valign="middle"><label class="checkbox"><input type="checkbox" name="disc_test" id="disc_test"> Yes</label></td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td align="left" valign="middle"><input name="Submit" type="submit" class="btn btn-primary" id="button" value="Filter Jobseeker"></td>
          </tr>
        </table>
      
      </form>
	  </div>

    </div> <!-- /container -->

	<?php include("footer.php"); ?>

  <script type="text/javascript">
    $('document').ready(function(){

      // get district
      $('select#state').live('change', function(){

        var dataState = $(this).val();
        console.log(dataState);

        $.ajax({
          data: dataState,
          url: "getDistrict.php?state_id="+dataState,
          type: "POST",

          success:function(html){

            var def = "<option value=0>All</option>";

            $('select#distinct').html(html);
            $('select#subdistinct').html(def);
            // console.log(html);
          }

        });

      });


      // get subdistrict
      $('select#distinct').live('change', function(){

        var datadistinct = $(this).val();
        console.log(distinct);

        $.ajax({
          data: datadistinct,
          url: "getSubDistrict.php?district_id="+datadistinct,
          type: "POST",

          success:function(html){
            $('select#subdistinct').html(html);
            // console.log(html);
          }

        });

      });



    });
  </script> 
    
  </body>
</html>
<?php
mysql_free_result($rsAdminName);

mysql_free_result($rsLanguageList);

mysql_free_result($rsEduLists);

mysql_free_result($rsState);

mysql_free_result($rsLocation);

mysql_free_result($rsIndustry);

mysql_free_result($rsFieldStudy);
?>
