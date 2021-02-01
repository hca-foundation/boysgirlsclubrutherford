<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Volunteer Management";
	include_once '../header.php';

	if (!isLoggedIn()) {
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
				<span><a class="pull-right btn btn-default" onclick="window.history.back();">Back</a></span>
				<h1><?=$volunteer["first_name"]?> <?=$volunteer["last_name"]?></h1>
				<div class="container">
					<!-- edit form column -->
					<div class="col-lg-8 push-lg-4 personal-info">
						<form role="form" id="edit-details-form" method="POST" action="../app/manage.php">
							<input type="hidden" id="type" name="type" value="volunteer">
							<input type="hidden" id="vol-id" name="vol-id" value="<?=$volunteer["id"]?>">
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label">Email</label>
								<div class="col-lg-4">
									<input disabled class="form-control" type="text" id="email-label" name="email-label" value="<?=$volunteer["email"]?>">
									<input type="hidden" id="email" name="email" value="<?=$volunteer["email"]?>">
								</div>
							</div>
							<div class="form-group row">
								<!-- Manage.php doesn't like this -->
								<label class="col-lg-3" for="active">Is User Active?</label>
								<input type='hidden' name='active' value='0' id="active" />
								<input type='checkbox' name='active' value='1' id="active"  <?php if($volunteer["active"]==1){echo "checked";}?> />
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label form-control-label" for="fn">First Name</label>
								<div class="col-lg-4">
									<input class="form-control" type="text" id="fn" name="fn" value="<?=$volunteer["first_name"]?>" />
								</div>
							</div>
							<div class="form-group row">
									<label class="col-lg-3 col-form-label form-control-label" for="ln">Last Name</label>
									<div class="col-lg-4">
										<input class="form-control" type="text" id="ln" name="ln" value="<?=$volunteer["last_name"]?>" />
									</div>
							</div>
							<div class="form-group row">
                                <?php
									$clean_date = date_parse_from_format ( $sql_date_format , $volunteer["dob"] );
									$dob_display = $clean_date["month"] . "/" . $clean_date["day"] ."/" . $clean_date["year"];
								?>    
									<label class="col-lg-3 col-form-label form-control-label" for="dob">Date of Birth</label>
                                    <div class="col-lg-4">
										<input type='text'
												class="form-control"
												value="<?=$dob_display?>"
												id="dob"
												name="dob"
												placeholder="Date of Birth (MM/DD/YYYY)"
												tabindex="5"
												maxlength="10"
												data-validation="true"
												data-validationtype="regex"
												data-validationregex="(0?[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.]\d{2,4}"
												data-validationmessage="Please be sure your date of birth is in the correct format.">
									</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3" for="skills">Skills</label>
								<div class="col-lg-8">
								<input class="form-control" type="text" id="skills" name="skills" value="<?=$volunteer["skills"]?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3" for="interests">Interests</label>
								<div class="col-lg-8">
								<input class="form-control" type="text" id="interests" name="interests" value="<?=$volunteer["interests"]?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3" for="availability">Availability</label>
								<div class="col-lg-8">
								<input class="form-control" type="text" id="availability" name="availability" value="<?=$volunteer["availability"]?>">
								</div>
							</div>
							<div class="form-group">
								<label for="email_dist">Include in the email distribution?</label>
								<input type='hidden' name='email_dist' value='0' id="email_dist" />
								<input class="block" type="checkBox" id="email_dist" name="email_dist" value="1" <?php if($volunteer["include_email_dist"]==1){echo "checked";}?> >
							</div>
							<div class="row">
								<div class="col-md-10">
									<h4>Address Information</h4>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-5 col-xs-10">
									<label for="street_one" class="sr-only">Address line 1</label>
									<input class="form-control" id="street_one" name="street_one" placeholder="Address line 1" tabindex="9" type="text" value="<?=$volunteer["street_one"]?>">
								</div>
								<div class="form-group col-md-5 col-xs-10">
									<label for="street_two" class="sr-only">Address line 2</label>
									<input class="form-control" id="street_two" name="street_two" placeholder="Address line 2" tabindex="10" type="text"value="<?=$volunteer["street_two"]?>">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-5 col-xs-10">
									<label for="city" class="sr-only">City</label>
									<input class="form-control" id="city" name="city" placeholder="City" tabindex="11" type="text" value="<?=$volunteer["city"]?>">
								</div>
								<div class="form-group col-md-5 col-xs-10">
									<label for="state" class="sr-only">State</label>
									<select class="form-control" id="state" name="state" tabindex="12" value="<?=$volunteer["state"]?>" selected="selected">
										<option value="">Please select a state...<?=$volunteer["state"]?></option>
										<option value="AL" <?php if($volunteer["state"]=="AL"){?>selected<?php }?> >Alabama</option>
										<option value="AK" <?php if($volunteer["state"]=="AK"){?>selected<?php }?> >Alaska</option>
										<option value="AZ" <?php if($volunteer["state"]=="AZ"){?>selected<?php }?> >Arizona</option>
										<option value="AR" <?php if($volunteer["state"]=="AR"){?>selected<?php }?> >Arkansas</option>
										<option value="CA" <?php if($volunteer["state"]=="CA"){?>selected<?php }?> >California</option>
										<option value="CO" <?php if($volunteer["state"]=="CO"){?>selected<?php }?> >Colorado</option>
										<option value="CT" <?php if($volunteer["state"]=="CT"){?>selected<?php }?> >Connecticut</option>
										<option value="DE" <?php if($volunteer["state"]=="DE"){?>selected<?php }?> >Delaware</option>
										<option value="DC" <?php if($volunteer["state"]=="DC"){?>selected<?php }?> >District Of Columbia</option>
										<option value="FL" <?php if($volunteer["state"]=="FL"){?>selected<?php }?> >Florida</option>
										<option value="GA" <?php if($volunteer["state"]=="GA"){?>selected<?php }?> >Georgia</option>
										<option value="HI" <?php if($volunteer["state"]=="HI"){?>selected<?php }?> >Hawaii</option>
										<option value="ID" <?php if($volunteer["state"]=="ID"){?>selected<?php }?> >Idaho</option>
										<option value="IL" <?php if($volunteer["state"]=="IL"){?>selected<?php }?> >Illinois</option>
										<option value="IN" <?php if($volunteer["state"]=="IN"){?>selected<?php }?> >Indiana</option>
										<option value="IA" <?php if($volunteer["state"]=="IA"){?>selected<?php }?> >Iowa</option>
										<option value="KS" <?php if($volunteer["state"]=="KS"){?>selected<?php }?> >Kansas</option>
										<option value="KY" <?php if($volunteer["state"]=="KY"){?>selected<?php }?> >Kentucky</option>
										<option value="LA" <?php if($volunteer["state"]=="LA"){?>selected<?php }?> >Louisiana</option>
										<option value="ME" <?php if($volunteer["state"]=="ME"){?>selected<?php }?> >Maine</option>
										<option value="MD" <?php if($volunteer["state"]=="MD"){?>selected<?php }?> >Maryland</option>
										<option value="MA" <?php if($volunteer["state"]=="MA"){?>selected<?php }?> >Massachusetts</option>
										<option value="MI" <?php if($volunteer["state"]=="MI"){?>selected<?php }?> >Michigan</option>
										<option value="MN" <?php if($volunteer["state"]=="MN"){?>selected<?php }?> >Minnesota</option>
										<option value="MS" <?php if($volunteer["state"]=="MS"){?>selected<?php }?> >Mississippi</option>
										<option value="MO" <?php if($volunteer["state"]=="MO"){?>selected<?php }?> >Missouri</option>
										<option value="MT" <?php if($volunteer["state"]=="MT"){?>selected<?php }?> >Montana</option>
										<option value="NE" <?php if($volunteer["state"]=="NE"){?>selected<?php }?> >Nebraska</option>
										<option value="NV" <?php if($volunteer["state"]=="NV"){?>selected<?php }?> >Nevada</option>
										<option value="NH" <?php if($volunteer["state"]=="NH"){?>selected<?php }?> >New Hampshire</option>
										<option value="NJ" <?php if($volunteer["state"]=="NJ"){?>selected<?php }?> >New Jersey</option>
										<option value="NM" <?php if($volunteer["state"]=="NM"){?>selected<?php }?> >New Mexico</option>
										<option value="NY" <?php if($volunteer["state"]=="NY"){?>selected<?php }?> >New York</option>
										<option value="NC" <?php if($volunteer["state"]=="NC"){?>selected<?php }?> >North Carolina</option>
										<option value="ND" <?php if($volunteer["state"]=="ND"){?>selected<?php }?> >North Dakota</option>
										<option value="OH" <?php if($volunteer["state"]=="OH"){?>selected<?php }?> >Ohio</option>
										<option value="OK" <?php if($volunteer["state"]=="OK"){?>selected<?php }?> >Oklahoma</option>
										<option value="OR" <?php if($volunteer["state"]=="OR"){?>selected<?php }?> >Oregon</option>
										<option value="PA" <?php if($volunteer["state"]=="PA"){?>selected<?php }?> >Pennsylvania</option>
										<option value="RI" <?php if($volunteer["state"]=="RI"){?>selected<?php }?> >Rhode Island</option>
										<option value="SC" <?php if($volunteer["state"]=="SC"){?>selected<?php }?> >South Carolina</option>
										<option value="SD" <?php if($volunteer["state"]=="SD"){?>selected<?php }?> >South Dakota</option>
										<option value="TN" <?php if($volunteer["state"]=="TN"){?>selected<?php }?> >Tennessee</option>
										<option value="TX" <?php if($volunteer["state"]=="TX"){?>selected<?php }?> >Texas</option>
										<option value="UT" <?php if($volunteer["state"]=="UT"){?>selected<?php }?> >Utah</option>
										<option value="VT" <?php if($volunteer["state"]=="VT"){?>selected<?php }?> >Vermont</option>
										<option value="VA" <?php if($volunteer["state"]=="VA"){?>selected<?php }?> >Virginia</option>
										<option value="WA" <?php if($volunteer["state"]=="WA"){?>selected<?php }?> >Washington</option>
										<option value="WV" <?php if($volunteer["state"]=="WV"){?>selected<?php }?> >West Virginia</option>
										<option value="WI" <?php if($volunteer["state"]=="WI"){?>selected<?php }?> >Wisconsin</option>
										<option value="WY" <?php if($volunteer["state"]=="WY"){?>selected<?php }?> >Wyoming</option>
									</select>

								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-10 col-xs-10">
									<label for="zip" class="sr-only">Zip Code</label>
									<input class="form-control" id="zip" name="zip" placeholder="Zip Code" tabindex="13" type="number" maxlength="5" value="<?=$volunteer["zip"]?>"					
											oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
							</div>
							<div class="row">
								<div class="col-md-10">
									<h4>Emergency Contact</h4>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-5 col-xs-10">
									<label for="ec_first_name" class="sr-only">First Name</label>
									<input class="form-control" id="ec_first_name" name="ec_first_name" placeholder="First Name" tabindex="14" type="text" value="<?=$volunteer["ec_first_name"]?>">
								</div>
								<div class="form-group col-md-5 col-xs-10">
									<label for="ec_last_name" class="sr-only">Last Name</label>
									<input class="form-control" id="ec_last_name" name="ec_last_name" placeholder="Last Name" tabindex="15" type="text" value="<?=$volunteer["ec_last_name"]?>">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-10 col-xs-10">
									<label for="ec_phone" class="sr-only">Phone</label>
									<input class="form-control" id="ec_phone" name="ec_phone" placeholder="Phone" type="tel" tabindex="16" value="<?=$volunteer["ec_phone"]?>">
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-9">
									<button type="submit" class="btn btn-primary">Save Changes</button>
									<input type="reset" class="btn btn-secondary" value="Cancel" />
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Retrieve volunteer periods -->
				<h2>Volunteer Periods</h2>
				<div class="table-responsive">
				<table id="vol-activity" class="table table-striped">
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
								<button type="submit" class="btn btn-success form-control">Save changes</button>
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
				<span><a class="pull-right btn btn-default" onclick="window.history.back();">Back</a></span>
				<h1>Volunteer Listing</h1>
				<form id="vol-search">
					<div class="form-group col-sm-6">
						<label for="search-vols" class="sr-only">Search Volunteers</label>
						<input class="form-control" id="search-vols" name="search-vols" placeholder="Search Volunteers - * to see all" required type="text">
					</div>
					<div class="form-group col-sm-3">
						<button class="form-control btn btn-primary" id="search-vols-submit" type="submit">Search</button>
					</div>
					<div class="form-group col-sm-3">
						<button type="button" class="form-control btn btn-default" data-toggle="modal" data-target="#new-vol">New Volunteer</button>
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
								<td><a href="?email=<?= urlencode($volunteer["email"]) ?>"><?=$volunteer["email"]?></a></td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				<?php } ?>
							
				<!-- Modal for New Volunteer -->
				<div class="modal fade" id="new-vol" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Volunteer Form</h4>
							</div>
							<div class="modal-body">
								<form id="new-vol-form" method="POST" action="../app/create-volunteer.php">
                                    <div class="form-group">
                                        <label for="fn" class="sr-only">First Name</label>
                                        <input class="form-control" type="text" id="fn" name="fn" placeholder="First Name" tabindex="1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle_name" class="sr-only">Middle Name</label>
                                        <input class="form-control" type="text" id="middle_name" name="middle_name" placeholder="Middle Name" tabindex="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="ln" class="sr-only">Last Name</label>
                                        <input class="form-control" type="text" id="ln" name="ln" placeholder="Last Name" tabindex="2" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="suffix" class="sr-only">Suffix</label>
                                        <input class="form-control" type="text" id="suffix" name="suffix" placeholder="Suffix" tabindex="2">
                                    </div>
									<div class="form-group">
										<label for="email" class="sr-only">Email Address *</label>
										<input class="form-control" type="text" id="email" name="email" placeholder="Email Address" tabindex="3" required>
									</div>
                                    <div class="form-group">
                                        <label for="phone" class="sr-only">Phone</label>
                                        <input class="form-control" id="phone" name="phone" placeholder="Phone" type="tel" tabindex="4" required>
                                    </div>
                                    <div class="form-group" required>
                                        <div class="dob">
                                            <input type='text'
                                                    class="form-control"
                                                    id="dob"
                                                    name="dob"
                                                    placeholder="Date of Birth (MM/DD/YYYY)"
                                                    tabindex="5"
                                                    maxlength="10"
                                                    data-validation="true"
                                                    data-validationtype="regex"
                                                    data-validationregex="(0?[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.]\d{2,4}"
                                                    data-validationmessage="Please be sure your date of birth is in the correct format.">
                                        </div>
                                    </div>
									<div class="form-group">
										<label for="skills" class="sr-only">Skills</label>
										<input class="form-control" type="text" id="skills" name="skills" placeholder="Skills" tabindex="5">
									</div>
									<div class="form-group">
										<label for="interests" class="sr-only">Interests</label>
										<input class="form-control" type="text" id="interests" name="interests" placeholder="Interests" tabindex="6">
									</div>
									<div class="form-group">
										<label for="availability" class="sr-only">Availability</label>
										<input class="form-control" id="availability" name="availability" placeholder="Availability" type="text" tabindex="7">
									</div>
									<div class="form-group">
										<label for="find-out-about-us" class="sr-only">How did you find out about us?</label>
										<textarea class="form-control" id="find_out_about_us" name="find_out_about_us" placeholder="How did you find out about us?" tabindex="8"></textarea>
									</div>

									<div class="row">
										<div class="col-md-10">
											<h4>Address Information</h4>
										</div>
									</div>
									<div class="form-group">
										<label for="street_one" class="sr-only">Address line 1</label>
										<input class="form-control" id="street_one" name="street_one" placeholder="Address line 1" tabindex="9" type="text" required>
									</div>
									<div class="form-group">
										<label for="street_two" class="sr-only">Address line 1</label>
										<input class="form-control" id="street_two" name="street_two" placeholder="Address line 2" tabindex="10" type="text">
									</div>
									<div class="form-group">
										<label for="city" class="sr-only">City</label>
										<input class="form-control" id="city" name="city" placeholder="City" tabindex="11" type="text" required>
									</div>
									<div class="form-group">
										<label for="state" class="sr-only">State</label>
										<select class="form-control" id="state" name="state" placeholder="State" required>
											<option value="">Please select a state...</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
									</div>
									<div class="form-group">
										<label for="zip" class="sr-only">Zip Code</label>
										<input class="form-control" id="zip" name="zip" placeholder="Zip Code" tabindex="13" type="number" maxlength="5"					
												oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
									</div>

									<div class="row">
										<div class="col-md-10">
											<h4>Emergency Contact</h4>
										</div>
									</div>
									<div class="form-group">
										<label for="ec_first_name" class="sr-only">First Name</label>
										<input class="form-control" id="ec_first_name" name="ec_first_name" placeholder="First Name" tabindex="14" type="text" required>
									</div>
									<div class="form-group">
										<label for="ec_last_name" class="sr-only">Last Name</label>
										<input class="form-control" id="ec_last_name" name="ec_last_name" placeholder="Last Name" tabindex="15" type="text" required>
									</div>
									<div class="form-group">
										<label for="ec_phone" class="sr-only">Phone</label>
										<input class="form-control" id="ec_phone" name="ec_phone" placeholder="Phone" type="tel" tabindex="16" required>
									</div>
									<div class="form-group hidden">
										<label for="email_dist">Add to email distribution</label>
										<input class="block" type="checkBox" id="email_dist" name="email_dist">
									</div>
									<button type="submit" class="form-control btn btn-success">Submit New Volunteer</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php
/////////////////////////////////////
		}
	}
	include_once '../footer.php';
?>