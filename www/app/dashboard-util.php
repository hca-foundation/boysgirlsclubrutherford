<?php	
	// Setup Globals
	include_once 'global.php';

	// Check for Filter Posts and grab to change queries	
	$name_filter = (isset($_POST['vol_name']) && $_POST['vol_name'] != "") ? filter_var ( $_POST['vol_name'], FILTER_SANITIZE_STRING) : "";
	$task_filter = (isset($_POST['task']) && $_POST['task'] != "") ? filter_var ( $_POST['task'], FILTER_SANITIZE_STRING) : "";
	$location_filter = (isset($_POST['location']) && $_POST['location'] != "") ? filter_var ( $_POST['location'], FILTER_SANITIZE_STRING) : "";
	$start_date_parsed = (isset($_POST['starttime']) && $_POST['starttime'] != "") ? date_parse_from_format ( $ui_date_format, filter_var ( $_POST['starttime'], FILTER_SANITIZE_STRING)) : "";
	if ($start_date_parsed != "") {
		$start_filter = $start_date_parsed["year"] . "-" . $start_date_parsed["month"] . "-" . $start_date_parsed["day"] 
						. " 00:00:00";	
	} else {
		$start_filter = "";
	}
	$end_date_parsed = (isset($_POST['endtime']) && $_POST['endtime'] != "") ? date_parse_from_format ( $ui_date_format, filter_var ( $_POST['endtime'], FILTER_SANITIZE_STRING)) : "";
	if ($end_date_parsed != "") {
		$end_filter = $end_date_parsed["year"] . "-" . $end_date_parsed["month"] . "-" . $end_date_parsed["day"] 
						. " 23:59:59";
	} else {
		$end_filter = "";
	}
	// Setup query - Name Filter
	$filter_query = ($name_filter != "") ? " where v.id = '".$name_filter."'" : "";

	// Setup query - Task Filter
	if ($filter_query != "") {
		$filter_query = ($task_filter != "") ? $filter_query." and jt.id = '".$task_filter."'" : $filter_query;
	} else {
		$filter_query = ($task_filter != "") ? " where jt.id = '".$task_filter."'" : "";
	}

	// Setup query - Location Filter
	if ($filter_query != "") {
		$filter_query = ($location_filter != "") ? $filter_query." and l.id = '".$location_filter."'" : $filter_query;
	} else {
		$filter_query = ($location_filter != "") ? " where l.id = '".$location_filter."'" : "";
	}

	// Setup query - start date
	if ($filter_query != "") {
		$filter_query = ($start_filter != "") ? $filter_query." and vp.check_in_time > '".$start_filter."'" : $filter_query;
	} else {
		$filter_query = ($start_filter != "") ? " where vp.check_in_time > '".$start_filter."'" : "";
	}

	// Setup query - end date
	if ($filter_query != "") {
		$filter_query = ($end_filter != "") ? $filter_query." and vp.check_in_time < '".$end_filter."'" : $filter_query;
	} else {
		$filter_query = ($end_filter != "") ? " where vp.check_out_time < '".$end_filter."'" : "";
	}

	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Get All Users
		$all_users = "SELECT COUNT(DISTINCT(v.id)) as 'userCount' 
					FROM volunteer v";

		$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();

		$all_hours = "SELECT count(vp.id) as 'volVisits', sum(vp.hours) as 'volHours' 
					FROM volunteer_period vp
					JOIN job_type jt on jt.id = vp.job_type_id
					JOIN location l on l.id = vp.location_id";
		$vol_hours = $db->executeStatement($all_hours,[])->fetchAll();



		$all_periods = "SELECT *
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id 
							JOIN job_type jt on jt.id = vp.job_type_id
							JOIN location l on l.id = vp.location_id "
							.$filter_query
							." ORDER BY vp.check_in_time";
		$vol_periods = $db->executeStatement($all_periods,[])->fetchAll();

		//Get All Volunteer Data
		
		$query_string = "SELECT id, location_name
						FROM location
						ORDER BY location_name";			
		$location_results = $db->executeStatement($query_string,[])->fetchAll();

		$query_string = "SELECT id, job_type
							FROM job_type
							ORDER BY job_type";
		$type_results = $db->executeStatement($query_string,[])->fetchAll();

		$query_string = "SELECT id, first_name, last_name
							FROM volunteer
							ORDER BY first_name";			
		$name_results = $db->executeStatement($query_string,[])->fetchAll();

		

		$volunteer_query = "SELECT v.email as 'email', concat(concat(v.first_name, ' '), v.last_name) as 'name', sum(vp.hours) as 'hours', count(vp.id) as 'num',  MIN(check_in_time) as 'first', MAX(check_in_time) as 'latest'
						FROM volunteer_period vp
						JOIN volunteer v on v.id = vp.volunteer_id
						JOIN job_type jt on jt.id = vp.job_type_id
						JOIN location l on l.id = vp.location_id"
						.$filter_query
						. " GROUP BY v.email, v.first_name, v.last_name ORDER BY hours desc";

		// Feedback Query
		$feedback_filter_query = ($filter_query != "") ? $filter_query." and f.feedback != ''" : " WHERE f.feedback != ''";
		$feedback_query = "SELECT v.email, vp.check_in_time, f.feedback
						FROM feedback f
						JOIN volunteer v on v.id = f.volunteer_id
						JOIN volunteer_period vp on f.id = vp.feedback_id
						JOIN job_type jt on jt.id = vp.job_type_id
						JOIN location l on l.id = vp.location_id"
						.$feedback_filter_query
						. " ORDER BY vp.check_in_time";

		$volunteer_query_results = $db->executeStatement($volunteer_query,[])->fetchAll();
		$feedback_query_results = $db->executeStatement($feedback_query,[])->fetchAll();
	}
?>