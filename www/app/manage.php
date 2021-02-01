<?php
	// Logic for ALL Management Pages
	include_once 'global.php';
	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		//////////////////////
		// Manage Page for Staff
		// - Forms POST to this page
		//////////////////////

		// Error display
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$return_message = "";

		// Only process if email was passed
		if(isset($_POST['type'])) {
			$manage_type = $_POST['type'];


////////////////////////////////////////////////////				
// MANAGE VOLUNTEER
// - TEST: type=volunteer-period&vol-id=1&signintime=03/15/2018 1:30 PM&signouttime=03/15/2018 3:30 PM&location=7&task=1&organization=HCA
			if ($manage_type == "volunteer") {
				// Make sure we have required values for a VOLUNTEER update
				if(!isset($_POST['fn'])) {
					$return_message = "Must provide first name for volunteer.";
				} elseif(!isset($_POST['ln'])) {
					$return_message = "Must provide last name for volunteer.";
				} elseif(!isset($_POST['email'])) {
					$return_message = "Must provide email for volunteer.";
				} else				
					// Sanitize Strings
					$vol_id = filter_var ( $_POST['vol-id'], FILTER_SANITIZE_STRING);
					$vol_fn = filter_var ( $_POST['fn'], FILTER_SANITIZE_STRING);
					$vol_ln = filter_var ( $_POST['ln'], FILTER_SANITIZE_STRING);
					$vol_email = filter_var ( $_POST['email'], FILTER_SANITIZE_STRING);

					// Update String Query
					$update_string = "UPDATE volunteer
										SET email = '".$vol_email."'
											,first_name = '".$vol_fn."'
											,last_name = '".$vol_ln."'";

					// Optional fields
					if(isset($_POST['dob'])) {
						$vol_dob = filter_var ( $_POST['dob'], FILTER_SANITIZE_STRING);
						$formatted_dob = date('Y-m-d', strtotime($vol_dob));
						$update_string = $update_string . ",dob = '".$formatted_dob."'";
	   				}
					if(isset($_POST['phone'])) {
						$vol_phone = filter_var ( $_POST['phone'], FILTER_SANITIZE_STRING);
						$update_string = $update_string . ",phone = '".$vol_phone."'";
	   				}
					if(isset($_POST['skills'])) {
						$vol_skills = filter_var ( $_POST['skills'], FILTER_SANITIZE_STRING);
						$update_string = $update_string . ",skills = '".$vol_skills."'";
	   				}
					if(isset($_POST['interests'])) {
						$vol_interests = filter_var ( $_POST['interests'], FILTER_SANITIZE_STRING);
						$update_string = $update_string . ",interests = '".$vol_interests."'";
	   				}
					if(isset($_POST['availability'])) {
						$vol_availability = filter_var ( $_POST['availability'], FILTER_SANITIZE_STRING);
						$update_string = $update_string . ",availability = '".$vol_availability."'";
	   				}
					if(isset($_POST['email_dist'])) {
						$vol_email_dist = filter_var ( $_POST['email_dist'], FILTER_SANITIZE_STRING);
						$update_string = $update_string . ",include_email_dist = '".$vol_email_dist."'";
	   				} 
					$update_string = $update_string . "WHERE id = ".$vol_id;

                    // update address fields
                    $addressUpdated = false;
                    $update_address_string = "UPDATE address
                                                SET ";
                    if(isset($_POST['street_one'])) {
                        $vol_street_one = filter_var ( $_POST['street_one'], FILTER_SANITIZE_STRING);
                        $update_address_string = $update_address_string . "street_one = '".$vol_street_one."',";
                        $addressUpdated = true;
                    }
                    if(isset($_POST['street_two'])) {
                        $vol_street_two = filter_var ( $_POST['street_two'], FILTER_SANITIZE_STRING);
                        $update_address_string = $update_address_string . "street_two = '".$vol_street_two."',";
                        $addressUpdated = true;
                    }
                    if(isset($_POST['city'])) {
                        $vol_city = filter_var ( $_POST['city'], FILTER_SANITIZE_STRING);
                        $update_address_string = $update_address_string . "city = '".$vol_city."',";
                        $addressUpdated = true;
                    }
                    if(isset($_POST['state'])) {
                        $vol_state = filter_var ( $_POST['state'], FILTER_SANITIZE_STRING);
                        $update_address_string = $update_address_string . "state = '".$vol_state."',";
                        $addressUpdated = true;
                    }
                    if(isset($_POST['zip'])) {
                        $vol_zip = filter_var ( $_POST['zip'], FILTER_SANITIZE_STRING);
                        $update_address_string = $update_address_string . "zip = '".$vol_zip."',";
                        $addressUpdated = true;
                    }
                    $update_address_string = substr($update_address_string, 0, -1); // remove extra comma
                    $update_address_string = $update_address_string . " WHERE volunteer_id = ".$vol_id;

                    // update emergency contact fields
                    $ecUpdated = false;
                    $update_ec_string = "UPDATE emergency_contact
                                                    SET ";
                    if(isset($_POST['ec_first_name'])) {
                        $ec_first_name = filter_var ( $_POST['ec_first_name'], FILTER_SANITIZE_STRING);
                        $update_ec_string = $update_ec_string . "first_name = '".$ec_first_name."',";
                        $ecUpdated = true;
                    }
                    if(isset($_POST['ec_last_name'])) {
                        $ec_last_name = filter_var ( $_POST['ec_last_name'], FILTER_SANITIZE_STRING);
                        $update_ec_string = $update_ec_string . "last_name = '".$ec_last_name."',";
                        $ecUpdated = true;
                    }
                    if(isset($_POST['ec_phone'])) {
                        $ec_phone = filter_var ( $_POST['ec_phone'], FILTER_SANITIZE_STRING);
                        $update_ec_string = $update_ec_string . "phone = '".$ec_phone."',";
                        $ecUpdated = true;
                    }
                    $update_ec_string = substr($update_ec_string, 0, -1); // remove extra comma
                    $update_ec_string = $update_ec_string . " WHERE volunteer_id = ".$vol_id;

					// update Volunteer table
                    $updatedFailed = false;
                    if ($db->executeStatement($update_string,[])) {
                        if ($addressUpdated) {
                            // update Address table
                            if ($db->executeStatement($update_address_string,[])) {
                                if ($ecUpdated) {
                                    // update Emergency Contact table
                                    if ($db->executeStatement($update_ec_string,[])) {
										$return_message = "Successfully Updated Volunteer!";
                                    } else {
                                        $updatedFailed = true;
                                    }
                                }
                            } else {
                                $updatedFailed = true;
                            }
                        }
                    } else {
                        $updatedFailed = true;
                    }

                    if ($updatedFailed) {
                        $return_message = "Sorry! Was unable to update the volunteer.";
                    }

////////////////////////////////////////////////////				
// MANAGE VOLUNTEER PERIOD
// - TEST: type=volunteer-period&vol-id=1&signintime=03/15/2018 1:30 PM&signouttime=03/15/2018 3:30 PM&location=7&task=1&organization=HCA

			} elseif ($manage_type == "volunteer-period") {
				// Make sure we have required values for a VOLUNTEER PERIOD UPDATE
				if(!isset($_POST['vol-period-id'])) {
					$return_message = "Volunteer period id was not provided.";
				} elseif(!isset($_POST['signintime'])) {
					$return_message = "Sign in time was not provided.";
				} elseif(!isset($_POST['signouttime'])) {
					$return_message = "Sign out time was not provided.";
				} elseif(!isset($_POST['location'])) {
					$return_message = "Location id was not provided.";
				} elseif(!isset($_POST['task'])) {
					$return_message = "Task id was not provided.";
				} elseif(!isset($_POST['organization'])) {
					$return_message = "Organization was not provided.";
				} else {
					// Sanitize Strings
					$vol_period_id = filter_var ( $_POST['vol-period-id'], FILTER_SANITIZE_STRING);
					$signin_datetime = filter_var ( $_POST['signintime'], FILTER_SANITIZE_STRING);
					$signout_datetime = filter_var ( $_POST['signouttime'], FILTER_SANITIZE_STRING);
					$location_id = filter_var ( $_POST['location'], FILTER_SANITIZE_STRING);
					$task_id = filter_var ( $_POST['task'], FILTER_SANITIZE_STRING);
					$organization = filter_var ( $_POST['organization'], FILTER_SANITIZE_STRING);					
					
					// Format Dates
					$signin_date = date_parse_from_format ( $ui_datetime_format , $signin_datetime );
					$sign_in_time = $signin_date["year"] . "-" . $signin_date["month"] . "-" . $signin_date["day"] 
										. " " . $signin_date["hour"] . ":" . $signin_date["minute"] .":00";
					$signout_date = date_parse_from_format ( $ui_datetime_format , $signout_datetime );
					$sign_out_time = $signout_date["year"] . "-" . $signout_date["month"] . "-" . $signout_date["day"] 
										. " " . $signout_date["hour"] . ":" . $signout_date["minute"] .":00";

					// Update value in volunteer period
					$hours = calculateHours($signin_date, $signout_date);
					if ($hours < 0) {						
						?>For the date <?= $sign_out_time ?>, it looks like you didn't sign out after your <?= $sign_in_time ?> sign in.  We need  you to sign out of that day after the sign in time. Thanks!. <span class='hidden'>ERROR: Signing out on a day where they did not sign in.</span></p><?php 						
					} else {
						// Update String Query
						$update_string = "UPDATE volunteer_period
											SET check_out_time = '".$sign_out_time."'
												,hours = '".$hours."'
												,check_in_time = '".$sign_in_time."'
												,affiliation = '".$organization."'
												,job_type_id = '".$task_id."'
												,location_id = '".$location_id."'
										  	WHERE id = ".$vol_period_id;
						if ($db->executeStatement($update_string,[])) {
							// Success
							$return_message = "Successfully Updated Volunteer Period!";
						} else {
							// Failure
							$return_message = "Sorry! Was unable to update the volunteer period.";
						}
					}
				}
			
///////////////////////////////////////////////////				
// MANAGE LOCATION
			} elseif ($manage_type == "location") {
				// Make sure we have required values for a Location change 
				if(!isset($_POST['loc-name']) || $_POST['loc-name'] == "") {
					$return_message = "Location name was not provided.";
				} elseif(!isset($_POST['loc-id']) || $_POST['loc-id'] == "") {
					$return_message = "Location id was not provided.";
				} else {
					// Sanitize Strings
					$location_id = filter_var ( $_POST['loc-id'], FILTER_SANITIZE_STRING);
					$location_name = filter_var ( $_POST['loc-name'], FILTER_SANITIZE_STRING);
					// Determine if this is create or update
					if ($location_id == "new") {
						// Update String Query
						$update_type = "create";
						$update_string = "INSERT INTO location (location_name)
											VALUES ('".$location_name."')";
					} else {
						// Update String Query
						$update_type = "update";
						$update_string = "UPDATE location
											SET location_name = '".$location_name."' WHERE id = ".$location_id;
					}					
					if ($db->executeStatement($update_string,[])) {
						// Success
						$return_message = "Successfully ".$update_type."d location!";
					} else {
						// Failure
						$return_message = "Sorry! Was unable to ".$update_type." the location.";
					}
				}

///////////////////////////////////////////////////				
// MANAGE TASK / JOB TYPE
			} elseif ($manage_type == "job_type") {
				// Make sure we have required values for a Task change 
				if(!isset($_POST['task-name']) || $_POST['task-name'] == "") {
					$return_message = "Task name was not provided.";
				} elseif(!isset($_POST['task-id']) || $_POST['task-id'] == "") {
					$return_message = "Task id was not provided.";
				} else {
					// Sanitize Strings
					$task_id = filter_var ( $_POST['task-id'], FILTER_SANITIZE_STRING);
					$task_name = filter_var ( $_POST['task-name'], FILTER_SANITIZE_STRING);
					// Determine if this is create or update
					if ($task_id == "new") {
						// Update String Query
						$update_type = "create";
						$update_string = "INSERT INTO job_type (job_type)
											VALUES ('".$task_name."')";
					} else {
						// Update String Query
						$update_type = "update";
						$update_string = "UPDATE job_type
											SET job_type = '".$task_name."'
											WHERE id = ".$task_id;
					}					
					if ($db->executeStatement($update_string,[])) {
						// Success
						$return_message = "Successfully ".$update_type."d task!";
					} else {
						// Failure
						$return_message = "Sorry! Was unable to ".$update_type." the task.";
					}
				}
///////////////////////////////////////////////////				
// MANAGE EVENT
			} else if ($manage_type === 'event') {
				// Make sure we have required values for a Task change 
				if (!isset($_POST['event-name']) || $_POST['event-name'] == "") {
					$return_message = "Task name was not provided.";
				} elseif (!isset($_POST['event-date']) || $_POST['event-date'] == "") {
					$return_message = "Task id was not provided.";
				} else {
					$event_id = filter_var($_POST['event-id'], FILTER_SANITIZE_STRING);
					$event_name = filter_var($_POST['event-name'], FILTER_SANITIZE_STRING);
					$event_date = filter_var($_POST['event-date'], FILTER_SANITIZE_STRING);
					$formatted_date = date('Y-m-d H:i:s', strtotime($event_date));
					if ($event_id === 'new') {
						$event_query = "INSERT INTO event (event_name, event_date, active) VALUES ('$event_name', '$formatted_date', 1)";
					} else {
						$event_query = "UPDATE event SET event_name = '$event_name', event_date = '$formatted_date' WHERE id = $event_id";
					}
					
					if ($db->executeStatement($event_query, [])) {
						$return_message = 'Successfullly created event';
					} else {
						$return_message = 'Uh oh, we encountered a problem saving your event.';
					}
				}
///////////////////////////////////////////////////				
// MANAGE ACTIVATE / DEACTIVATE
			} elseif ($manage_type == "activate" || $manage_type == "deactivate") {
				if(!isset($_POST['id']) || $_POST['id'] == "") {
					$return_message = "Item id was not provided.";
				} elseif(!isset($_POST['item-type']) || $_POST['item-type'] == "") {
					$return_message = "Item type was not provided.";
				} else {
					// Sanitize Strings
					$item_id = filter_var ( $_POST['id'], FILTER_SANITIZE_STRING);
					$item_type = filter_var ( $_POST['item-type'], FILTER_SANITIZE_STRING);
					$is_active = 1;
					$message = "Successfully Activated Item!";
					if ($manage_type == "deactivate") {
						$is_active = 0;
						$message = "Successfully Deactivated Item!";
					}
					
					// Update String Query
					$update_string = "UPDATE ".$item_type.
										" SET active = ".$is_active." WHERE id = ".$item_id;					
					if ($db->executeStatement($update_string,[])) {
						// Success
						$return_message = $message;
					} else {
						// Failure
						$return_message = "Sorry! Was unable to update the item.";
					}
				}
			} else {
				$return_message = "Sorry! You requested an unsupported action/type (type requested was $manage_type).";
			}			
		} else {
			$return_message = "Sorry! There was an issue with the action/type you attempted to take.";
		}
		if (strrpos($referring_url, "?")) {
			if (strrpos($referring_url, "&message=")) {
				// Message already in alert, remove and replace
				$referring_url = preg_replace('/message=.*/', "message=".$return_message, $referring_url);
				header("Location: " . $referring_url);
			} else {
				header("Location: " . $referring_url . "&message=".$return_message);	
			}
		} else {
			header("Location: " . $referring_url . "?message=".$return_message);			
		}
	}
?>