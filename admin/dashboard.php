<?php require_once('../Connections/conJobsPerak.php'); ?>
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

<script src="amcharts/amcharts.js" type="text/javascript"></script>        
        <script type="text/javascript">
        
            var chart;
            var legend;
            var cha_ind_name = new Array();
            var cha_ind_val = new Array();
            var chartData = new Array();
            var chartInData = new Array();
            var cha_ind_val = new Array();
            var id_num_ind;
            var i = 0;
			      <?php 
            do { ?>
                cha_ind_name[i] = "<?= $row_rsAdsInd['ind_name']; ?>";

                cha_ind_val[i] = "<?= $row_rsAdsInd['ind_count']; ?>";
                id_num_ind = "<?= $row_rsAdsInd['ind_id']; ?>";
                chartInData[id_num_ind] = cha_ind_val[i];

                chartData.push({country: cha_ind_name[i],value: chartInData[id_num_ind]});
			
                i++;
            
            <?php } while ($row_rsAdsInd = mysql_fetch_assoc($rsAdsInd));
            ?>

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "value";
                chart.labelRadius = -10;
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;
                
                // this makes the chart 3D
                chart.depth3D = 15;
                chart.angle = 30;

                // WRITE
                chart.write("chartdiv");
            });
        </script>

        <script type="text/javascript">
            var chart2;
            var cha_ads_loc = new Array();
            var chartInData = new Array();
            var chartInData2 = new Array();
            var cha_ads_loc_val = new Array();
            var id_num;
            var i=1;

            <?php 
            do { ?>
                cha_ads_loc[i] = "<?= $row_rsAdsLoc['loc_name']; ?>";
                
                chartInData.push(cha_ads_loc[i]);
      
                i++;
            
            <?php } while ($row_rsAdsLoc = mysql_fetch_assoc($rsAdsLoc));
            ?>

            <?php 
            do { ?>
                cha_ads_loc_val[i] = "<?= $row_rsAdsLocVal['location']; ?>";
                id_num = "<?= $row_rsAdsLocVal['id']; ?>";
                chartInData2[id_num] = cha_ads_loc_val[i];
      
                i++;
            
            <?php } while ($row_rsAdsLocVal = mysql_fetch_assoc($rsAdsLocVal));
            ?>

            var chartData2 = [{
                country: chartInData[1],
                visits: chartInData2[1],
                color: "#FF0F00"
            }, {
                country: chartInData[2],
                visits: chartInData2[2],
                color: "#FF6600"
            }, {
                country: chartInData[3],
                visits: chartInData2[3],
                color: "#FF9E01"
            }, {
                country: chartInData[4],
                visits: chartInData2[4],
                color: "#FCD202"
            }, {
                country: chartInData[5],
                visits: chartInData2[5],
                color: "#F8FF01"
            }, {
                country: chartInData[6],
                visits: chartInData2[6],
                color: "#B0DE09"
            }, {
                country: chartInData[7],
                visits: chartInData2[7],
                color: "#04D215"
            }, {
                country: chartInData[8],
                visits: chartInData2[8],
                color: "#0D8ECF"
            }, {
                country: chartInData[9],
                visits: chartInData2[9],
                color: "#0D52D1"
            }, {
                country: chartInData[10],
                visits: chartInData2[10],
                color: "#2A0CD0"
            }, {
                country: chartInData[11],
                visits: chartInData2[11],
                color: "#8A0CCF"
            }, {
                country: chartInData[12],
                visits: chartInData2[12],
                color: "#CD0D74"
            }, {
                country: chartInData[13],
                visits: chartInData2[13],
                color: "#754DEB"
            }, {
                country: chartInData[14],
                visits: chartInData2[14],
                color: "#DDDDDD"
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart2 = new AmCharts.AmSerialChart();
                chart2.dataProvider = chartData2;
                chart2.categoryField = "country";
                // the following two lines makes chart 3D
                chart2.depth3D = 20;
                chart2.angle = 30;

                // AXES
                // category
                var categoryAxis = chart2.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                

                // GRAPH            
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.colorField = "color";
                graph.balloonText = "[[category]]: [[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart2.addGraph(graph);

                // WRITE
                chart2.write("chartdiv2");
            });
        </script>

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
                    <li><a class="current"href="dashboard.php">Admin Home</a></li>
                    <li><a href="manageJobseeker.php">Manage Jobseekers<!--[if IE 7]><!--></a><!--<![endif]-->
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

		<h2>JobsPerak Recruitment Portal Summary</h2>
        <div>
        <table width="440" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlUser['totalUser']; ?></td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><span class="numb"><?php echo $row_ttlUserActive['totalUser']; ?></span></td>
  </tr>
  <tr>
    <td width="200" align="center" valign="middle" class="desc">Users Registered</td>
    <td width="300" class="numb">&nbsp;</td>
    <td width="200" align="center" valign="middle" class="desc">Active Users</td>
    </tr>
  <tr>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlJs['ttlJs']; ?></td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlEmp['ttlEmp']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="desc">Applicants</td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="desc">Employers</td>
    </tr>
  <tr>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlAds['ttlAds']; ?></td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlJbApp['ttljsapp']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="desc">Jobs Online</td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="desc">Job Applied</td>
    </tr>
  <tr>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlShortlisted['ttlShortlisted']; ?></td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlReject['ttlRejected']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="desc">Shortlisted</td>
    <td class="numb">&nbsp;</td>
    <td align="center" valign="middle" class="desc">Rejected</td>
    </tr>
     
  <tr>
    <td align="center" valign="middle" class="desc">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><?php echo $row_ttlApproved['ttlApproved']; ?></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center" valign="middle" class="desc">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><span class="desc">Succesful Placed</span></td>
    <td align="center" valign="middle">&nbsp;</td>
    </tr>
    
    <tr>
    <td align="center" valign="middle" class="desc">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><?php echo $row_outData['outData']; ?></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center" valign="middle" class="desc">&nbsp;</td>
    <td align="center" valign="middle" class="numb"><span class="desc">Succesful Placed</br>(Outside Data)</span></td>
    <td align="center" valign="middle">&nbsp;</td>
    </tr>
</table>

        </div>
        <br/><br/><br/><br/>
        <h2>Job Ads Action</h2>
        <table width="300px" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><?php echo $row_ttlPending['ttlPending']; ?></td>
    <td>Waiting for approve</td>
    <td><a href="manageAds.php">View Job Ad</a></td>
  </tr>
</table>

        <br/><br/><br/><br/>
       <h2>Jobs Ads By Industry</h2>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
        <h2>Jobs Ads By Location</h2>
        <div id="chartdiv2" style="width: 100%; height: 400px;"></div>
      
     
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

?>