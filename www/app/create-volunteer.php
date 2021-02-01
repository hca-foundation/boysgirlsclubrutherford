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

    // Mark: CREATE VOLUNTEER
    // Make sure we have required values for a VOLUNTEER update
    if(!isset($_POST['fn'])) {
        $return_message = "Must provide first name for volunteer.";
    } elseif(!isset($_POST['ln'])) {
        $return_message = "Must provide last name for volunteer.";
    } elseif(!isset($_POST['middle_name'])) {
        $return_message = "Must provide middle name for volunteer.";
    } elseif(!isset($_POST['email'])) {
        $return_message = "Must provide email for volunteer.";
    } elseif(!isset($_POST['dob'])) {
        $return_message = "Must provide dob for volunteer.";
    } elseif(!isset($_POST['suffix'])) {
        $return_message = "Must provide suffix for volunteer.";
    } elseif(!isset($_POST['phone'])) {
        $return_message = "Must provide phone for volunteer.";
    } elseif(!isset($_POST['street_one'])) {
        $return_message = "Must provide street address for volunteer.";
    } elseif(!isset($_POST['city'])) {
        $return_message = "Must provide city for volunteer.";
    } elseif(!isset($_POST['state'])) {
        $return_message = "Must provide state for volunteer.";
    } elseif(!isset($_POST['zip'])) {
        $return_message = "Must provide zip for volunteer.";
    } elseif(!isset($_POST['ec_first_name'])) {
        $return_message = "Must provide emergency contact first name for volunteer.";
    } elseif(!isset($_POST['ec_last_name'])) {
        $return_message = "Must provide emergency contact last name for volunteer.";
    } elseif(!isset($_POST['ec_phone'])) {
        $return_message = "Must provide emergency contact phone for volunteer.";
    } else {
        // Sanitize Strings
        $vol_fn = filter_var($_POST['fn'], FILTER_SANITIZE_STRING);
        $vol_ln = filter_var($_POST['ln'], FILTER_SANITIZE_STRING);
        $vol_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $vol_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $vol_dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
        if (isset($vol_dob)) {
            $formatted_dob = date('Y-m-d', strtotime($vol_dob));
        }
        $vol_middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_STRING);
        $vol_suffix = filter_var($_POST['suffix'], FILTER_SANITIZE_STRING);

        // insert Volunteer
        $insert_volunteer_string = "INSERT INTO volunteer (email, first_name, last_name, dob, middle_name, suffix, phone)
                          VALUES ('" . $vol_email . "','" . $vol_fn . "','" . $vol_ln . "','" . $formatted_dob . "','" . $vol_middle_name . "','" . $vol_suffix . "','" . $vol_phone . "')";

        $createFailed = false;
        if ($db->executeStatement($insert_volunteer_string, [])) {
            // Success
            $return_message = "Successfully Created Volunteer!";
        } else {
            // Failure
            $return_message = "Sorry! Was unable to create the volunteer.";
            $createFailed = true;
        }

        // once we have inserted a Volunteer, we can add update the Volunteer, and insert a corresponding Address & Emergency Contact
        if (!$createFailed) {
            // get volunteer id
            $volunteer_id_query = "SELECT id FROM volunteer WHERE email = ?";
            $results = $db->executeStatement($volunteer_id_query, array($vol_email))->fetchAll();
            if (isset($results[0])) {
                $vol_id = $results[0]['id'];
            }

            $volunteerUpdated = false;
            $update_volunteer_string = "UPDATE volunteer
                            SET ";

            if (isset($_POST['skills'])) {
                $vol_skills = filter_var($_POST['skills'], FILTER_SANITIZE_STRING);
                $update_volunteer_string = $update_volunteer_string . "skills = '" . $vol_skills . "',";
                $volunteerUpdated = true;
            }
            if (isset($_POST['interests'])) {
                $vol_interests = filter_var($_POST['interests'], FILTER_SANITIZE_STRING);
                $update_volunteer_string = $update_volunteer_string . "interests = '" . $vol_interests . "',";
                $volunteerUpdated = true;
            }
            if (isset($_POST['availability'])) {
                $availability = filter_var($_POST['availability'], FILTER_SANITIZE_STRING);
                $update_volunteer_string = $update_volunteer_string . "availability = '" . $availability . "',";
                $volunteerUpdated = true;
            }
            if (isset($_POST['find_out_about_us'])) {
                $vol_find_out_about_us = filter_var($_POST['find_out_about_us'], FILTER_SANITIZE_STRING);
                $update_volunteer_string = $update_volunteer_string . "find_out_about_us = '" . $vol_find_out_about_us . "',";
                $volunteerUpdated = true;
            }
            if (isset($_POST['email_dist'])) {
                $email_dist = filter_var($_POST['email_dist'], FILTER_SANITIZE_STRING);
                if ($email_dist == 'on') {
                    $email_dist = 1;
                } else {
                    $email_dist = 0;
                }
                $update_volunteer_string = $update_volunteer_string . "include_email_dist = '" . $email_dist . "',";
                $volunteerUpdated = true;
            }

            $update_volunteer_string = substr($update_volunteer_string, 0, -1); // remove extra comma
            $update_volunteer_string = $update_volunteer_string . "WHERE id = " . $vol_id;


            // insert Address
            $vol_street_one = filter_var($_POST['street_one'], FILTER_SANITIZE_STRING);
            $vol_street_two = filter_var($_POST['street_two'], FILTER_SANITIZE_STRING);
            $vol_city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
            $vol_state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
            $vol_zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);
            // update address fields
            $addressSet = false;
            if (!empty($vol_street_one) && !empty($vol_city) && !empty($vol_state) && !empty($vol_zip)) {
                $addressSet = true;
            }
            $insert_address_string = "INSERT INTO address (volunteer_id, street_one, street_two, city, state, zip)
                          VALUES ('" . $vol_id . "','" . $vol_street_one . "','" . $vol_street_two . "','" . $vol_city . "','" . $vol_state . "','" . $vol_zip . "')";

            // insert Emergency Contact
            $ec_first_name = filter_var($_POST['ec_first_name'], FILTER_SANITIZE_STRING);
            $ec_last_name = filter_var($_POST['ec_last_name'], FILTER_SANITIZE_STRING);
            $ec_phone = filter_var($_POST['ec_phone'], FILTER_SANITIZE_STRING);

            // update emergency contact fields
            $ecSet = false;
            if (!empty($ec_first_name) && !empty($ec_last_name) && !empty($ec_phone)) {
                $ecSet = true;
            }
            $insert_ec_string = "INSERT INTO emergency_contact (volunteer_id, first_name, last_name, phone)
                          VALUES ('" . $vol_id . "','" . $ec_first_name . "','" . $ec_last_name . "','" . $ec_phone . "')";

            // update Volunteer table
            $updatedFailed = false;
            if ($db->executeStatement($update_volunteer_string, [])) {
                if ($addressSet) {
                    // insert to Address table
                    $db->executeStatement($insert_address_string, []);
                }
                if ($ecSet) {
                    // insert to Emergency Contact table
                    $db->executeStatement($insert_ec_string, []);
                }
            } else {
                $updatedFailed = true;
            }

            if ($updatedFailed) {
                $return_message = "Sorry! Was unable to create the volunteer.";
            }
        }
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