<?php
	include_once '../app/global.php';

	//	Header
	$page_title = "Dashboard";
	include_once '../header.php';
	include_once '../app/dashboard-util.php'; 

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//////////////////////
		// Auto sign out - for users who forgot to sign out
		// - Currently set to 2 hours
		//////////////////////

		// Do the query (from logic above)
		$hours_to_add = 4;
		$error_occurred = false;
		$error_string = "";

		// Get those still logged in
		$logged_in_query = "SELECT vp.id AS id"
							." FROM Volunteer_Period vp"
							." WHERE vp.check_in_time = vp.check_out_time";
		$logged_in_results = $db->executeStatement($logged_in_query, [])->fetchAll();	
		
		// For each of those, update with 4+ hours
		foreach ($logged_in_results as $result) {
			$vp_id = $result['id'];
			// Calculate time
			$vp_update = "UPDATE Volunteer_Period"
						." SET check_out_time = DATEADD(hh, ".$hours_to_add.", check_in_time), hours = ".$hours_to_add
						." WHERE id = ".$vp_id;
			if($db->executeStatement($vp_update, [])) {
				// Good to go, don't need to handle success :)
			} else {
				// Error occurred
				$error_occurred = true;
				if ($error_string !== "") {
					$error_string = $error_string."<br/>";	
				}
				$error_string = $error_string." There was an issue updating id ".$vp_id.". Error was: ".$db->errorInfo().".";
			}
		}
?>
	<div class="container">
<?php if($error_occurred) { ?>
		<h1>Error Occurred</h1>
		<p><?=$error_string?></p>
<?php } else { ?>
		<h1>Success!</h1>
<?php } ?>
		<button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Back to previous page</a>	
	</div>
<?php
	}
	include_once '../footer.php';
?>