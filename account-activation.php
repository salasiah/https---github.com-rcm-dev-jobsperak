<?php require_once('Connections/conJobsPerak.php'); ?>
<?php

$onScreenEmailID      = $_GET['mail'];
if ($onScreenEmailID == NULL) {
	header("location: index.php");
} else{


	$check_email = "SELECT * FROM jp_users WHERE users_email = '".$onScreenEmailID."'";
	$check_email_result = mysql_query($check_email);
	$check_email_result_rows = mysql_num_rows($check_email_result);
	
	if($check_email_result_rows > 0){
		
		$query = "UPDATE jp_users SET user_active =  '1' WHERE users_email = '".$onScreenEmailID."'";
		$result = mysql_query($query);
	
		if ($result){
			
			$message = 'ok';
			//echo $onScreenEmailID;
			
			
			//initialize the session
			if (!isset($_SESSION)) {
			  session_start();
			}
			
			//to fully log out a visitor we need to clear the session varialbles
			$_SESSION['MM_Username'] = NULL;
			$_SESSION['MM_UserGroup'] = NULL;
			$_SESSION['PrevUrl'] = NULL;
			$_SESSION['MM_UserID'] = NULL;
			unset($_SESSION['MM_Username']);
			unset($_SESSION['MM_UserGroup']);
			unset($_SESSION['PrevUrl']);
			unset($_SESSION['MM_UserID']);
  
			
		} else {
			
			$message = 'error';
			//echo $onScreenEmailID;
		}
		
	} else {
		
		$message = 'error';
		
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
<?php if ($message == "error") { ?>
<h2 style="color:#F00">Error!</h2>
<?php } else { ?>
<h2>Congratulation!</h2>
<?php } ?>
<div class="master_details">

	<?php if ($message == "error") { ?>
    <br/>
    <p style="color:#F00">There have an error to activate your account.</p>
    <?php } else { ?>
    <br/>
  <p class="success"><strong>Your account has been activated! You can use our portal now. <a href="login.php">Login Now</a></strong></p>
  <?php } ?>
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