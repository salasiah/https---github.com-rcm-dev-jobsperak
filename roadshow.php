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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsRoadshow = "SELECT * FROM jp_roadshow";
$rsRoadshow = mysql_query($query_rsRoadshow, $conJobsPerak) or die(mysql_error());
$row_rsRoadshow = mysql_fetch_assoc($rsRoadshow);
$totalRows_rsRoadshow = mysql_num_rows($rsRoadshow);
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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Welcome to Jobsperak Portal</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
    <script language="javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCbDZ2pWNTj635o2QZhqFA91gzARaN8hak&sensor=true">
    </script>
    <script language="javascript" src="js/roadshow_p.js"></script>
</head>

<body onload="load()">



	<header id="header">

		<div class="center">
			<div class="left logo"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
			</div>

			<div class="right">
            	<?php if (!isset($_SESSION['MM_Username'])) { ?>
					<a href="login.php" title="Login">Login</a> &nbsp;|&nbsp;
                	<a href="registerJobSeeker.php" title="Register JobSeeker">
                    JobSeeker / Employer Registration</a>
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

		  <div id="content" class="search_container" style="width:610px; padding-top:10px;margin-top:30px;">
<h2>Road Show</h2>
<br/>
<div class="master_details_full">
<div id="map" style="width: 610px; height: 400px">
</div><br/>
<p>
<strong>Road Show Campus</strong></p>
<table width="610" border="0" cellspacing="0" cellpadding="0" class="csstable2">
  <tr>
    <th scope="col">No</th>
    <th scope="col">Place</th>
    <th width="100" scope="col">Date</th>
    <th scope="col">Status</th>
  </tr>
  <?php $i = 1; ?>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle">
      <?php echo $i++; ?>
      </td>
      <td><strong><?php echo $row_rsRoadshow['rs_name']; ?></strong><br><?php echo $row_rsRoadshow['rs_address']; ?></td>
      <td align="center" valign="middle"><?php echo $row_rsRoadshow['rs_date']; ?></td>
      <td align="center" valign="middle">
	  <?php
	  
	  if($row_rsRoadshow['status'] == 0) {
		  echo "Pending";
	  } else {
		  echo "Confirm";
	  }
	  
	  ?>
      </td>
    </tr>
    <?php } while ($row_rsRoadshow = mysql_fetch_assoc($rsRoadshow)); ?>
</table>

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
<script>
$(document).ready(function(){
	$('#submitButton').live('click', function(){
		var email = $('#email').val();
		var emailMessage = $('#emailMessage').val();
		
		if(email == '' && emailMessage == ''){
			alert('Fill up the form to contact us');
			return false;
		}

	});
});
</script>
</html>
<?php
mysql_free_result($rsRoadshow);
?>
