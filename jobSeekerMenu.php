<div class="menu_container">
    <ul id="default_inline_menu">
        <li><a href="jobSeekerDashboard.php">My Dashboard</a></li>
        <li><a href="jobSeekerMyResume.php?email=<?php echo $_SESSION['MM_Username']; ?>">My Resume</a></li>
        <li><a href="jobSeekerMyApplication.php">My Job Application(s)</a></li>
        <li><a href="jobSeekerEditProfile.php?email=<?php echo $_SESSION['MM_Username']; ?>">Edit Profile</a></li>
        <li><a href="jobSeekerChangePassword.php?email=<?php echo $_SESSION['MM_Username']; ?>">Change Password</a></li>
    </ul>
</div>