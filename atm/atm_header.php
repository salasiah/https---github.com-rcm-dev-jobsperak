<div class="header">
	<div class="container">
		<div class="logo"></div>
		<div class="menu">
			<span>Your logged as <?php if(!isset($_SESSION['MM_Username'])){echo "Guest";}else{echo $_SESSION['MM_Username'];} ?></span><br/>
			<a href="index.php" title="ATM">ATM</a> &middot; <a href="#" title="Vacancies">Vacancies</a> &middot; <a href="atm-details.php" title="Submit Your Details">Submit Your Details</a>
			
		</div>
	</div>	
</div>
<div class="main-body">
<div class="container">