<?php
	include_once '../app/global.php';

	$page_title = "Thank You";
	include_once '../header.php';
?>
		<div class="container thank-you text-center">
			<div class="row">
				<div class="col-xs-12">
					<h1>Thank you for volunteering with <?=$org_name?>!</h1>
					<p>This work is only possible when we do it together!</p>
					<div id="hours-worked" style="display:none;">
						<h3 id="total-hours">Total Hours Worked: <span id="hours"></span></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="back-to-home" class="col-xs-12">
					<a tabindex="1" href="../index.php" class="line-link form-control">Back to Home</a>
				</div>
			</div>
		</div>
<?php
	include_once '../footer.php';
?>