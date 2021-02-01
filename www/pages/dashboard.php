<?php
	include_once '../app/global.php';

	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//	Header
		$page_title = "Dashboard";
		include_once '../header.php';
		// Logic
		include_once '../app/dashboard-util.php';
?>
<div class="container">
	<?php
		$admin_staff = false;

		$user_type_id = getLoggedInUserTypeId();

		if($user_type_id == 1 || $user_type_id == 2) {
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