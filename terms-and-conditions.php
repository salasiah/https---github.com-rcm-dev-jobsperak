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

		<div id="container"  class="search_container full" style="margin-top:20px">
		  <div id="content_full">
<h2>Terms and Conditions</h2><br/>
<div class="master_details_full">
  <h3>Terms and Conditions of Use of Pusat Kerjaya Amanjaya</h3>
<p><b>1 &nbsp;Acceptance The Use Of Pusat Kerjaya Amanjaya Terms and Conditions</b></p>
<p>Your  access  to  and  use  of  Pusat Kerjaya Amanjaya is  subject exclusively to these Terms and Conditions. You will not use the Website for any purpose that is unlawful or prohibited by these Terms and Conditions. By using  the  Website  you  are  fully  accepting  the  terms,  conditions  and disclaimers contained in this notice. If you do not accept these Terms and Conditions you must immediately stop using the Website.</p>

<p><b>2 &nbsp;Credit card details</b></p>
<p>Pusat Kerjaya Amanjaya will never ask for Credit Card details and request that you do not enter it on any of the forms on Pusat Kerjaya Amanjaya.</p>

<p><b>3 &nbsp;Advice</b></p>
<p>The contents of Pusat Kerjaya Amanjaya website do not constitute advice and should not be relied upon in making or refraining from making, any decision.</p>

<p><b>4 &nbsp;Change of Use</b></p>
<p>Pusat Kerjaya Amanjaya reserves the right to:<br /> 4.1 &nbsp;change or remove (temporarily or permanently) the Website or any part of it without notice and you confirm that Pusat Kerjaya Amanjaya shall not be liable to you for any such change or removal and.<br /> 4.2 &nbsp;change these Terms and Conditions at any time, and your continued use of the Website following any changes shall be deemed to be your acceptance of such change.</p>

<p><b>5 &nbsp;Links to Third Party Websites</b></p>
<p>Pusat Kerjaya Amanjaya Website may include links to third party websites that are controlled and maintained by others. Any link to other websites is not an endorsement of such websites and you acknowledge and agree that we are not responsible for the content or availability of any such sites.</p>

<p><b>6 &nbsp;Copyright </b></p>
<p>6.1 &nbsp;All  copyright,  trade  marks  and  all  other  intellectual  property  rights  in  the Website and its content (including without limitation the Website design, text, graphics and all software and source codes connected with the Website) are owned by or   licensed to Pusat Kerjaya Amanjaya or otherwise used by Pusat Kerjaya Amanjaya as permitted by law.<br /> 6.2 &nbsp;In accessing the Website you agree that you will access the content solely for your personal, non-commercial use. None of the content may be downloaded, copied, reproduced, transmitted, stored, sold or distributed without the prior written consent of the copyright holder. This excludes the downloading, copying and/or printing of pages of the Website for personal, non-commercial home use only.</p>

<p><b>7 &nbsp;Disclaimers and Limitation of Liability </b></p>
<p>7.1 &nbsp;The Website is provided on an AS IS and AS AVAILABLE basis without any representation or endorsement made and without warranty of any kind whether express or implied, including but not limited to the implied warranties of satisfactory quality, fitness for a particular purpose, non-infringement, compatibility, security and accuracy.<br /> 7.2 &nbsp;To the extent permitted by law, Pusat Kerjaya Amanjaya will not be liable for any indirect or consequential loss or damage whatever (including without limitation loss of business, opportunity, data, profits) arising out of or in connection with the use of the Website.<br /> 7.3 &nbsp;Pusat Kerjaya Amanjaya makes no warranty that the functionality of the Website will be uninterrupted or error free, that defects will be corrected or that the Website or the server that makes it available are free of viruses or anything else which may be harmful or destructive.<br /> 7.4 &nbsp;Nothing in these Terms and Conditions shall be construed so as to exclude or limit the liability of Pusat Kerjaya Amanjaya for death or personal injury as a result of the negligence of Pusat Kerjaya Amanjaya or that of its employees or agents.</p>

<p><b>8 &nbsp;Indemnity</b></p>
<p>You agree to indemnify and hold Pusat Kerjaya Amanjaya and its employees and agents harmless from and against all liabilities, legal fees, damages, losses, costs and other expenses in relation to any claims or actions brought against Pusat Kerjaya Amanjaya arising out of any breach by you of these Terms and Conditions or other liabilities arising out of your use of this Website.</p>

<p><b>9 &nbsp;Severance</b></p>
<p>If any of these Terms and Conditions should be determined to be invalid, illegal or unenforceable for any reason by any court of competent jurisdiction then such Term or Condition shall be severed and the remaining Terms and Conditions shall survive and remain in full force and effect and continue to be binding and enforceable.</p>

<p><b>10 &nbsp;Governing Law</b></p>
<p>These Terms and Conditions shall be governed by and construed in accordance with the law of USA and you hereby submit to the exclusive jurisdiction of the USA courts.</p>

For any further information please email <a href='mailto:webmaster@jobsperak.com'>webmaster</a>
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