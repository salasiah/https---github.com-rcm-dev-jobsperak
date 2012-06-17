<?php require_once('Connections/conJobsPerak.php'); ?>
<?php 

$email = $_POST['forgotemail'];

if($email == NULL) {
	header('location:index.php');
} else {


	// Check if exist or not
	$sql_check_exist = "SELECT * FROM jp_users WHERE users_email = '$email'";
	$sql_check_result = mysql_query($sql_check_exist);
	$sql_check_result_rows = mysql_num_rows($sql_check_result);
	
	if($sql_check_result_rows > 0) {
		
		// if ada, generate random password
		$randomNumberPassword = rand(1, 999999);
		
		// md5 password
		$newEncryptedPassword = md5($randomNumberPassword);
		
		// update table user based on email 
		// and email to user
		$sql_update = "UPDATE jp_users SET users_pass = '$newEncryptedPassword' WHERE users_email = '$email'";
		$sql_update_result = mysql_query($sql_update);

		if($sql_update_result) {
			
			// email password to user
			$to      = $email;
			$subject = 'JobsPerak Recruitment Portal - Your new password';
			$message = 'Hi, '.$to;
			$message .= ' Your new password for your email '.$to;
			$message .= ' is '.$randomNumberPassword.'';
			$message .= ' Please change your password immediately';
			
			$headers = 'From: no-reply@jobsperak.com' . "\r\n" .
				'Reply-To: webmaster@jobsperak.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			
			mail($to, $subject, $message, $headers);
			$message = '<strong class="success">Check your email for new password.</strong>';
			
		} else {
			
			$message = 'Ops! there have an error to reset your password';
			
		}

		
	} else {

		$message = 'Email does not have in our database.';
		
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "users_type";
  $MM_redirectLoginSuccess = "sessionGateway.php";
  $MM_redirectLoginFailed = "loginFailed.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  	
  $LoginRS__query=sprintf("SELECT users_id, users_email, users_pass, users_type FROM jp_users WHERE users_email=%s AND users_pass=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conJobsPerak) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'users_type');
    // get userID
	$query_user_id 			= "SELECT * FROM jp_users WHERE users_email = '$loginUsername'";
	$query_user_id_result 	= mysql_query($query_user_id);
	$c_users 				= mysql_fetch_object($query_user_id_result);
	$cuid    				= $c_users->users_id;
	
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['MM_UserID'] = $cuid;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
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
                    Register JobSeeker</a>
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
<h2>Forgot Password</h2>
<div class="master_details">
	<p>Enter your email address</p>
    <?php echo $message; ?>
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