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
INSERT INTO dbo.event (id,event_name,event_date) VALUES (1,'General','2020-01-01')
SET IDENTITY_INSERT dbo.event OFF

-- Setup Default volunteers
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(1,'Shalonda','','Brown','','Shalonda.Brown@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(2,'Chelsey','','Curtis','','recruitment@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(3,'Jeremiah','D','Weeden-Wright','','jeremiah.weedenwright@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(4,'Carson','','Kuhl','','Carson.Kuhl@hcahealthcare.com','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(1,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(2,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(3,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(4,'107 N 1st','','Nashville','TN','37215');

INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(1,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(2,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(3,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(4,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Shalonda.Brown@bgcrc.net','tester', '2020-10-16',1,1,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('recruitment@bgcrc.net','tester', '2020-10-16',1,2,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2020-10-16',1,3,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Carson.Kuhl@hcahealthcare.com','tester', '2020-10-16',1,4,1);

SELECT * from dbo.location