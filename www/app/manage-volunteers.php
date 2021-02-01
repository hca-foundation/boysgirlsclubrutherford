<?php	
	// Setup Globals
	include_once 'global.php';

	// Individual Lookup / Manage
	if (isset($_GET['email'])) {
		$email = filter_var ( $_GET['email'], FILTER_SANITIZE_STRING);
		$vol_query = "SELECT * FROM Volunteer v LEFT OUTER JOIN address a ON v.id = a.volunteer_id WHERE email = ?";
		$results = $db->executeStatement($vol_query, array($email))->fetchAll();

		$emergency_contact_query = "SELECT * FROM emergency_contact WHERE emergency_contact.volunteer_id = ?";
		$emergency_contact_results = $db->executeStatement($emergency_contact_query, [$results[0]['id']])->fetchAll();
		$has_emergency_contact = isset($emergency_contact_results[0]);

		$results[0]['ec_phone'] = isset($emergency_contact_results[0]) ? $emergency_contact_results[0]['phone'] : '';
		$results[0]['ec_first_name'] = isset($emergency_contact_results[0]) ? $emergency_contact_results[0]['first_name'] : '';
		$results[0]['ec_last_name'] = isset($emergency_contact_results[0]) ? $emergency_contact_results[0]['last_name'] : '';
		
		// Get all Volunteer Periods
		$query_string = "SELECT *
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							WHERE v.email = '".$email."'
							ORDER BY vp.check_in_time";		
		$vol_periods = $db->executeStatement($query_string, [])->fetchAll();			
		// Pull locations
		$query_string = "SELECT id, location_name
							FROM location
							ORDER BY location_name";			
		$location_results = $db->executeStatement($query_string,[])->fetchAll();
		// Pull Job Types
		$query_string = "SELECT id, job_type
							FROM job_type
							ORDER BY job_type";
		$type_results = $db->executeStatement($query_string,[])->fetchAll();

	// Get All Users
	} else {
		// Check for query string
		if (isset($_GET['search-vols'])) {
			
			if ($_GET['search-vols'] == "*") {
				// Key to get all
				$all_vols = "SELECT DISTINCT v.id, v.first_name, v.last_name, v.email
					 			FROM volunteer v";

				$results = $db->executeStatement($all_vols,[])->fetchAll();
			} else {
				// Clean it up and query - check first name, last name, email and volunteer period - affiliation
				$query_string = strtoupper(filter_var ( $_GET['search-vols'], FILTER_SANITIZE_STRING));
				$all_vols = "SELECT DISTINCT v.id, v.first_name, v.last_name, v.email
					 			FROM volunteer v
								LEFT JOIN volunteer_period vp on vp.volunteer_id = v.id
								WHERE v.email LIKE '%".$query_string."%'
								OR v.first_name LIKE '%".$query_string."%'
								OR v.last_name LIKE '%".$query_string."%'
								OR vp.affiliation LIKE '%".$query_string."%'";

				$results = $db->executeStatement($all_vols,[])->fetchAll();
			}
		}
	}
?>