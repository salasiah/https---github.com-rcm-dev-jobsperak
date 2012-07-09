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

  $current_email = mysql_real_escape_string($_POST['users_email']);
  // check existing email
  $sqlExistingEmail = "SELECT * FROM jp_users WHERE users_email LIKE '$current_email'";
  $sqlExistingEmailResult = mysql_query($sqlExistingEmail);
  $sqlExistingEmailResultRow = mysql_num_rows($sqlExistingEmailResult);

  if ($sqlExistingEmailResultRow == 1) {
    $error = '<p style="color:red; padding:4px; border:1px solid red; background:#FDC8CC; font-weight:bold; text-align:center">Already Registered</p>';
  } else {
  /*-----------*/

  $insertSQL = sprintf("INSERT INTO jp_users (users_email, users_pass, users_register, users_fname, users_lname, users_type) VALUES (%s, md5(%s), NOW(), %s, %s, %s)",
                       GetSQLValueString($_POST['users_email'], "text"),
                       GetSQLValueString($_POST['users_pass'], "text"),
                       GetSQLValueString($_POST['users_fname'], "text"),
                       GetSQLValueString($_POST['users_lname'], "text"),
                       GetSQLValueString($_POST['users_type'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());

  $insertGoTo = "registerJobSeekerSuccess.php?mail=" . $_POST['users_email'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

  } // run registered
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
</head>

<body>



	<header id="header">

		<div class="center">
			<div class="left"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
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
		  <div id="content">
<h2>Register as a JobSeeker / Employer</h2>
<div class="master_details">
<p>Please fill up the form in order to use this portal.</p>

  <?php echo @$error; ?>

  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table width="500" align="center">
      <tr valign="baseline">
        <td nowrap align="right">Email: <span class="req">*</span></td>
        <td><input type="text" placeholder="Your Valid Email" name="users_email" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Password <span class="req">*</span></td>
        <td><input type="password" placeholder="Create Your Password" name="users_pass" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">First Name <span class="req">*</span></td>
        <td><input type="text" placeholder="First Name" name="users_fname" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Last Name <span class="req">*</span></td>
        <td><input type="text" placeholder="Last Name" name="users_lname" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">Register as: <span class="req">*</span></td>
        <td valign="baseline"><table width="400">
          <tr>
            <td><input type="radio" name="users_type" value="1" >
              JobSeeker</td>
              <td><input type="radio" name="users_type" value="2" >
              Employer</td>
          </tr>
          <tr>
            <td class="note">* Apply jobs from this portal</td>
            <td class="note">* You can post up to 5 job ads</td>
          </tr>
        </table></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Register"> <input name="" type="reset"></td>
      </tr>
    </table>
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