<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Volunteer Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-volunteers.php';

//  Individual - Page
		if (isset($_GET['email']) && isset($results) && sizeof($results) == 1)  {
			$volunteer = $results[0];
			?>
			<div id="management-form" class="container">
				<span><a class="back details-btn" onclick="window.history.back();">Back</a></span>
				<span class="pull-right">
					<a href="#" class="details-btn" data-toggle="modal" data-target="#edit-details" onclick="return false;">
						Edit
					</a>
				</span>

				<h1><?=$volunteer["first_name"]?> <?=$volunteer["last_name"]?></h1>
				<ul>
					<li><strong>Email Address</strong> - <?=$volunteer["email"]?></li>
					<li><strong>Skills</strong> - <?=$volunteer["skills"]?></li>
					<li><strong>Interests</strong> - <?=$volunteer["interests"]?></li>
					<li><strong>Availability</strong> - <?=$volunteer["availability"]?></li>
					<li><strong>How did you find out about us</strong> - <?=$volunteer["find_out_about_us"]?></li>
					<?php
						$email_dist = 'Yes';
						if($volunteer["include_email_dist"] == 0){
							$email_dist = 'No';
						}
					?>
					<li><strong>Email Distribution</strong> - <?=$email_dist?></li>
					<?php
						if(sizeof($vol_periods) > 0) {
							$volunteer_time = $vol_periods[0];
							$vol_start_date = date_parse_from_format ( $sql_date_format , $volunteer_time["check_in_time"]);
							$start_date = $vol_start_date["month"] . "-" . $vol_start_date["day"] . "-" . $vol_start_date["year"];
							$current_year =  date("Y");
							$vol_duration = $current_year - $vol_start_date["year"];
							if ($vol_duration < 1) {
								$vol_duration = "<1";
							}
						?>
							<li><strong>Volunteer since</strong> <?=$start_date?> (<?=$vol_duration?> year(s))</li>
						<?php
						}
					?>

					<?php
						$total_time = 0;
						$total_visits = sizeof($vol_periods);
						if ($total_visits > 0) {
							foreach ($vol_periods as $vol_period) {
								$total_time = $total_time + $vol_period["hours"];
							}
						}
					?>
					<li><strong>Activity</strong> - <?=$total_time?> hours and <?=$total_visits?> visits</li>
				</ul>
				<!-- Retrieve volunteer periods -->
				<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Sign In</th>
						<th>Sign Out</th>
						<th>Duration</th>
						<th>Activity</th>
						<th>Location</th>
						<th>Affiliation</th>
						<th></th>
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
										if ($checkin_hour["hour"] != 24) {
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
			</div>

			<!-- Volunteer Details Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Edit Volunteer Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="vol-id" name="vol-id" value="<?=$volunteer["id"]?>">
								<input type="hidden" id="type" name="type" value="volunteer">

								<div class="form-group">
									<label for="email">Email Address (Do Not Edit)</label>
									<input disabled class="form-control" type="text" id="email-label" name="email-label" value="<?=$volunteer["email"]?>">
									<input type="hidden" id="email" name="email" value="<?=$volunteer["email"]?>">
								</div>
								<div class="form-group">
									<label for="fn">First Name</label>
									<input class="form-control" type="text" id="fn" name="fn" value="<?=$volunteer["first_name"]?>">
								</div>
								<div class="form-group">
									<label for="ln">Last Name</label>
									<input class="form-control" type="text" id="ln" name="ln" value="<?=$volunteer["last_name"]?>">
								</div>
								<div class="form-group">
									<label for="skills">Skills</label>
									<input class="form-control" type="text" id="skills" name="skills" value="<?=$volunteer["skills"]?>">
								</div>
								<div class="form-group">
									<label for="interests">Interests</label>
									<input class="form-control" type="text" id="interests" name="interests" value="<?=$volunteer["interests"]?>">
								</div>
								<div class="form-group">
									<label for="availability">Availability</label>
									<input class="form-control" type="text" id="availability" name="availability" value="<?=$volunteer["availability"]?>">
								</div>
								<div class="form-group">
									<label for="email_dist">Include me in the email distribution</label>
									<input class="block" type="checkBox" id="email_dist" name="email_dist" value="<?=$volunteer["include_email_dist"]?>">
								</div>
								<button type="submit" class="btn btn-success">Save changes</button>
							</form>
						</div><!-- /modal-body -->
					</div><!-- /modal-content -->
				</div><!-- /modal-dialog -->
			</div><!-- /modal -->

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
		} else {
/////////////////////////////////////
// Not individual - list of volunteers page
			?>
			<div class="container">
				<h1>Volunteer Listing</h1>
				<form id="vol-search">
					<div class="form-group col-sm-9">
						<label for="search-vols" class="sr-only">Search Volunteers</label>
						<input class="form-control" id="search-vols" name="search-vols" placeholder="Search Volunteers" required type="text">
					</div>
					<div class="form-group col-sm-3">
						<button class="form-control btn btn-primary" id="search-vols-submit" type="submit">Search</button>
					</div>
				</form>

				<?php if (isset($results)) { ?>
					<table class="table table-striped table-responsive">
						<thead>
							<tr>
								<th>ID</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($results as $volunteer) {
							?>
							<tr class="search-row" data-search="<?=$volunteer["first_name"]?> <?=$volunteer["last_name"]?> <?=$volunteer["email"]?>">
								<td><?=$volunteer["id"]?></td>
								<td><?=$volunteer["first_name"]?></td>
								<td><?=$volunteer["last_name"]?></td>
								<td><a href="?email=<?=$volunteer["email"]?>"><?=$volunteer["email"]?></a></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				<?php } ?>
			</div>	
			<?php
/////////////////////////////////////
		}
	}
	include_once '../footer.php';
?>