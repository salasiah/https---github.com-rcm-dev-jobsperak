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

		<div id="container" class="full">
		  <div id="content_full">
<h2>Privacy Policy</h2><br/>
<div class="master_details_full">
  <!-- START PRIVACY POLICY CODE --><div style="font-family:arial"><strong>What information do we collect?</strong> <br /><br />We collect information from you when you register on our site, subscribe to our newsletter, respond to a survey or fill out a form.  <br /><br />When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address, mailing address or phone number. You may, however, visit our site anonymously.<br /><br /><strong>What do we use your information for?</strong> <br /><br />Any of the information we collect from you may be used in one of the following ways: <br /><br />; To personalize your experience<br />(your information helps us to better respond to your individual needs)<br /><br />; To improve our website<br />(we continually strive to improve our website offerings based on the information and feedback we receive from you)<br /><br />; To improve customer service<br />(your information helps us to more effectively respond to your customer service requests and support needs)<br /><br />; To process transactions<br /><blockquote>Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</blockquote><br />; To administer a contest, promotion, survey or other site feature<br /><br /><br />; To send periodic emails<br /><br />The email address you provide may be used to send you information, respond to inquiries, and/or other requests or questions.<br /><br /><strong>How do we protect your information?</strong> <br /><br />We implement a variety of security measures to maintain the safety of your personal information when you enter, submit, or access your personal information. <br /> <br />We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to?keep the information confidential.<br /><br />After a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be kept on file for more than 60 days.<br /><br /><strong>Do we use cookies?</strong> <br /><br />We do not use cookies.<br /><br /><strong>Do we disclose any information to outside parties?</strong> <br /><br />We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.<br /><br /><strong>Third party links</strong> <br /><br /> Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.<br /><br /><strong>Childrens Online Privacy Protection Act Compliance</strong> <br /><br />We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.<br /><br /><strong>Online Privacy Policy Only</strong> <br /><br />This online privacy policy applies only to information collected through our website and not to information collected offline.<br /><br /><strong>Terms and Conditions</strong> <br /><br />Please also visit our Terms and Conditions section establishing the use, disclaimers, and limitations of liability governing the use of our website at <a href="terms-and-conditions.php">http://www.jobsperak.com/terms-and-conditions.php</a><br /><br /><strong>Your Consent</strong> <br /><br />By using our site, you consent to our websites privacy policy.<br /><br /><strong>Contacting Us</strong> <br /><br />If there are any questions regarding this privacy policy you may contact us using the information below. <br /><br />http://www.jobsperak.com<br />Jalan Dato' Seri Ahmad Said<br />Ipoh, B-G-9, Greentown Suria 30450<br />Malaysia<br />webmaster@jobsperak.com<br />Tel:+60-5241 1770 Fax:+605-241 1771<!-- END PRIVACY POLICY CODE -->
</div>

          </div><!-- #content-->
	
		  <aside id="sideRight" class="hide">
          	  <div class="sidebarBox">
              	<strong>How-to</strong>
            	<div class="sidebar_howto">
                	<ul>
                    	<li><a href="#">Register</a></li>
                        <li><a href="#">Post a Job</a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
			  <div class="sidebarBox hide">
              	<strong>Recent Jobs</strong>
            	<div class="sidebar_recentjob">
                	<ul>
                      <li><a></a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
           	  <strong>Jobs Posted under </strong>
              	<ul>
                  <li><a></a></li>
                </ul>
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
           	  <strong>Get Connected</strong><br />
              	Facebook | Twitter | RSS
              </div><!-- .sidebarBox -->
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
</html>