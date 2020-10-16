<?php
	include_once '../app/global.php';

	//	Header
	$page_title = "Reset Password";
	include_once '../header.php';

	//	Vars
	$email = "";
	$message = "";

	//	Logic
	if (isset($_GET['token']) && $_GET['token'] != "") {
		$token = $_GET['token'];
		if (isset($_POST['password-reset-submit'])) {
			if (isset($_POST['email'])) {
				$email = filter_var ( $_POST['email'], FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['password'])) {
				$password = filter_var ( $_POST['password'], FILTER_SANITIZE_STRING);
			}
			if (isset($_POST['password-confirm'])) {
				$password_confirm = filter_var ( $_POST['password-confirm'], FILTER_SANITIZE_STRING);
			}
			if ($email != "" && $password != "" && $password_confirm != "") {
				if ($password == $password_confirm) {
					$query_string = "SELECT id, username, password, reset_id FROM app_user WHERE username = ?";
					$user_results = $db->executeStatement($query_string,array($email))->fetchAll();
					if (count($user_results) > 0) {
						//	Check token
						foreach($user_results as $row) {
							if ($row['reset_id'] != "") {
								if ($token == $row['reset_id']) {
									$new_password_hash = password_hash($password, PASSWORD_BCRYPT);
									$query_string = "UPDATE app_user SET reset_id = ?, password = ? WHERE username = ?";			
									$db->executeStatement($query_string,array("",$new_password_hash,$email));
									$message .= "<p>Password reset successful! You may now <a href='".$login_url."'>log in</a>.</p>";
								}
							} else {
								$message .= "<p>Sorry, no password reset attempt was detected for this email address. You must first visit the <a href='".$login_url."'>login page</a> and click the 'Reset Password' link.</p>";
							}
						}
					} else {
						$message .= "<p>Sorry, the email you entered does not exist.</p>";
					}
				} else {
					$message .= "<p>Sorry, the passwords you entered do no match.</p>";
				}
			} else {
				$message .= "<p>Please fill out all fields</p>";
			}
		}	
	} else {
		$message = "<p>No token id detected. Please check the email you received and try again.</p>";
	}

	if ($message != "") {
		$message_class = "show-it";
	} else {
		$message_class = "hide-it";
	}
?>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 password-reset-form-wrap">
				<p class="text-center">Please verify your email and create a new password</p>
				<form id="password-reset-form" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="reset-id" value="<?=$_GET['token']?>">
					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" id="email" type="text" name="email" value="<?=$email?>">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" id="password" type="password" name="password">
					</div>
					<div class="form-group">
						<label for="password-confirm">Confirm Password</label>
						<input class="form-control" id="password-confirm" type="password" name="password-confirm">
					</div>
					<div class="row">
						<div class="form-group text-center">
							<input class="btn btn-primary" type="submit" name="password-reset-submit" value="Reset Password">
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-6 col-sm-offset-3 <?=$message_class?>">
				<div class="message text-center alert alert-warning">
					<?=$message?>
				</div>
			</div>
		</div>
<?php
	include_once '../footer.php';
?>