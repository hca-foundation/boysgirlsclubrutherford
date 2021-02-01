<?php 
if (!isLoggedIn()) {
	//	Session variable not set - redirect to login
	header("Location: " . $login_url);
} else {
?>
<h2>Website Management</h2>
<ul>
	<li><a href="/pages/manage-volunteers.php">Manage Volunteers</a></li>
	<li><a href="/pages/manage-locations.php">Manage Locations</a></li>
	<li><a href="/pages/manage-tasks.php">Manage Tasks</a></li>
	<li><a href="/pages/manage-events.php">Manage Events</a></li>
</ul>	

<h2>Dashboard</h2>
 <div class="row">
	<!--<ul>
		<li>Provide a listing of all volunteers and hours (table probably)</li>
		<li>Have filters allowing to filter on date, location, and individual volunteer</li>
		<li>Provide large 'scorecards' that show total volunteers and hours volunteered for the selected period</li>
	</ul>-->
</div> 

<div class="row">
		<div id="total-vols-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-vols-display" class="card boom">
				<div class="stat-label">Total Volunteers</div>
				<span class="value"><?=$volunteer_results[0]['userCount']?></span>
			</div>
		</div>
		<div id="total-hours-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-hours-display" class="card boom">
				<div class="stat-label">Total Hours</div>
				<span class="value"><?=$vol_hours[0]['volHours']?></span>
			</div>
		</div>
		<div id="total-times-display-wrapper" class="col-sm-4 stat-item text-center">
			<div id="total-times-display" class="card boom">
				<div class="stat-label">Total Visits</div>
				<span class="value"><?=$vol_hours[0]['volVisits']?></span>
			</div>
		</div>
	</div>

<div class="row">
		<div id="filter-section" class="col-sm-12">
			<form id="data-filter" method="POST">
				<blockquote><strong>Please Note:</strong> When filtering on task or location, you will also need to select dates.</blockquote>
				
				<div class="form-group col-sm-3">
					<label for="vol_name">Name</label>
					<select class="form-control" id="vol_name" name="vol_name">
						<option selected="true" value="">Please Select A Name</option>
						<?php
							foreach ($name_results as $row) {
								?>
									<option <?php if ($name_filter == $row['id']) { echo "selected=selected"; } ?>
									 value="<?=$row['id']?>"><?=$row['first_name']?> <?=$row['last_name']?></option>
								<?php
							}
						?>
					</select>
				</div>
				
				<div class="form-group col-sm-3">
					<label for="datetime-picker">Start Date</label>
					<input type='text' class="form-control datetime-picker" id="start-datetime-picker" autocomplete="chrome-off" data-format="yyyy-MM-dd hh:mm:00" name="starttime" placeholder="MM/DD/YYYY 12:01 AM" />
					<input type="hidden" id="startdate-default" value="<?=$start_filter?>">
				</div>
				<div class="form-group col-sm-3">
					<label for="datetime-picker">End Date</label>
					<input type='text' class="form-control datetime-picker" id="end-datetime-picker" autocomplete="chrome-off" data-format="yyyy-MM-dd hh:mm:00" name="endtime" placeholder="MM/DD/YYYY 12:01 AM" />
					<input type="hidden" id="enddate-default" value="<?=$end_filter?>">
				</div>
				<div class="form-group col-sm-3">
					<label for="activity">Activity</label>
					<select class="form-control" id="task" name="task">
						<option selected="true" value="">Please Select A Task</option>
						<?php
							foreach ($type_results as $row) {
								?>
									<option <?php if ($task_filter == $row['id']) { echo "selected=selected"; } ?>
									 value="<?=$row['id']?>"><?=$row['job_type']?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label for="location">Location</label>
					<select class="form-control" id="location" name="location">
						<option selected="true" value="">Please Choose A Location</option>
						<?php
							foreach ($location_results as $row) {
								?>
									<option <?php if ($location_filter == $row['id']) { echo "selected=selected"; } ?>
									value="<?=$row['id']?>"><?=$row['location_name']?></option>
								<?php
							}
						?>
					</select>
				</div>

			<div class="form-group col-sm-12 text-right">
					<button type="button" class="btn btn-danger pull-left" onclick="signout();return false;">Signout All Volunteers</button>
					<div class="btn-group pull-right" role="group" aria-label="Search Actions">
						<button type="submit" class="btn btn-primary">Search</button>
						<button type="button" class="btn btn-default" onclick="downloadCSV('vol-hours',8);return false;">Download Displayed Volunteer Hours</button>
						<button type="submit" class="btn btn-default" onclick="resetDashboard();return true;">Reset Filters</button>
					</div>
				</div>

		</form>
	</div>
</div>

<!-- Retrieve volunteer periods -->
<div class="table-responsive">
	<table id="vol-hours" class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th>Sign In</th>
				<th>Sign Out</th>
				<th>Duration</th>
				<th>Activity</th>
				<th>Location</th>
				<th>Affiliation</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>

			<?php
				if (sizeof($vol_periods) > 0) {
			?>
			<?php
				foreach ($vol_periods as $vol_period) {
					// QUERY JOB AND LOCATION
			?>
			<tr>
				<td><?=$vol_period["first_name"]?> <?=$vol_period["last_name"]?></td>
		<?php
					$checkin_date = date_parse_from_format ( $sql_date_format , $vol_period["check_in_time"]);
					$checkedin_date = $checkin_date["month"] . "-" . $checkin_date["day"] . "-" . $checkin_date["year"];
					$checkout_date = date_parse_from_format ( $sql_date_format , $vol_period["check_out_time"]);

					// Time stamps
					$checkin_day = $checkin_date["day"];
					if(strlen($checkin_day."") == 1) {
						$checkin_day = "0".$checkin_day;
					}

					$checkin_month = $checkin_date["month"];
					if(strlen($checkin_month."") == 1) {
						$checkin_month = "0".$checkin_month;
					}

					$checkin_minute = $checkin_date["minute"];
					if(strlen($checkin_minute."") == 1) {
						$checkin_minute = "0".$checkin_minute;
					}

					$checkin_ampm = "AM";
					$checkin_hour = $checkin_date["hour"];
					if(strlen($checkin_hour."") > 1) {
						if ($checkin_date["hour"] > 12) {
							$checkin_hour = $checkin_date["hour"] - 12;
							if ($checkin_date["hour"] != 24) {
								$checkin_ampm = "PM";
							}
						} elseif ($checkin_date["hour"] == 12) {
							$checkin_ampm = "PM";
						}
					}

					$checkout_minute = $checkout_date["minute"];
					if(strlen($checkout_minute."") == 1) {
						$checkout_minute = "0".$checkout_minute;
					}

					$checkout_ampm = "AM";
					$checkout_hour = $checkout_date["hour"];
					if(strlen($checkout_hour."") > 1) {
						if ($checkout_date["hour"] > 12) {
							$checkout_hour = $checkout_date["hour"] - 12;
							if ($checkout_date["hour"] != 24) {
								$checkout_ampm = "PM";
							}
						} elseif ($checkout_date["hour"] == 12) {
							$checkout_ampm = "PM";
						}
					}

				?>
				<td><?=$checkin_month?>/<?=$checkin_day?>/<?=$checkin_date["year"]?></td>
				<td><?=$checkin_hour?>:<?=$checkin_minute?> <?=$checkin_ampm?></td>
				<td><?=$checkout_hour?>:<?=$checkout_minute?> <?=$checkout_ampm?></td>
				<td><?=$vol_period["hours"]?></td>
				<?php
					foreach ($type_results as $job_type_row) {
						if ($job_type_row['id'] == $vol_period["job_type_id"]) {
				?>
				<td><?=$job_type_row["job_type"]?></td>
				<?php
						}
					}
					foreach ($location_results as $location_row) {
						if ($location_row['id'] == $vol_period["location_id"]) {
				?>
				<td><?=$location_row["location_name"]?></td>
				<?php
						}
					}
				?>
				<td><?=$vol_period["affiliation"]?></td>
				<td>							
							<a href="#" class="edit-period" data-id="<?=$vol_period["id"]?>" 
														data-signin="<?=$checkin_month?>/<?=$checkin_day?>/<?=$checkin_date["year"]?> <?=$checkin_hour?>:<?=$checkin_minute?> <?=$checkin_ampm?>" 
														data-signout="<?=$checkin_month?>/<?=$checkin_day?>/<?=$checkin_date["year"]?> <?=$checkout_hour?>:<?=$checkout_minute?> <?=$checkout_ampm?>" 
														data-activity="<?=$vol_period["job_type_id"]?>" 
														data-location="<?=$vol_period["location_id"]?>" 
														data-org="<?=$vol_period["affiliation"]?>" 
														data-toggle="modal" 
														data-target="#edit-modal" 
														onclick="editPeriod(this); return false;">
									<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
									<span class="sr-only">Edit</span>
							</a>
				</td>
			</tr>
			<?php
				}
			?>
			<?php
				}
			?>
		</tbody>
	</table>
</div>

<!-- Volunteer Period Modal -->
			<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Edit Period</h4>
						</div>
						<div class="modal-body">
							<form id="edit-period-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="vol-period-id" name="vol-period-id" value="">
								<input type="hidden" id="type" name="type" value="volunteer-period">

								<div class="form-group">
									<label for="datetime-picker">Sign In</label>
									<input type='text' class="form-control datetime-picker" id="signin-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signintime" placeholder="MM/DD/YYYY 12:01 AM" />
								</div>
								<div class="form-group">
									<label for="datetime-picker">Sign Out</label>
									<input type='text' class="form-control datetime-picker" id="signout-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signouttime" placeholder="MM/DD/YYYY 12:01 AM" />
								</div>
								<div class="form-group">
									<label for="activity">Activity</label>
									<select required class="form-control" id="task" name="task">
										<option disabled selected="true" value="">Please Select A Task</option>
										<?php
											foreach ($type_results as $row) {
												?>
													<option value="<?=$row['id']?>"><?=$row['job_type']?></option>
												<?php
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="location">Location</label>
									<select required class="form-control" id="location" name="location">
										<option disabled selected="true" value="">Please Choose A Location</option>
										<?php
											foreach ($location_results as $row) {
												?>
													<option value="<?=$row['id']?>"><?=$row['location_name']?></option>
												<?php
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="organization">Affiliation</label>
									<input class="form-control" type="text" id="organization" name="organization" value="">
								</div>
								<button type="submit" class="btn btn-success">Save changes</button>
							</form>
						</div><!-- /modal-body -->
					</div><!-- /modal-content -->
				</div><!-- /modal-dialog -->
			</div><!-- /modal -->
<?php 
}
?>
