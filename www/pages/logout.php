<?php
	include_once '../app/global.php';
	include_once '../app/auth/token.php';

	$page_title = "Logout";
	
	AccessToken::clear();

	header("Location: " . $login_url);
?>