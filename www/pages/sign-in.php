<?php
	include_once '../app/global.php';
	
	$page_title = "Clock In";
	include_once '../header.php';

	// Pull locations
	$query_string = "SELECT id, location_name
						FROM location
						WHERE active = 1
						ORDER BY location_name";			
	$location_results = $db->executeStatement($query_string,[])->fetchAll();

	// Pull Job Types
	$query_string = "SELECT id, job_type
						FROM job_type
						WHERE active = 1
						ORDER BY job_type";
	$type_results = $db->executeStatement($query_string,[])->fetchAll();

	// Pull events
	$query_string = "SELECT id, event_name
						FROM event
						WHERE active = 1
						ORDER BY event_name";			
	$event_results = $db->executeStatement($query_string,[])->fetchAll();
?>
		<!-- Sign In -->
		<form class="container" id="sign-in-form">
			<div class="col-xs-12">
				<h1>Clock In Form</h1>
			</div>

			<div class="col-xs-12">			
				<div class="danger"></div>

				<?php if (!isLoggedIn()): ?>
					<div class="row">
						<div class="form-group col--8 md6 col-xs-12">
							<label for="quick-sign-in-email" class="sr-only">Enter your email</label>
							<div class="email">
								<input required 
										type="text" 
										class="form-control" 
										id="quick-sign-in-name" 
										name="email"
										autocomplete="on" 
										placeholder="Enter your email" 
										tabindex="1"
										data-validation="true"
										data-validationtype="regex"
										data-validationregex=".{1,}@[^.]{1,}"
										data-validationmessage="Please be sure your email is in the correct format.">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="firstname" class="sr-only">First Name *</label>
							<div class="first-name">
								<input required 
										class="form-control" 
										id="first-name" 
										name="firstname" 
										placeholder="First Name" 
										type="text" 
										tabindex="2"
										data-validation="true"
										data-validationtype="req"
										data-validationmessage="Please be sure to provide your first name.">
							</div>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="lastname" class="sr-only">Last Name *</label>
							<div class="last-name">
								<input required 
										class="form-control" 
										id="last-name" 
										name="lastname" 
										placeholder="Last Name" 
										type="text" 
										tabindex="3"
										data-validation="true"
										data-validationtype="req"
										data-validationmessage="Please be sure to provide your last name.">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<div class="phone">
								<input type='tel' 
										class="form-control" 
										id="phone" 
										name="phone" 
										placeholder="Phone number" 
										tabindex="4"
										data-validation="true"
										data-validationtype="regex"
										data-validationregex="\([0-9]{3}\)\s[0-9]{3}\-[0-9]{4}"
										data-validationmessage="Please be sure your phone is in the correct format.">
							</div>
						</div>
						<div class="form-group col-md-6 col-xs-12">
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
					</div>
				<?php endif; ?>

				<div class="row">
					<div class="form-group col-md-6 col-xs-12">
						<label for="location" class="sr-only">Location *</label>
						<div class="location">
							<select required 
										class="form-control" 
										id="location" 
										name="location" 
										tabindex="6"
										data-validation="true"
										data-validationtype="regex"
										data-validationregex="^[0-9]*$"
										data-validationmessage="Please be sure to choose a location.">
								<option required disabled selected="true" value="">Please Choose A Location</option>
								<?php
									foreach ($location_results as $row) {
										?>
											<option value="<?=$row['id']?>"><?=$row['location_name']?></option>
										<?php
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6 col-xs-12">
						<label for="task" class="sr-only">Volunteer Project Task *</label>
						<div class="task">
							<select required 
										class="form-control" 
										id="task" 
										name="task" 
										tabindex="7"
										data-validation="true"
										data-validationtype="regex"
										data-validationregex="^[0-9]*$"
										data-validationmessage="Please be sure to choose a task.">
								<option required disabled selected="true" value="">Please Select A Task</option>
								<?php
									foreach ($type_results as $row) {
										?>
											<option value="<?=$row['id']?>"><?=$row['job_type']?></option>
										<?php
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<!-- Clock in Time needs to be disabled -->
				<div class="row">
					<div class="col-md-6 col-xs-12 form-group">
						<div class="signin-time">
							<input type='text' 
									class="form-control datetime-picker" 
									id="signin-datetime-picker" 
									data-format="yyyy-MM-dd hh:mm:00" 
									name="signintime" 
									placeholder="MM/DD/YYYY 12:01 AM" 
									tabindex="8" 
									data-validation="true"
									data-validationtype="req"
									data-validationmessage="Please be sure to provide your clock in date and time."/>
						</div>
					</div>
					<div class="form-group col-md-6 col-xs-12">
						<label for="event" class="sr-only">Event *</label>
						<div class="event">
							<select required class="form-control" id="event" name="event" tabindex="9">
								<option required disabled selected="true">Please Choose An Event</option>
								<?php foreach ($event_results as $row): ?>
									<option value="<?= $row['id'] ?>"><?= $row['event_name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<?php if (!isLoggedIn()): ?>
					<div class="row">
						<div class="col-md-12">
							<h3>Address Information</h3>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="street_one" class="sr-only">Address line 1</label>
							<input class="form-control" id="street_one" name="street_one" placeholder="Address line 1" tabindex="9" type="text">
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="street_two" class="sr-only">Address line 1</label>
							<input class="form-control" id="street_two" name="street_two" placeholder="Address line 2" tabindex="10" type="text">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="city" class="sr-only">City</label>
							<input class="form-control" id="city" name="city" placeholder="City" tabindex="11" type="text">
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="state" class="sr-only">State</label>

							<select class="form-control" id="state" tabindex="12">
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
					</div>
					<div class="row">
						<div class="form-group col-md-12 col-xs-12">
							<label for="zip" class="sr-only">Zip Code</label>
							<input class="form-control" id="zip" name="zip" placeholder="Zip Code" tabindex="13" type="number" maxlength="5"					
								    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
						</div>
					</div>
						
					<div class="row">
						<div class="col-md-12">
							<h3>Emergency Contact</h3>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="ec_first_name" class="sr-only">First Name</label>
							<input class="form-control" id="ec_first_name" name="ec_first_name" placeholder="First Name" tabindex="14" type="text">
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="ec_last_name" class="sr-only">Last Name</label>
							<input class="form-control" id="ec_last_name" name="ec_last_name" placeholder="Last Name" tabindex="15" type="text">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12 col-xs-12">
							<label for="ec_phone" class="sr-only">Phone</label>
							<input class="form-control" id="ec_phone" name="ec_phone" placeholder="Phone" type="tel" tabindex="16">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<h3>Additional Information</h3>
						</div>
					</div>
					<div class="row">
						<input type="hidden" name="include-email-dist" id="emailRadios1" value="0">
						<input type="hidden" name="community-service" checked id="communityRadios2" value="0">
					</div>
					<div class="row">
						<div class="form-group col-md-12 col-xs-12">
							<label for="affiliation" class="sr-only">Affiliation</label>
							<input class="form-control" id="affiliation" name="affiliation" placeholder="Affiliation, i.e. Company A, Organization B" type="text" tabindex="17">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12 col-xs-12">
							<label for="skills" class="sr-only">Skills</label>
							<textarea class="form-control" id="skills" name="skills" rows="4" placeholder="Skills, i.e. Construction, Photography, Large Scale Cooking)" tabindex="18"></textarea>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label for="skills" class="sr-only">How did you find out about us?</label>
							<textarea class="form-control" id="find-out-about-us" name="find-out-about-us" rows="4" placeholder="How did you find out about us?" tabindex="19"></textarea>
						</div>
					</div>
				<?php endif; ?>

			</div><!-- end col-xs-12 -->

			<div class="col-xs-12">					
				<div class="row">
					<div class="col-md-12 col-xs-12 text-center">
						<div class="danger"></div>
						<button role="button" type="submit" class="submit line-link form-control" tabindex="20" onclick="return signIn();">Clock In</button>
					</div>
				</div>
			</div>
		</form>
<?php
	include_once '../footer.php';
?>