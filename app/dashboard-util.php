<?php	
	// Setup Globals
	include_once 'global.php';

	// TODO: Update queries based on user permissions and what they should see on the page

	// Get All Users
	$all_users = "SELECT COUNT(DISTINCT(v.id)) as 'userCount' FROM volunteer v";
	$volunteer_results = $db->executeStatement($all_users,[])->fetchAll();
?>