<?php
	//////////////////////
	// Checkout Page for Volunteers
	// - Form POSTS to this page
	//////////////////////

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Setup Globals
	include_once 'global.php';

	$email = getLoggedInUserEmail();
	
	// if user is not logged in but has provided an email set the provided email
	if (empty($email) && isset($POST['email'])) {
		$email = $_POST['email'];
	}

	// Only process if email is set
	if (!empty($email)) {
		if(isset($_POST['signouttime'])) {
			$signout_time = $_POST['signouttime'];
		}
		$feedback = "";
		if(isset($_POST['feedback'])) {
			$feedback = filter_var ( $_POST['feedback'], FILTER_SANITIZE_STRING);
		}

		// Filter the email address
		$clean_email = filter_var ( $email, FILTER_SANITIZE_EMAIL);
		// parse the date
		if (isset($signout_time)) {
			// Use passed date time to sign out - date format is: 2016-10-12 (yyyy-mm-dd) and time 
			$clean_date = date_parse_from_format ( $ui_datetime_format , $signout_time );

		} else {
			// Use current date time to sign out - fixing issue because on west coa
			$clean_date = date( $date_format );
			$clean_date = date_parse_from_format ( $date_format , $clean_date );
		}

		// set signin time max and min for querying signins
		$lower_bound_date = $clean_date["year"] . "-" . $clean_date["month"] . "-" . $clean_date["day"] . " 00:00:00";
		$upper_bound_date = $clean_date["year"] . "-" . $clean_date["month"] . "-" . $clean_date["day"] . " 23:59:59";
	
	////////////////////////////////////////////
	// PULL SIGN IN TO SEE IF THEY ARE THERE
	////////////////////////////////////////////
		$db = new pdo_dblib_mssql();
		
		// Pull volunteer periods that match the incoming 'sign out' email for the date entered )or today if no date entered)
		$query_string = "SELECT v.email as 'email', vp.id as 'id', vp.check_in_time as 'sign_in', vp.hours as 'hours', v.id as 'vid'
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							WHERE v.email = '".$clean_email."' AND vp.hours = '0.0'
							AND vp.check_in_time > '".$lower_bound_date."' and vp.check_in_time < '".$upper_bound_date."'";

		$results = $db->executeStatement($query_string,[])->fetchAll();

		if (sizeof($results) > 0) {
			$found_sign_in = false;
			foreach ($results as $previous_login) {
				$volunteer_id = $previous_login['vid'];
				$previous_hours = $previous_login['hours'];
				if ($previous_hours == 0.0) {
					// Record this one
					$found_sign_in = true;
					// Result found - sign out EACH session and determine the one to close out
					$to_update = $previous_login;
					$volunteer_period_id = $to_update['id'];
					$sign_in_date = date_parse_from_format ( $sql_date_format , $to_update['sign_in'] );

					// Format Sign Out Time
					$sign_out_time = $clean_date["year"]."-".$clean_date["month"]."-".$clean_date["day"] 
										." ".$clean_date["hour"].":".$clean_date["minute"].":00";

					// Calculate Hours - End hours - Start Hours (minutes over 30 = add .5)
					$hours = calculateHours($sign_in_date, $clean_date);
					if ($hours < 0) {
						// Format display of time for error message
						$sign_in_date_display = $sign_in_date["month"]."-".$sign_in_date["day"]."-".$sign_in_date["year"];
						if ($sign_in_date["hour"] == 00) {
							$sign_in_ampm_display = "am";
							$sign_in_time_display = 12;
						} elseif ($sign_in_date["hour"] > 12) {
							$sign_in_ampm_display = "pm";
							$sign_in_time_display = ($sign_in_date["hour"] - 12);
						} else {
							$sign_in_ampm_display = "am";
							$sign_in_time_display = $sign_in_date["hour"];
						}
						if ($sign_in_date["minute"] < 10) {
							$sign_in_time_display = $sign_in_time_display.":0".$sign_in_date["minute"]." ".$sign_in_ampm_display;	
						} else {
							$sign_in_time_display = $sign_in_time_display.":".$sign_in_date["minute"]." ".$sign_in_ampm_display;						
						}
						?><p class='alert alert-danger'>For the date <?= $sign_in_date_display ?>, it looks like you didn't sign out after your <?= $sign_in_time_display ?> sign in.  We need  you to sign out of that day after the sign in time. Thanks!. <span class="hidden">ERROR: Signing out on a day where they did not sign in.</span></p><?php 						
					} else {
						// Track errors
						try {
							$feedback_insert = "INSERT INTO feedback (volunteer_id, feedback) VALUES ('".$volunteer_id."','".$feedback."')";
							$feedback_id = $db->executeStatement($feedback_insert,[]);
							if ($feedback_id > 0) {
								// Update String Query
								$update_string = "UPDATE volunteer_period
													SET check_out_time = '".$sign_out_time."',hours = '".$hours."',feedback_id = '".$feedback_id."'
												  	WHERE id = ".$volunteer_period_id;
								if ($db->executeStatement($update_string,[])) {
									// Success
									?><p>Successfully Signed Out! ||<?= $hours ?>|| <span class="hidden">SUCCESS</p><?php
								} else {
									// Failure
									?><p class='alert alert-danger'>Sorry! Was unable to log your sign out time. <span class="hidden">ERROR: <?= $db->errorInfo() ?> </span></p><?php 
								}
							} else {
								?><p class='alert alert-danger'>Sorry! Was unable to log your feedback or sign out time. <span class="hidden">ERROR: <?= $db->errorInfo() ?> </span></p><?php 
							}
						} catch (PDOException $e) {
							?><p class='alert alert-danger'>Sorry! We're having issues logging users off. <span class="hidden">ERROR: <?= $e->getMessage() ?> </span></p><?php 
						}
					}
				}
			}
			if (!$found_sign_in) {
				// Report error
				$sign_in_date_display = $clean_date["month"]."-".$clean_date["day"]."-".$clean_date["year"];
				?><p class='alert alert-danger'>All sign ins for '<?= $sign_in_date_display ?>' have been signed out for the email '<?= $clean_email ?>'. If this is an issue, please <a href="/sign-in.html">sign in again</a> at the correct time and then sign out. <span class="hidden">ERROR: Of sign ins found, all were signed out. Searched between <?= $lower_bound_date ?> and <?= $upper_bound_date ?>. </span></p><?php
			}
		} else {
			// Report error
			?><p class='alert alert-danger'>No sign ins were found for the email '<?= $clean_email ?>' for the date entered.<span class="hidden">ERROR: No sign in found. Searched between '<?= $lower_bound_date ?>' and '<?= $upper_bound_date ?>'. </span></p><?php
		}
		// Close db connection
		$db->close();
	} else {
		?><p class='alert alert-danger'>Email address was not recieved by the server<span class="hidden">ERROR: No email passed</span></p><?php
	}
?>