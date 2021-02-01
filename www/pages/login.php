<?php
	include_once '../app/global.php';
	require_once '../app/auth/token.php';

	//	Check if already logged in
	if (isLoggedIn()) {
		header("Location: " . $dashboard_url);
	} else {
		//	Globals
		$email = "";
		$password = "";
		$message = "";
		$reset_email = "";
		$login_class = "";
		$reset_class = "";

		//	LOGIN FORM SUBMITTED
		if (isset($_POST['login-submit'])) {
			//	If email is set
			if (isset($_POST['email']) && $_POST['email'] != "") {
				$email = filter_var ( $_POST['email'], FILTER_SANITIZE_STRING);
			}

			//	If all fields have been filled out
			if (isset($email) && isset($_POST['password']) && $_POST['password'] != "") {
				$email = filter_var ( $_POST['email'], FILTER_SANITIZE_STRING);
				$password = filter_var ( $_POST['password'], FILTER_SANITIZE_STRING);

				//	Check if user exists
				$query_string = "SELECT id, username, password, reset_id, user_type_id FROM app_user WHERE username = ?";
				$user_results = $db->executeStatement($query_string,array($email))->fetchAll();

				//	If email exists in the db, log in
				if (count($user_results) > 0) {
					foreach ($user_results as $row) {
						//	If reset id is set - they need to reset first
						if ($row['reset_id'] == "") {
							if (password_verify($password, $row['password'])) {
								AccessToken::set($row); // sets access token cookie with user payload
								header("Location: " . $dashboard_url);
							} else {
								$message .= "<p>Sorry, the password you entered is incorrect.</p>";
							}
						} else {
							$message .= "<p>Sorry, but it seems you have requested to reset your password. Your account will be locked until you create a new password. Please check your email and follow the instructions.</p>";
						}
					}
				} else {
					$message .= "<p>Sorry, either the email or password you entered are incorrect.</p>";
				}
			} else {
				$message .= "<p>Please fill out all fields</p>";
			}
		}

		//	PASSWORD RESET REQUESTED
		if (isset($_POST['reset-submit'])) {
			$login_class = "hide-it";
			//	If email is set
			if (isset($_POST['reset-email']) && $_POST['reset-email'] != "") {
				$reset_email = $_POST['reset-email'];
				//	Check if user exists
				$query_string = "SELECT id, username, password, reset_id FROM app_user WHERE username = ?";		
				$user_results = $db->executeStatement($query_string,array($reset_email))->fetchAll();
			
				//	Check if user exists in db, if so, send email with reset link
				if (count($user_results) > 0) {
					$token = bin2hex(openssl_random_pseudo_bytes(16));

					//	Insert password reset id into db
					$query_string = "UPDATE app_user SET reset_id = ? WHERE username = ?";		
					$db->executeStatement($query_string,array($token,$reset_email));
				
					//	Send email
					$subject = "Password Reset - ".$org_name;
					$txt = "Please follow the link to create a new password: <a href='".$reset_url."?token=".$token."'>".$reset_url."?token=".$token;
					$headers = "From: admin@".$org_url;
					
					$response = $email_util->sendEmail($reset_email, $subject, $txt);
					$message .= "<p>An email has been sent. Please check your email and follow the instructions to reset your password.</p><p style='display:none'>".$response."</p>";
				} else {
					$message .= "<p>Sorry, the email you entered does not exist.</p>";
				}
			} else {
				$message .= "<p>Please enter your email to reset password.</p>";
			}
		} else {
			$reset_class = "hide-it";
		}

		if ($message != "") {
			$message_class = "show-it";
		} else {
			$message_class = "hide-it";
		}

		// If here and not redirected, either initial login or login failed. Load the header.
		$page_title = "Login";
		include_once '../header.php';
?>

	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4 <?=$message_class?>">
				<div class="message text-center alert alert-warning">
					<?=$message?>
				</div>
			</div>
			<h1 class="text-center"><?=$page_title?></h1>
			<div class="col-sm-4 col-sm-offset-4 login-form-wrap <?=$login_class?>">
				<form id="login-form" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" id="email" type="text" name="email" value="<?=$email?>" required maxlength="200">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" id="password" type="password" name="password" required maxlength="200">
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<input class="btn btn-primary" type="submit" name="login-submit" value="Login">
						</div>
						<div class="form-group col-sm-6 text-right">
							<a class="reset-password" href="#">Reset Password</a>
						</div>
					</div>
				</form>
			</div>
			<div class="reset-password-wrap col-sm-6 col-sm-offset-3 <?=$reset_class?>">
				<p class="text-center">By clicking 'confirm', the email address entered (if valid)<br /> will be sent an email with a link to reset your password.</p>
				<form id="reset-password-form" class="row" method="POST" enctype="multipart/form-data">
					<div class="form-group col-sm-8">
						<label class="sr-only">Email</label>
						<input class="form-control" type="text" id="reset-email" name="reset-email" placeholder="Enter email address">
					</div>
					<div class="form-group col-sm-4">
						<input class="btn btn-primary btn-block" type="submit" name="reset-submit" value="Confirm">
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
		include_once '../footer.php';
	}
?>