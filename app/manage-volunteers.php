<?php	
	// Setup Globals
	include_once 'global.php';
	$is_individual = false;

	// Individual Lookup / Manage
	if (isset($_GET['email'])) {
		$email = filter_var ( $_GET['email'], FILTER_SANITIZE_STRING);
		$vol_query = "SELECT * FROM volunteer WHERE email = ?";
		$results = $db->executeStatement($vol_query, array($email))->fetchAll();
		$is_individual = true;
		
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
?>