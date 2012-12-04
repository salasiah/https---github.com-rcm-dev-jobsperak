<?php require_once('../Connections/conJobsPerak.php'); 
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

$colname_rsAtmDetails = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsAtmDetails = $_SESSION['MM_UserID'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsAtmDetails = sprintf("SELECT * FROM atm_field WHERE user_id_fk = %s", GetSQLValueString($colname_rsAtmDetails, "int"));
$rsAtmDetails = mysql_query($query_rsAtmDetails, $conJobsPerak) or die(mysql_error());
$row_rsAtmDetails = mysql_fetch_assoc($rsAtmDetails);
$totalRows_rsAtmDetails = mysql_num_rows($rsAtmDetails);
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
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php 
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<html>
<head>
	<title>Angkatan Tentera Malaysia</title>
	<?php include ('atm_meta.php'); ?>
</head>
<body>
	<?php include ('atm_header.php'); ?>

	<div class="content-basic">
	  <h2>Requirement Details</h2>
    <span>Fill up your detail to meet our requirement.</span><br/><br/>
	  <form action="" method="post">
      <div class="details1">
          <table width="300px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60">Sex</td>
        <td width="10">:</td>
        <td width="150">Male</td>
        </tr>
      <tr>
        <td>Age</td>
        <td>:</td>
        <td>22</td>
        </tr>
      <tr>
        <td>SPM</td>
        <td>:</td>
        <td>Already fill up via jobsperak.com</td>
        </tr>
      <tr>
        <td>CGPA (Degree Holder)</td>
        <td>:</td>
        <td>Not related</td>
        </tr>
      <tr>
        <td>Height</td>
        <td>:</td>
        <td><?php echo $row_rsAtmDetails['height']; ?>171cm</td>
        </tr>
      <tr>
        <td>Weight</td>
        <td>:</td>
        <td><?php echo $row_rsAtmDetails['weight']; ?>60cm</td>
        </tr>
      <tr>
        <td>Chest</td>
        <td>:</td>
        <td><?php echo $row_rsAtmDetails['body']; ?>50cm</td>
        </tr>
      <tr>
        <td>BMI</td>
        <td>:</td>
        <td><?php echo $row_rsAtmDetails['bmi']; ?>20</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3" align="center" valign="middle"><input type="submit" name="button" id="button" style="display:none" value="Update Details"></td>
        </tr>
      </table>
        </div>

        <div class="details2">
            <div class="figure">
                 <div class="male">
                   <div class="m_tf top">
                    <small>Height</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="m_tf chest">
                    <small>Chest</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="m_tf weight">
                    <small>Weight</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="m_tf bmi">
                    <small>BMI</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>
                 </div><!-- /male -->

                 <div class="female">
                   <div class="f_tf top">
                    <small>Height</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="f_tf chest">
                    <small>Chest</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="f_tf weight">
                    <small>Weight</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>

                   <div class="f_tf bmi">
                    <small>BMI</small>
                     <input type="text" name="" value="171" style="width:50px" placeholder="">
                   </div>
                 </div><!-- /female -->
                 <div style="clear:both"></div>
            </div>   
        </div>  

        <div class="clearboth"></div>
    </form>
	  <p>&nbsp;</p>
	</div>

	<?php include ('atm_footer.php'); ?>
  <script type="text/javascript"></script>
</body>
</html>
<?php
mysql_free_result($rsAtmDetails);
?>
