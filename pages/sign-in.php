<?php
	include_once '../app/global.php';
	
	$page_title = "Sign In";
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
?>
		<!-- Sign In -->
		<form class="container" id="sign-in-form">
			<div class="col-xs-12">
				<h1>
					Sign In Form
					<span class="req-field-warning-badge">
						<i class='glyphicon glyphicon-asterisk'></i> indicates a required field
					</span>
				</h1>
			</div>
		   
			<div class="col-xs-12">
				<div id="req-fields">
					<div id="returning-volunteer-not-found" class="clearfix wizard-section hidden new-sign-up">
						<div class="form-group col-md-12 col-xs-12">
							<span>Looks like you're new! Please fill out the form below to login as a new volunteer.</span>
						</div>
					</div>
					<div id="returning-volunteer-found" class="clearfix wizard-section hidden existing-sign-up">
						<div class="form-group col-md-12 col-xs-12">
							<span>We found you! Please complete checkin below.</span>
						</div>
					</div>
					<div class="danger"></div>
					<div class="row">
						<div class="form-group col-sm-8 col-xs-12">
							<label for="quick-sign-in-email" class="sr-only">Enter your email</label>
							<div class="input-group email">
								<input type="text" 
										class="form-control" 
										id="quick-sign-in-name" 
										name="email"
										autocomplete="on" 
										placeholder="Enter your email" 
										tabindex="1">
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
						<div class="form-group col-sm-4 col-xs-12 text-center">
							<button class="line-link form-control" tabindex="2" role="button" onclick="checkEmail();">Look Me Up</button>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="firstname" class="sr-only">First Name *</label>
							<div class="input-group first-name">
								<input required class="form-control" id="first-name" name="firstname" placeholder="First Name" type="text" tabindex="3">
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="lastname" class="sr-only">Last Name *</label>
							<div class="input-group last-name">
								<input required class="form-control" id="last-name" name="lastname" placeholder="Last Name" type="text" tabindex="4">
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 col-xs-12">
							<label for="location" class="sr-only">Location *</label>
							<div class="input-group location">
								<select required class="form-control" id="location" name="location" tabindex="5">
									<option required disabled selected="true" value="">Please Choose A Location</option>
									<?php
										foreach ($location_results as $row) {
											?>
												<option value="<?=$row['id']?>"><?=$row['location_name']?></option>
											<?php
										}
									?>
								</select>
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label for="task" class="sr-only">Volunteer Project Task *</label>
							<div class="input-group task">
								<select required class="form-control" id="task" name="task" tabindex="6">
									<option required disabled selected="true" value="">Please Select A Task</option>
									<?php
										foreach ($type_results as $row) {
											?>
												<option value="<?=$row['id']?>"><?=$row['job_type']?></option>
											<?php
										}
									?>
								</select>
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
					</div>
					<!-- Clock in Time needs to be disabled -->
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="input-group signin-time">
								<input type='text' class="form-control datetime-picker" id="signin-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signintime" placeholder="MM/DD/YYYY 12:01 AM" tabindex="7" />
								<span class='input-group-addon field-error'><i class='glyphicon glyphicon-asterisk'></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">					
				<!-- optional fields -->
				<div class="panel-group accordion" id="sign-in-opts-accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#sign-in-opts-accordion" href="#sign-in-opts" class="collapsed" tabindex="14"><i class="glyphicon glyphicon-plus"></i>Optional Information</a>
							</h4>
						</div>
						<div id="sign-in-opts" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row">
									<input type="hidden" name="include-email-dist" id="emailRadios1" value="0">
									<input type="hidden" name="community-service" checked id="communityRadios2" value="0">
								</div>
								<div class="row">
									<div class="form-group col-md-6 col-xs-12">
										<label for="affiliation" class="sr-only">Affiliation</label>
										<input class="form-control" id="affiliation" name="affiliation" placeholder="Affiliation, i.e. Company A, Organization B" type="text">
									</div>
									<div class="form-group col-md-6 col-xs-12">
										<label for="emergency" class="sr-only">Emergency Contact Phone Number</label>
										<input class="form-control" id="emergencynumber" placeholder="Emergency Contact Phone: xxx-xxx-xxxx" name="emergency-phone-number" type="text">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12 col-xs-12">
										<label for="skills" class="sr-only">Skills</label>
										<textarea class="form-control" id="skills" name="skills" rows="4" placeholder="Skills, i.e. Construction, Photography, Large Scale Cooking)"></textarea>
									</div>
									<div class="form-group col-md-12 col-xs-12">
										<label for="skills" class="sr-only">How did you find out about us?</label>
										<textarea class="form-control" id="find-out-about-us" name="find-out-about-us" rows="4" placeholder="How did you find out about us?"></textarea>
									</div>
								</div>
							</div>
						</div><!-- end sign in options -->
					</div><!-- end panel default -->
				</div><!-- end panel group -->
			</div><!-- end col-xs-12 -->

			<div class="col-xs-12">					
				<div class="row">
					<div class="col-md-12 col-xs-12 text-center">
						<div class="danger"></div>
						<button role="button" type="submit" class="submit line-link form-control" tabindex="15" onclick="return signIn();">Sign In</button>
					</div>
				</div>
			</div>
		</form>
<?php
	include_once '../footer.php';
?>