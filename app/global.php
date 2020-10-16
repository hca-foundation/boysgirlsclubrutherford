<?php
//////////////////////
// Checkin Page for Volunteers
// - Form POSTS to this page
//////////////////////

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Organization Variables
	$GLOBALS['org_name'] = "Boys and Girls Club of Rutherford County";
	$GLOBALS['org_mission'] = "Mission statement goes here!";
	$GLOBALS['org_short_name'] = "BGCRC";
	$GLOBALS['org_url'] = "https://www.bgcrc.net/";
	$GLOBALS['org_domain'] = "bgcrc.net";
	$GLOBALS['org_address'] = "820 Jones Blvd";
	$GLOBALS['org_city_state'] = "Murfreesboro, TN 37129";
	$GLOBALS['org_phone'] = "(615) 893-5437";
	$GLOBALS['org_phone_tel'] = "6158935437";
//	$GLOBALS['liability_release'] = "I understand that as a volunteer for The Nashville Food Project I may be involved in physical activities that have a potential risk of injury. I assume this risk. I agree that I will perform activities that I am comfortable doing and follow instructions as provided. I hereby release and discharge The Nashville Food Project, its community service partners, officers, directors, employees,agents and volunteers from any claim, demand or cause of action that may be asserted by or on behalf of me as a result of my volunteering. I agree to be responsible for my behavior and to indemnify and hold harmless The Nashville Food Project, its community service partner, officers, directors, employees, agents and volunteers from any damages or liabilities arising out of my volunteer activities.";
//	$GLOBALS['health_release'] = "I understand that I may not volunteer in The Nashville Food Project's meals program if I have experienced a fever, sore throat, vomiting, diarrhea within the last 24 hours. By checking this box I agree that I have not experienced any of these symptoms in the last 24 hours.";
//	$GLOBALS['photo_release'] = "I grant The Nashville Food Project and its partners the irrevocable right to use photographs and video or audio recordings of me made while volunteering. I understand that I will not be compensated for the use of my image in any medium.";
	$GLOBALS['give_url'] = "https://www.bgcrc.net/other-ways-to-give/";
	$GLOBALS['give_desc'] = "Text explaining how/why to give.";
	$GLOBALS['sendgrid_api_key'] = getenv('SEND_GRID_KEY');

	// Environments
	$GLOBALS['protocol'] = "https";
	$GLOBALS['prod_domain'] = "xxx";
	$GLOBALS['qa_domain'] = "zzz";
	$GLOBALS['dev_domain'] = "bgcrc-signin-test.azurewebsites.net";
	$GLOBALS['db_hostname']= "bgcrc-signin-db.database.windows.net";	
	$GLOBALS['db_port'] = "1433";	
	$GLOBALS['db_name'] = getenv('DB_NAME');
	$GLOBALS['db_user'] = getenv('DB_USER');
	$GLOBALS['db_password'] = getenv('DB_PASSWORD');

	// Start the session
	session_start();

	// Setup the db
	include_once 'db-util.php';
	$db = new pdo_dblib_mssql();

	// Setup email
	include_once 'email-util.php';
	$email_util = new comm_builder_send_email();

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
	// Retrieve all form fields in POST
	date_default_timezone_set('America/Chicago'); // Set to CST
	// Standard PHP date format
	$date_format = "m-d-Y g:i A";
	// Format for reporting page dates
	$report_date_format = "Y-m-d";
	// UI date format - 02/07/2017 6:48 PM
	$ui_date_format = "m/d/Y g:i A";
	// SQL Server Date format - 2016-11-14 14:00:00
	$sql_date_format = "Y-m-d g:i:s"; // 2016-10-13 07:00:00
	// Variables
	$root_dir = "";
	$dashboard_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/dashboard.php";
	$login_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/login.php";
	$logout_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/logout.php";
	$signout_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/sign-out.php";
	$current_url = "https://".$GLOBALS['current_domain'] . $root_dir . $_SERVER['REQUEST_URI'];
	$referring_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/index.php";
	if (isset($_SERVER['HTTP_REFERER'])) {
		$referring_url = $_SERVER['HTTP_REFERER'];
	}
	$reset_url = "https://".$GLOBALS['current_domain'] . $root_dir . "/pages/reset.php";

	// Global Functions
	function calculateHours($in_time, $out_time) {			
		$hours = $out_time["hour"] - $in_time["hour"];
		if ($in_time["minute"] != $out_time["minute"]) {
			$minutes = (60 - $in_time["minute"]) + $out_time["minute"];
			// If the difference in minutes is negative, need to subtract 1 hour
			if ($out_time["minute"] - $in_time["minute"] < 0) {
				// Subtract an hour (less than an hour worked in minutes) 
				if ($hours > 0) {
					$hours = $hours - 1;
				}
				if ($minutes > 30) {
					$hours = $hours + 1;
				} else if ($minutes > 0) {
					$hours = $hours + .5;
				}
			} else {
				if ($minutes >= 30) {
					$hours = $hours + .5;
				}
			}
			
		}
		return $hours;
	}
?>