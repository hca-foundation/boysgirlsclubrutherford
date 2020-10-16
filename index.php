<?php
	include_once 'app/global.php';

	$page_title = "Welcome";
	include_once 'header.php';
?>
<div class="container">
	<div class="row">
		<div id="mission-statement" class="col-sm-push-2 col-sm-8 card text-center">
			<p><?=$GLOBALS['org_mission']?></p>
		</div>
	</div>
	<div class="row">
		<div class="volunteer-btns text-center col-sm-push-3 col-sm-6 col-xs-12">
			<a tabindex="1" href="<?=$root_dir?>/pages/sign-in.php" class="col-sm-3 form-control line-link success-link">Clock In</a>
			<a tabindex="2" href="<?=$root_dir?>/pages/sign-out.php" class="col-sm-3 form-control line-link">Clock Out</a>
		</div>
	</div>
	<div class="row">
		<div id="preferences" class="col-sm-push-3 col-sm-6 col-xs-12">
			<h4>Choose Location</h4>
			<div class="form-group">
				<label for="location" class="sr-only">Location *</label>
					<select tabindex="3" required class="form-control npcb-service" id="location" name="location" data-npcb-service="locations" data-npcb-callback="locationCallback">
						<option required disabled selected="true" value="">Please Choose A Location</option>
				</select>
			</div>
			<div class="form-group text-center">
				<div id="prefs-set" class="success text-success"></div>
				<div id="prefs-failed" class="danger text-danger"></div>
				<button role="button" tabindex="4" class="submit line-link form-control" onclick="setPreferences();"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Set Location Preference</button>
			</div>
		</div>
	</div><!-- /row -->
</div><!-- /container -->
<?php
	include_once 'footer.php';
?>