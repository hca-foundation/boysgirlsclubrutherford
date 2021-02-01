-- DATA IMPORT
SET IDENTITY_INSERT dbo.location ON
INSERT INTO dbo.location (id,location_name,active) VALUES (1,'Murfreesboro',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (2,'Shelbyville',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (3,'Smyrna',1);
SET IDENTITY_INSERT dbo.location OFF

SET IDENTITY_INSERT dbo.job_type ON
INSERT INTO dbo.job_type (id,job_type,active) VALUES (1,'General',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (2,'Web / IT',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (3,'One-Time Special Event',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (4,'LRC (Learning Resource Center)',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (5,'Kid&#39;s Cafe',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (6,'Internship',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (7,'Fundraiser',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (8,'Teen Center',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (9,'Gamesroom',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (10,'Arts',1);
SET IDENTITY_INSERT dbo.job_type OFF

SET IDENTITY_INSERT dbo.user_type ON
INSERT INTO dbo.user_type (id,user_type) VALUES (1,'admin');
INSERT INTO dbo.user_type (id,user_type) VALUES (2,'staff');
INSERT INTO dbo.user_type (id,user_type) VALUES (3,'intern');
INSERT INTO dbo.user_type (id,user_type) VALUES (4,'volunteer');
SET IDENTITY_INSERT dbo.user_type OFF

-- Default Event for all regular volunteers
SET IDENTITY_INSERT dbo.event ON
INSERT INTO dbo.event (id,event_name,event_date,active) VALUES (1,'General','2020-01-01',1);
SET IDENTITY_INSERT dbo.event OFF

-- Setup Default volunteers - Staff and Devs
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(1,'Shalonda','','Brown','','Shalonda.Brown@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(2,'Chelsey','','Curtis','','recruitment@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(3,'Jeremiah','D','Weeden-Wright','','jeremiah.weedenwright@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(4,'Carson','','Kuhl','','Carson.Kuhl@hcahealthcare.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(5,'Emily','','Collins','','emily.collins@infoworks-tn.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(6,'Raja','','Karnati','','raja.karnati@hcahealthcare','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(7,'Adam','','Alvis','','aalvis@deloitte','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(8,'Kishan','','Patel','','kpatel@genospace','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(9,'Karla','','Ramirez','','kramirezmal@gmail','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

-- Setup Staff and Dev Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(1,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(2,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(3,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(4,'107 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(5,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(6,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(7,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(8,'107 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(9,'101 N 1st','','Nashville','TN','37215');

-- Setup Staff and Dev Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(1,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(2,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(3,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(4,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(5,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(6,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(7,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(8,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(9,'Emergency','Contact','615-333-3333');

-- Setup Staff Dev admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Shalonda.Brown@bgcrc.net','tester', '2020-10-16',1,1,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('recruitment@bgcrc.net','tester', '2020-10-16',1,2,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2020-10-16',1,3,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Carson.Kuhl@hcahealthcare.com','tester', '2020-10-16',1,4,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('emily.collins@infoworks-tn.com','tester', '2020-10-16',1,5,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('raja.karnati@hcahealthcare.com','tester', '2020-10-16',1,6,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('aalvis@deloitte.com','tester', '2020-10-16',1,7,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('kpatel@genospace.com','tester', '2020-10-16',1,8,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('kramirezmal@gmail.com','tester', '2020-10-16',1,9,1);

-- Setup Volunteers/Interns
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(10,'Jonathan','','Beverly','','jbeverly@beverlypropertiestn.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(11,'Sarah','','Burchyett','','sarah.burchyett@hcahealthcare.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(12,'Suzanne','','Eubank','','dwseubank@comcast.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(13,'Cheri','','Frame','','cheri.j.frame@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(14,'Yolanda','','Greene','','ygreene@ftb.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(15,'Mekayla','','Hartsell','','kayhartsell@att.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(16,'William','','Hickman','','william.b.hickman@icloud.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(17,'James','','Lakes','','jlakes@vmware.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(18,'Sonya','','Leeman','','leemanfamily@comcast.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(19,'Melinda','','Mallette','','melindamallette@me.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(20,'Celeste','','Middleton','','celeste.middleton.gm1r@statefarm.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(21,'Lisa','','Moore','','lisadmoore57@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(22,'Sharron','','Northern','','Sharron.Northern@genmills.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(23,'Betty','','Oliver','','beege9000@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(24,'Mike','','Panesi','','mpanesi@redfcu.org','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(25,'Jimmy','','Pitts','','jwptdp7055@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(26,'Dwight','','Robinson','','trobin15@wm.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(27,'Harold','','Segroves','','haroldsegroves@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(28,'Tanya','','Singh','','tsingh02@comcast.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(29,'Valerie','','Smith','','valerie@wrightrehab.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(30,'Patrick','','Snipes','','patrick_snipes@comcast.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(31,'Brian','','Sullivan','','Brians2001@att.net','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(32,'Richard','','Thomas','','thomasrc556@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(33,'Julie','','Thure','','juliethure@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(34,'Rebecca','','Upton','','RUpton@dvf-pllc.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(35,'Gina','','Urban','','ginawurban@gmail.com','111-111-1111','19900101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active)	
	VALUES(36,'Marta','','Van Hoose','','marta_van_hoose@sbcglobal.net','111-111-1111','19900101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

-- Setup Volunteer / Intern Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(10,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(11,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(12,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(13,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(14,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(15,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(16,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(17,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(18,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(19,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(20,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(21,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(22,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(23,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(24,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(25,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(26,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(27,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(28,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(29,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(30,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(31,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(32,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(33,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(34,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(35,'802 Jones Blvd','','Murfreesboro','TN','37129');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(36,'802 Jones Blvd','','Murfreesboro','TN','37129');

-- Setup Volunteer / Intern Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(10,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(11,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(12,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(13,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(14,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(15,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(16,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(17,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(18,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(19,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(20,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(21,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(22,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(23,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(24,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(25,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(26,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(27,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(28,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(29,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(30,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(31,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(32,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(33,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(34,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(35,'REPLACE','ME','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(36,'REPLACE','ME','615-333-3333');

-- Setup Volunteer / Intern admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jbeverly@beverlypropertiestn.com','tester','2021-01-04',4,10,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('sarah.burchyett@hcahealthcare.com','tester','2021-01-04',4,11,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('dwseubank@comcast.net','tester','2021-01-04',4,12,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('cheri.j.frame@gmail.com','tester','2021-01-04',4,13,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('ygreene@ftb.com','tester','2021-01-04',4,14,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('kayhartsell@att.net','tester','2021-01-04',3,15,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('william.b.hickman@icloud.com','tester','2021-01-04',4,16,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jlakes@vmware.com','tester','2021-01-04',4,17,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('leemanfamily@comcast.net','tester','2021-01-04',4,18,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('melindamallette@me.com','tester','2021-01-04',4,19,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('celeste.middleton.gm1r@statefarm.com','tester','2021-01-04',4,20,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('lisadmoore57@gmail.com','tester','2021-01-04',4,21,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Sharron.Northern@genmills.com','tester','2021-01-04',4,22,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('beege9000@gmail.com','tester','2021-01-04',4,23,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('mpanesi@redfcu.org','tester','2021-01-04',4,24,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jwptdp7055@gmail.com','tester','2021-01-04',4,25,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('trobin15@wm.com','tester','2021-01-04',4,26,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('haroldsegroves@gmail.com','tester','2021-01-04',4,27,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('tsingh02@comcast.net','tester','2021-01-04',4,28,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('valerie@wrightrehab.com','tester','2021-01-04',4,29,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('patrick_snipes@comcast.net','tester','2021-01-04',4,30,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Brians2001@att.net','tester','2021-01-04',4,31,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('thomasrc556@gmail.com','tester','2021-01-04',4,32,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('juliethure@gmail.com','tester','2021-01-04',4,33,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('RUpton@dvf-pllc.com','tester','2021-01-04',4,34,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('ginawurban@gmail.com','tester','2021-01-04',4,35,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('marta_van_hoose@sbcglobal.net','tester','2021-01-04',4,36,1);

/* TESTING DATA
-- Insert Test Intern
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(100,'Intern','','VonTern','','jeremiah.weedenwright+1@gmail.com','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF
-- Setup Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(100,'101 N 1st','','Nashville','TN','37215');
-- Setup Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(100,'Emergency','Contact','615-333-3333');
-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+1@gmail.com','tester', '2020-10-16',3,100,1);

-- Insert Vol and Intern Data
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(21,'Intern','','VonTern','','jeremiah.weedenwright+1@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(22,'Volunteer','','McVol','','jeremiah.weedenwright+2@gmail.com','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

-- Setup Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(21,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(22,'105 N 1st','','Nashville','TN','37215');

-- Setup Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(21,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(22,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+1@gmail.com','tester', '2020-10-16',3,21,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+2@gmail.com','tester', '2020-10-16',4,22,1);

-- Setup Volunteer Periods
-- 'Intern' Periods - 10/12 - 10/26
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-12 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-13 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 12:30:00.0', '2020-10-12 14:00:30.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);

-- 'Volunteer' Periods - 10/14 - 10/28
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 2, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 5, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 2, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 6, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 11:00:00.0', '2020-10-12 14:00:00.0', 3, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 12:30:00.0', '2020-10-12 14:30:00.0', 4, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 10:00:00.0', '2020-10-12 12:00:00.0', 2, NULL, 1, 1, 1, 0, 10, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-28 12:00:00.0', '2020-10-12 16:00:00.0', 4, NULL, 1, 1, 1, 0, 3, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-29 11:30:00.0', '2020-10-12 16:00:00.0', 5.5, NULL, 1, 1, 1, 0, 3, 1, 1, NULL, 22, NULL);
	*/