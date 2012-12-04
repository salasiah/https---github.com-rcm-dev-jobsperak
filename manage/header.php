<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">JobsPerak Management</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="dashboard.php">Home</a></li>
              <li class="dropdown">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Modules
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                   <li class="nav-header">Manage</li>
	               <li><a href="users.php">Users</a></li>
                   <li><a href="jobads.php">Job Ads</a></li>
                   <li class="nav-header">Jobseeker</li>
                   <li><a href="resumes.php">Resumes</a></li>
                   <li class="nav-header">Marketing</li>
                   <li><a href="#">Newsletter</a></li>
                   <li><a href="newsfeed.php">News Feed</a></li>
                </ul>
    			</li>
              <li><a href="#contact">Contact Us</a></li>
              <li><a href="<?php echo $logoutAction ?>">Log Out</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>