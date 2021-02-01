<?php
	//////////////////////
	// Checkin Page for Volunteers
	// - Form POSTS to this page
	//////////////////////

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
		
	// Setup Globals
	include_once 'global.php';

	define('GENERAL_EVENT_ID', 1);
	
	//////////////////////
	// Required Field Error Messages
	//////////////////////

	$volunteer_id = getLoggedInUserVolunteerId();
	$email = getLoggedInUserEmail();
	$process_fail = false;

	// validate required params
	if (!isset($_POST['signintime'])) {
		$process_fail = true;
		?> <p class='alert alert-danger'>Datetime is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
	} elseif(!isset($_POST['location'])) {
		$process_fail = true;
		?> <p class='alert alert-danger'>Location is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
	} elseif(!isset($_POST['task'])) {
		$process_fail = true;
		?> <p class='alert alert-danger'>Task is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
	} else {
		$signin_date = filter_var ( $_POST['signintime'], FILTER_SANITIZE_STRING); // 02/07/2017 6:48 PM
		$location_id = (int) filter_var ( $_POST['location'], FILTER_SANITIZE_STRING);
		$task_id = (int) filter_var ( $_POST['task'], FILTER_SANITIZE_STRING);
		$signin_date = date_parse_from_format ( $ui_datetime_format , $signin_date );
		$event = isset($_POST['event'])
			? (int) filter_var($_POST['event'], FILTER_SANITIZE_STRING)
			: GENERAL_EVENT_ID; // default to General
		// Use passed date time to sign out - To SQL Format: 2016-11-14 14:00:00
		$sign_in_time = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] 
		. " " . $signin_date["hour"] . ":" . $signin_date["minute"] .":00";
		$first_time = 0;

		// Removed from UI for BGCRC - set to 1 by default
		$liability_check = 1;
		$health_check = 1;
		$photo_check = 1;

		$affiliation = "";
		$community_service = 0;
	}

	// only try to register volunteer if user is not logged in
	if (!$volunteer_id && !$process_fail) {
		if(!isset($_POST['email'])) {
			?> <p class='alert alert-danger'>Email is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
		} elseif(!isset($_POST['firstname'])) {
			?> <p class='alert alert-danger'>First name is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
		} elseif(!isset($_POST['lastname'])) {
			?> <p class='alert alert-danger'>Last name is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
		} elseif(!isset($_POST['phone'])) {
			?> <p class='alert alert-danger'>Phone number is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
		} elseif(!isset($_POST['dob'])) {
			?> <p class='alert alert-danger'>Date of birth is a required field. <span class="hidden">ERROR: Missing field</span></p> <?php
		} else {
			
			//////////////////////
			// Get and Sanitize all Form POST inputs
			//////////////////////
			$first_name = strtolower ( filter_var ( $_POST['firstname'], FILTER_SANITIZE_STRING));
			$last_name = strtolower ( filter_var ( $_POST['lastname'], FILTER_SANITIZE_STRING));
			$email = strtolower ( filter_var ( $_POST['email'], FILTER_SANITIZE_STRING));
			$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
			$dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
	
			// address fields
			$street_one = filter_var($_POST['street_one'], FILTER_SANITIZE_STRING);
			$street_two = filter_var($_POST['street_two'], FILTER_SANITIZE_STRING);
			$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
			if(isset($_POST['state'])) {
				$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
			}
			$zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);
	
			// emergency contact fields
			$ec_first_name = filter_var($_POST['ec_first_name'], FILTER_SANITIZE_STRING);
			$ec_last_name = filter_var($_POST['ec_last_name'], FILTER_SANITIZE_STRING);
			$ec_phone = filter_var($_POST['ec_phone'], FILTER_SANITIZE_STRING);
	
			if(isset($_POST['affiliation'])) {
				$affiliation = filter_var ( $_POST['affiliation'], FILTER_SANITIZE_STRING);
			}
			
			if(isset($_POST['community-service'])) {
				$community_service = (int) filter_var ( $_POST['community-service'], FILTER_SANITIZE_STRING);
			}
			$skills = "";
			if(isset($_POST['skills'])) {
				$skills = filter_var ( $_POST['skills'], FILTER_SANITIZE_STRING);
			}
			$find_out_about_us = "";
			if(isset($_POST['find-out-about-us'])) {
				$find_out_about_us = filter_var ( $_POST['find-out-about-us'], FILTER_SANITIZE_STRING);
			}
			$include_email_dist = 0;
			if(isset($_POST['include-email-dist'])) {
				$include_email_dist = (int) filter_var ( $_POST['include-email-dist'], FILTER_SANITIZE_STRING);
			}
	
			//////////////////////
			// Format any values for DB
			//////////////////////
			$formatted_dob = date('Y-m-d', strtotime($dob));
	
			//////////////////////
			// Insert Volunteer IF IT DOES NOT already exist
			//////////////////////
			// First time - will need to insert into Volunteer table - if already exists, don't insert
			$process_fail = false;
			$check_query = "SELECT id FROM volunteer WHERE email = ?";
			$results = $db->executeStatement($check_query, array($email))->fetchAll();
	
			// Without fetchAll, result count won't be checked
			if (sizeof($results) == 0) {
				// Didn't find anyone with a matching email - insert the new volunteer
				$volunteer_insert = "INSERT INTO volunteer (first_name,last_name,email,skills,interests,availability,find_out_about_us,include_email_dist,phone,dob)"
					." VALUES ('".$first_name."','".$last_name."','".$email."','".$skills."','','','".$find_out_about_us."','".$include_email_dist."','".$phone."','".$formatted_dob."')";
				if ($db->executeStatement($volunteer_insert,[])) {
					// Success - query to get id
					$new_volunteer = "SELECT id FROM volunteer WHERE email = ?";
					$results = $db->executeStatement($new_volunteer, array($email))->fetchAll();
					if (sizeof($results) > 0) {
						// Get the id
						$volunteer_row = $results[0];
						$volunteer_id = $volunteer_row['id'];
	
						// add initial address
						if ($street_one) {
							$address_insert = "INSERT INTO address (volunteer_id, street_one, street_two, city, state, zip)"
							. "VALUES (\"$volunteer_id\", \"$street_one\", \"$street_two\", \"$city\", \"$state\", \"$zip\")";
	
							$db->executeStatement($address_insert, []);
						}
	
						// add initial emergency contact
						if ($ec_first_name) {
							$emergency_contact_insert = "INSERT INTO emergency_contact (volunteer_id, first_name, last_name, phone)"
							. "VALUES (\"$volunteer_id\", \"$ec_first_name\", \"$ec_last_name\", \"$ec_phone\")";
	
							$db->executeStatement($emergency_contact_insert, []);
						}
					}
				} else {
					// Failure
					$process_fail = true;
					?><p class='alert alert-danger'>Sorry! There was an issue creating you as a volunteer.  <span class="hidden">ERROR: <?= $db->errorInfo() ?> </span></p><?php 
				}			
			} else {
				// Existing - get the ID for the volutneer period insert
				$volunteer_row = $results[0];
				$volunteer_id = $volunteer_row['id'];
			}
		}
	}
		
	//////////////////////
	// Insert Volunteer Period
	// - Be sure to make sure they have not signed in already today!
	//////////////////////
	if(!$process_fail && isset($volunteer_id)) {

		// Check if logged in already
		// Pull volunteer periods that match the incoming 'sign out' email for the date entered )or today if no date entered)

		// set signin time max and min for querying signins
		$lower_bound_date = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] . " 00:00:00";
		$upper_bound_date = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] . " 23:59:59";
		$query_string = "SELECT v.email as 'email', vp.id as 'id', vp.check_in_time as 'sign_in', vp.hours as 'hours'
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							WHERE v.email = '".$email."'
							AND vp.check_in_time > '".$lower_bound_date."' and vp.check_in_time < '".$upper_bound_date."'";
		
		$results = $db->executeStatement($query_string, [])->fetchAll();
		$log_time_period = true;
		if (sizeof($results) == 0) {
			// Not logged in yet today, log them in
			$log_time_period = true;
		} else {
			// Loop through all results: Check to see if logged out of previous session based on hours
			foreach ($results as $previous_login) {
				$previous_hours = $previous_login['hours'];
				if ($previous_hours == 0.0) {
					// They have logged out of previous session, allow to log in again
					$previous_signin_time = $previous_login['sign_in'];
					$process_fail = true;
					$log_time_period = false;
					?><p class='alert alert-danger'>It appears <?= $email ?> have already signed in today at <?= $previous_signin_time ?> but not signed out! Please <a href='<?=$signout_url?>'>sign out</a> before signing in again. <span class="hidden">ERROR: previously signed in today </span></p><?php 
				}
			}
		}
		
		// Only log time if passed to do so above
		if ($log_time_period) {
			$volunteer_period_insert = "INSERT INTO volunteer_period (check_in_time,check_out_time,hours,affiliation,health_release,photo_release,liability_release,first_time,job_type_id,location_id,community_service_hours,volunteer_id,event_id)"
				." VALUES ('".$sign_in_time."','".$sign_in_time."','0.0','".$affiliation."',".$health_check.",".$photo_check.",".$liability_check.",".$first_time.",".$task_id.",".$location_id.",".$community_service.",".$volunteer_id.",".$event.")";
			if ($db->executeStatement($volunteer_period_insert, [])) {
				// Success - we are good to go
				?> <p>Thanks for signing in!! <span class="hidden">SUCCESS</p> <?php
			} else {
				// Failure
				$process_fail = true;
				?><p class='alert alert-danger'>Sorry! There was an issue signing you in. <span class="hidden">ERROR: <?= $db->errorInfo() ?> </span></p><?php 
			}
		}
	}
	// Close db connection
	$db->close();
?>