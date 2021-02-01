-- Test Volunteer and Intern
INSERT INTO volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(21,'Intern','','VonTern','','jeremiah.weedenwright+1@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(22,'Volunteer','','McVol','','jeremiah.weedenwright+2@gmail.com','615-111-1111','20000101','','','','',1,1);

-- Setup Addresses
INSERT INTO address (volunteer_id, street_one,street_two,city,state,zip) VALUES(21,'101 N 1st','','Nashville','TN','37215');
INSERT INTO address (volunteer_id, street_one,street_two,city,state,zip) VALUES(22,'105 N 1st','','Nashville','TN','37215');

-- Setup Emergency Contacts
INSERT INTO emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(21,'Emergency','Contact','615-333-3333');
INSERT INTO emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(22,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+1@gmail.com','tester', '2020-10-16',3,21,1);
INSERT INTO app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+2@gmail.com','tester', '2020-10-16',4,22,1);

-- 'Intern' Periods - 10/12 - 10/26
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-12 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-13 11:00:30.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);

-- 'Volunteer' Periods - 10/14 - 10/28
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 2, 3, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 5, 3, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 2, 2, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 6, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 1, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 2, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-28 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 3, 2, 1, NULL, 22, NULL);
INSERT INTO volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-29 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 3, 1, 1, NULL, 22, NULL);
