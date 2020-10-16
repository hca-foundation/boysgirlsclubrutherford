<?php	
	// Setup Globals
	include_once 'global.php';
	$all_tasks = "SELECT * FROM job_type";
	$results = $db->executeStatement($all_tasks,[])->fetchAll();
?>