<?php	
	// Setup Globals
	include_once 'global.php';
	$all_events = "SELECT * FROM event";
  $results = $db->executeStatement($all_events,[])->fetchAll();
?>