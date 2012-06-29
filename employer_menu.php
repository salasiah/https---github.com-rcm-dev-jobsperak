<div class="menu_container">
    <ul id="default_inline_menu">
    	<li>
    		<img src="img/Monitor-icon.png" alt="dashboard" />
    		<a href="employerDashboard.php">My Dashboard</a></li>
        <li>
        	<img src="img/Clients-icon.png" alt="Applicant" />
        	<a href="employerBrowseResume.php">Browse Resume(s)</a></li>
        <li>
        	<img src="img/Pen-icon.png" alt="shortlisted" />
        	<a href="employerApplicationShorlistedList.php">Shortlisted</a></li>
      <li>
      	<img src="img/Administrator-icon.png" alt="admin" />
      	<a href="employerProfileEdit.php?cuid=<?php echo $_SESSION['MM_UserID']; ?>">Edit Profile &amp; Company Profile</a></li>
    </ul>
</div>