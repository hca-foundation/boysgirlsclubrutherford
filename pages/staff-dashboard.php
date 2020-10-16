<?php 
	// TODO: Ensure user is logged in
	// TODO: Check permissions again so that no one can get directly to this page
?>

<h2>Website Management</h2>
<ul>
	<li><a href="/pages/manage-volunteers.php">Manage Volunteers</a></li>
	<li><a href="/pages/manage-locations.php">Manage Locations</a></li>
	<li><a href="/pages/manage-tasks.php">Manage Tasks</a></li>
</ul>	

<h2>Dashboard</h2>
<div class="row">
	Total volunteers is <?=$volunteer_results[0]['userCount']?>.
	<ul>
		<li>Provide a listing of all volunteers and hours (table probably)</li>
		<li>Have filters allowing to filter on date, location, and individual volunteer</li>
		<li>Provide large 'scorecards' that show total volunteers and hours volunteered for the selected period</li>
	</ul>
</div>