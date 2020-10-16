<?php
	include_once '../app/global.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//	Header
		$page_title = "Dashboard";
		include_once '../header.php';
		include_once '../app/dashboard-util.php'; 
?>
<div id="npcb-report" class="container">
	
	
</div>

<div class="container">

	<h2>LOAD CONTENT and DATA BASED ON USER PERMISSIONS - intern/volunteer vs admin/staff</h2>	
	<?php
		$admin_staff = false;
		// USER TYPE CHECK HERE
		if(true) {
			$admin_staff = true;
		}

		if($admin_staff) {
			include_once 'staff-dashboard.php';
		} else {
			include_once 'vol-dashboard.php';
		}
	?>

</div>
<?php
	}
	include_once '../footer.php';
?>