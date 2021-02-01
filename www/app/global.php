<?php
//////////////////////
// Checkin Page for Volunteers
// - Form POSTS to this page
//////////////////////

// setup autoloading
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/auth/token.php';

	// Error display

error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Load environment variables
	try {
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
		$dotenv->load();
	} catch (Exception $e) {
		// if one does not exist it will look for server vars
		// the production environment has these vars set
	}

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Organization Variables
	$GLOBALS['org_name'] = "Boys &amp; Girls Club of Rutherford County";
	$GLOBALS['org_mission'] = "Boys &amp; Girls Clubs of Rutherford County works to save and change the lives of children and teens, especially those who need us most, by providing a safe, positive, and engaging environment and programs that prepare and inspire them to achieve Great Futures. <br><br> Thanks for all you do! All of your volunteer work is greatly appreciated!";
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
	$GLOBALS['give_url'] = "https://www.bgcrc.net/campaigns/custom-donation/donate/";
	$GLOBALS['give_desc'] = "If you like what we do here at the Boys &amp; Girls Club of Rutherford County, please consider financially supporting our work!";
	$GLOBALS['sendgrid_api_key'] = getenv('SEND_GRID_KEY');

	// Environments
	$GLOBALS['protocol'] = $_SERVER['PROTOCOL'];
	$GLOBALS['prod_domain'] = "xxx";
	$GLOBALS['qa_domain'] = "zzz";
	$GLOBALS['dev_domain'] = $_SERVER['DEV_DOMAIN'];
	$GLOBALS['db_driver'] = $_SERVER['DB_DRIVER'];
	$GLOBALS['db_hostname'] = $_SERVER['DB_HOSTNAME'];	
	$GLOBALS['db_port'] = $_SERVER['DB_PORT'];	
	$GLOBALS['db_name'] = $_SERVER['DB_NAME'];
	$GLOBALS['db_user'] = $_SERVER['DB_USER'];
	$GLOBALS['db_password'] = $_SERVER['DB_PASSWORD'];
	$GLOBALS['sendgrid_api_key'] = $_SERVER['SEND_GRID_KEY'];
	$GLOBALS['logged_in_user'] = null;

	// Start the session
	session_start();

	// Setup the db
	include_once 'db-util.php';
	$db = new pdo_dblib_mssql();

	// set currently logged in user as global
	setUserFromToken();

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
	$ui_datetime_format = "m/d/Y g:i A";
	$ui_date_format = 'm/d/Y';
	// SQL Server Date format - 2016-11-14 14:00:00
	$sql_date_format = "Y-m-d g:i:s"; // 2016-10-13 07:00:00
	// Variables
	$root_dir = "";
	$dashboard_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/pages/dashboard.php";
	$login_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/pages/login.php";
	$logout_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/pages/logout.php";
	$signout_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/pages/sign-out.php";
	$current_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . $_SERVER['REQUEST_URI'];
	$referring_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/index.php";
	if (isset($_SERVER['HTTP_REFERER'])) {
		$referring_url = $_SERVER['HTTP_REFERER'];
	}
	$reset_url = $GLOBALS['protocol'] . "://".$GLOBALS['current_domain'] . $root_dir . "/pages/reset.php";

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

	// Helper methods for dealing with access token
	function setUserFromToken(): void {
		global $GLOBALS;

		$token = AccessToken::get();
		$username = !empty($token) ? $token['username'] : null;

		if (!empty($username)) {
			$user = getUserByUsername($username);

			if (!empty($user)) {
				$GLOBALS['logged_in_user'] = $user;
			}
		}
	}

	/**
	 * Gets app user from db by id
	 * @return array|null
	 */
	function getUserByUsername(string $username) {
		global $db;

		if (empty($username)) return null;

		$user_query = "SELECT * FROM app_user WHERE username = ?";
		$results = $db->executeStatement($user_query, [$username])->fetchAll();
		
		return count($results) > 0 ? $results[0] : null;
	}

	/**
	 * Returns true if user is logged in
	 */
	function isLoggedIn() : bool {
		return !empty($GLOBALS['logged_in_user']);
	}

	/**
	 * Returns full user payload from access token
	 * @return array|null
	 */
	function getLoggedInUser() {
		return !empty($GLOBALS['logged_in_user'])
			? $GLOBALS['logged_in_user']
			: null;
	}

	/**
	 * Returns volunteer id for logged in user
	 */
	function getLoggedInUserVolunteerId() {
		return !empty($GLOBALS['logged_in_user'])
			? $GLOBALS['logged_in_user']['volunteer_id']
			: null;
	}

	/**
	 * Gets active user id if set
	 */
	function getLoggedInUserId() {
		return !isset($GLOBALS['logged_in_user'])
			? $GLOBALS['logged_in_user']['id']
			: null;
	}

	/**
	 * Gets logged in user email if set
	 * @return string|null;
	 */
	function getLoggedInUserEmail() {
		return !empty($GLOBALS['logged_in_user'])
			? $GLOBALS['logged_in_user']['username']
			: null;
	}

	/**
	 * Gets logged in user type id
	 * @return string|null
	 */
	function getLoggedInUserTypeId() {
		return !empty($GLOBALS['logged_in_user'])
			? $GLOBALS['logged_in_user']['user_type_id']
			: null;
	}
?>