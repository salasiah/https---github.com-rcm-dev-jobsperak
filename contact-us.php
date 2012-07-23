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
</head>

<body>



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

		<div id="container">
		  <div id="content" class="search_container" style="width:610px; padding-top:10px;margin-top:30px;">
<h2>Contact Us</h2><br/>
<div class="master_details_full">
<p>
<strong>Pusat Kerjaya Amanjaya</strong><br/>
B-G-9, Greentown Suria, Jalan Dato' Seri Ahmad Said, 30450 Ipoh, Malaysia<br/>
Tel: 605 - 241 1770 Fax: 605 - 241 1771 <br/>
Email: <a href="mailto:info@jobsperak.com">info@jobsperak.com</a> / <a href="mailto:webmaster@jobsperak.com">webmaster@jobsperak.com </a></p>
  <p>If you have any enquiries, do not hesitate to contact us by filling
up the form and we will reply<br/> your email as soon as possible.
  </p><br>
  <form action="email-sent.php" method="post" name="form1" style="width:600px; margin:0 auto;">
  	<table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="100" align="right" valign="middle">Your Email</td>
    <td width="10" align="center" valign="middle">:</td>
    <td valign="middle"><input name="email" id="email" type="text" placeholder="your_valid@email.com"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Type of Message</td>
    <td align="center" valign="middle">:</td>
    <td valign="middle"><label for="typeMessage"></label>
      <select name="typeMessage" class="date" id="typeMessage">
        <option value="General Inquiries">General Inquiries</option>
        <option value="Advertisement">Advertisement</option>
        <option value="Complaint">Complaint</option>
      </select></td>
  </tr>
  <tr>
    <td align="right" valign="top">Message</td>
    <td align="center" valign="middle">:</td>
    <td valign="middle"><label for="emailMessage"></label>
      <textarea name="emailMessage" id="emailMessage" cols="2" style="width:300px" rows="8" placeholder="Your Message"></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td valign="middle"><input type="submit" name="submitButton" id="submitButton" value="Submit"></td>
  </tr>
    </table>

  </form>
  <p>&nbsp;</p>
</div>

          </div><!-- #content-->
	
		  <aside id="sideRight">
          	  <?php include('full_content_sidebar.php'); ?>
          </aside>
			<!-- aside -->
			<!-- #sideRight -->

		</div><!-- #container-->
		

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