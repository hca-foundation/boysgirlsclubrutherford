<?php
	include_once '../app/global.php';

	$page_title = "Clock Out";
	include_once '../header.php';
?>

		<div class="col-xs-12">
			<div class="form-group col-md-12 col-xs-12 contribute">
				<a href="<?=$give_url?>" target="_blank" rel="noopener noreferrer">
					<button class="btn btn-lrg contribute-button card">
						<p class="title-text">THANK YOU SO MUCH FOR GIVING YOUR TIME!</p>
						<p class="sub-text"> <?=$give_desc?></p>
					</button>
				</a>
			</div>
		</div>
		<form class="container" id="sign-out-form">
			<div class="col-xs-12">
				<h1>Clock Out Form</h1>
			</div>
			<div class="col-xs-12">
				<div class="row">
					<?php if (!isLoggedIn()): ?>
						<div class="form-group col-md-12 col-xs-12">
							<label for="quick-sign-in-email" class="sr-only">Please enter your email</label>
							<input type="text" 
									class="form-control" 
									id="quick-sign-in-name" 
									name="email"
									autocomplete="on" 
									placeholder="Please enter your email" >
						</div>
					<?php endif; ?>
					<div class="form-group col-md-12 col-xs-12">
						<input type='text' class="form-control datetime-picker" id="signout-datetime-picker" data-format="yyyy-MM-dd hh:mm:00" name="signouttime" placeholder="MM/DD/YYYY 12:01 AM" />
					</div>
					<div class="form-group col-md-12 col-xs-12">
						<label for="feedback">Feedback</label>
						<textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="(I love <?=$org_short_name?>!)"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="danger" id="danger"></div>
					<div class="col-md-12 col-xs-12 text-center">
						<button class="sign-out line-link form-control" onclick="return signOut();">Clock Out</button>
					</div>
				</div>
			</div>
		</form>
<?php
	include_once '../footer.php';
?>