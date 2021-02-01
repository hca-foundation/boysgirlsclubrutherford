<?php
	header('Content-type:application/json;charset=utf-8');	

//////////////////////
// Service page for JSON calls
// - Supported services: locations, job_type
//////////////////////
	$data = false;
	$service = "";
	$json_result = "";

	// Setup Globals and connections
	include_once 'global.php';
	if (isset($_GET['service'])) {
		// Service was passed, valid request
		$service = $_GET['service'];

//////////////////////
// LOCATIONS /app/services.php?service=locations
//////////////////////
		if ($service === "locations") {
			// Query locations

			$query_string = "SELECT id, location_name
								FROM location
								WHERE active = 1
								ORDER BY location_name";			
			$results = $db->executeStatement($query_string,[])->fetchAll();
			$json_result = "[";
			$result_count = 0;
			foreach ($results as $row) {
				if ($result_count != 0) {
					$json_result = $json_result . ',';
				}
				$json_result = $json_result . '{ "id":"'.$row['id'].'","name":"'.$row['location_name'].'"}';
				$result_count = $result_count + 1;
			}
			$json_result = $json_result . "]";
			$data = '{ "status":"Success", "service":"'.$service.'", "data":'.$json_result.'}';

//////////////////////
// JOB TYPES  /app/services.php?service=job_type
//////////////////////
		} else if ($service === "job_type") {
			// Query Job Types
			$query_string = "SELECT id, job_type
								FROM job_type
								ORDER BY job_type";
			$results = $db->executeStatement($query_string,[])->fetchAll();
			$json_result = "[";
			$result_count = 0;
			foreach ($results as $row) {
				if ($result_count != 0) {
					$json_result = $json_result . ',';
				}
				$json_result = $json_result . '{ "id":"'.$row['id'].'","name":"'.$row['job_type'].'"}';
				$result_count = $result_count + 1;
			}
			$json_result = $json_result . "]";
			$data = '{ "status":"Success", "service":"'.$service.'", "data":'.$json_result.'}';

//////////////////////
// UNSUPPORTED SERVICE
//////////////////////
		} else {
			$data = '{ "status":"Error", "message":"Service '.$service.' is not supported."}';	
		}
		// Close the DB Connection
		$db->close();
//////////////////////
// NO SERVICE PASSED
//////////////////////
	} else {
		$data = '{ "status":"Error", "message":"No service was passed."}';
	}

//////////////////////
// RETURN JSON
//////////////////////
	echo json_encode($data);	
?>