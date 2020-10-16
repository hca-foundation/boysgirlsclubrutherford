<?php	
	// Setup Globals
	include_once 'global.php';
	$all_locs = "SELECT * FROM location";
	$results = $db->executeStatement($all_locs,[])->fetchAll();
?>