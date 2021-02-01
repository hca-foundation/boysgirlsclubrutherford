<?php
// Setup Globals
include_once 'global.php';

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
						. " 00:00:00";
	} else {
		$end_filter = "";
	}

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
		$filter_query = ($end_filter != "") ? $filter_query." and vp.check_out_time < '".$end_filter."'" : $filter_query;
	} else {
		$filter_query = ($end_filter != "") ? " where vp.check_out_time < '".$end_filter."'" : "";
	}

// Individual Lookup / Manage
if (isLoggedIn()) {
    $email = getLoggedInUserEmail();
    $vol_query = "SELECT * FROM volunteer WHERE email = ?";
    $results = $db->executeStatement($vol_query, array($email))->fetchAll();

    // Get all Volunteer Periods
    $query_string = "SELECT *
							FROM volunteer v
							JOIN volunteer_period vp on vp.volunteer_id = v.id
							JOIN job_type jt on jt.id = vp.job_type_id
							JOIN location l on l.id = vp.location_id"
							.$filter_query
							." AND v.email = '" . $email . "'"
							." ORDER BY vp.check_in_time";
    $vol_periods = $db->executeStatement($query_string, [])->fetchAll();
    // Pull locations
    $query_string = "SELECT id, location_name
							FROM location
							ORDER BY location_name";
    $location_results = $db->executeStatement($query_string, [])->fetchAll();
    // Pull Job Types
    $query_string = "SELECT id, job_type
							FROM job_type
							ORDER BY job_type";
    $type_results = $db->executeStatement($query_string, [])->fetchAll();

    $vol_address_query = "SELECT * FROM address WHERE address.volunteer_id = ?";
    $vol_addresses = $db->executeStatement($vol_address_query, array($results[0]['id']))->fetchAll();

    // address fields
    $street_one = '';
    $street_two = '';
    $city = '';
    $state = '';
    $zip = '';

	if (isset($vol_address_query[0])) {
		if (isset($vol_addresses[0]['street_one'])) {
            $street_one = filter_var($vol_addresses[0]['street_one'], FILTER_SANITIZE_STRING);
        }
        if (isset($vol_addresses[0]['street_two'])) {
            $street_two = filter_var($vol_addresses[0]['street_two'], FILTER_SANITIZE_STRING);
        }
        if (isset($vol_addresses[0]['city'])) {
            $city = filter_var($vol_addresses[0]['city'], FILTER_SANITIZE_STRING);
        }
        if (isset($vol_addresses[0]['state'])) {
            $state = filter_var($vol_addresses[0]['state'], FILTER_SANITIZE_STRING);
        }
        if (isset($vol_addresses[0]['zip'])) {
            $zip = filter_var($vol_addresses[0]['zip'], FILTER_SANITIZE_STRING);
        }
	}

    $emergency_contact_query = "SELECT * FROM emergency_contact WHERE emergency_contact.volunteer_id = ?";
    $emergency_contacts = $db->executeStatement($emergency_contact_query, array($results[0]['id']))->fetchAll();

    // emergency contact fields
    $ec_first_name = '';
    $ec_last_name = '';
    $ec_phone = '';
    
    if (isset($emergency_contacts[0])) {
        $ec_first_name = filter_var($emergency_contacts[0]['first_name'], FILTER_SANITIZE_STRING);
        $ec_last_name = filter_var($emergency_contacts[0]['last_name'], FILTER_SANITIZE_STRING);
        $ec_phone = filter_var($emergency_contacts[0]['phone'], FILTER_SANITIZE_STRING);
    }

}
?>