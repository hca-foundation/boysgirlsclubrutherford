<?php
	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<title><?=$page_title ?> | <?=$org_name?></title>
		<meta content="<?= $page_title ?> for <?=$org_name?> Volunteers" name="description">
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<meta name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOSNIPPET">

		<!-- Latest compiled and minified CSS -->
		<link href="<?=$root_dir?>/css/app.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	</head>
	<body class="home-page">
		<header>
			<div class="jumbotron">
				<div class="container">
					<?php if (isset($_SESSION['email'])) { ?>
						<div class="staff-log-out">
							<a href="<?=$root_dir?>/pages/logout.php">
								Log Out
							</a>
						</div>
					<?php } ?>
					<div class="hero-image">
						<a href="<?=$root_dir?>/index.php"><img src="<?=$root_dir?>/img/knockout-logo.png" title="<?=$org_name?> Logo"/></a>
					</div>
					<nav id="main-nav" role="navigation">
						<ul>
							<li>
								<a href="<?=$root_dir?>/pages/dashboard.php">
									Dashboard
								</a>
							</li>
							<li>
								<a href="<?=$root_dir?>/index.php" class="nav-signin-btn">
									Volunteer Clock In/Out
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<?php
			if(isset($_GET['message'])) {
				$special_msg = filter_var ( $_GET['message'], FILTER_SANITIZE_STRING);
				$message_class = "alert alert-danger";
				if (strrpos($special_msg, "uccess")) {
					$message_class = "alert alert-success";					
				}
		?>
			<div id="message-container" class="col-sm-12"><p class='<?=$message_class?>'><?=$special_msg?></p></div>
		<?php
			}
		?>