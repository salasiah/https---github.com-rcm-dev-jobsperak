<div class="menu_container">
    <ul id="default_inline_menu_2">
        <li>
        	<img src="img/Monitor-icon.png" alt="dashboard" />
        	<a href="jobSeekerDashboard.php">My Dashboard</a></li>
        <li>
        	<img src="img/Contract-icon.png" alt="My Resume" />
        	<a href="jobSeekerMyResume.php?email=<?php echo $_SESSION['MM_Username']; ?>">My Resume</a></li>
        <li>
        	<img src="img/Files-icon.png" alt="My Application" />
        	<a href="jobSeekerMyApplication.php">My Job Application(s)</a></li>
        <li>
        	<img src="img/Preppy-icon.png" alt="profile" />
        	<a href="jobSeekerEditProfile.php?email=<?php echo $_SESSION['MM_Username']; ?>">Edit Profile</a></li>
        <li>
        	<img src="img/App-password-icon.png" alt="password" />
        	<a href="jobSeekerChangePassword.php?email=<?php echo $_SESSION['MM_Username']; ?>">Change Password</a></li>
    </ul>
</div>


<div id="infomation">
	<img src="img/Info-icon.png" alt="info" />
	<span style="margin-left:30px">Please fill up your <a href="jobSeekerMyResume.php" title="details">details</a> of each section to make your resume reachable by employer.</span>
</div>