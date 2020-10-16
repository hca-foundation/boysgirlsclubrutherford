-- BGCRC Database
-- Drop Tables to Start
IF OBJECT_ID('dbo.volunteer_period', 'U') IS NOT NULL DROP TABLE dbo.volunteer_period
IF OBJECT_ID('dbo.feedback', 'U') IS NOT NULL DROP TABLE dbo.feedback
IF OBJECT_ID('dbo.address', 'U') IS NOT NULL DROP TABLE dbo.address
IF OBJECT_ID('dbo.emergency_contact', 'U') IS NOT NULL DROP TABLE dbo.emergency_contact
IF OBJECT_ID('dbo.volunteer', 'U') IS NOT NULL DROP TABLE dbo.volunteer
IF OBJECT_ID('dbo.event', 'U') IS NOT NULL DROP TABLE dbo.event
IF OBJECT_ID('dbo.app_user', 'U') IS NOT NULL DROP TABLE dbo.app_user
IF OBJECT_ID('dbo.user_type', 'U') IS NOT NULL DROP TABLE dbo.user_type
IF OBJECT_ID('dbo.job_type', 'U') IS NOT NULL DROP TABLE dbo.job_type
IF OBJECT_ID('dbo.location', 'U') IS NOT NULL DROP TABLE dbo.location

-- Create Tables
CREATE TABLE dbo.job_type (
	id int NOT NULL IDENTITY(1,1),
	job_type varchar(100) NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_job_type PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_job_type ON dbo.job_type (job_type)

CREATE TABLE dbo.location (
	id int NOT NULL IDENTITY(1,1),
	location_name varchar(100) NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_location PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_location_name ON dbo.location (location_name)

CREATE TABLE dbo.event (
	id int NOT NULL IDENTITY(1,1),
	event_name varchar(100) NOT NULL,
	event_date datetime NOT NULL,
	CONSTRAINT PK_event PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_event ON dbo.event (event_name)

CREATE TABLE dbo.user_type (
	id int NOT NULL IDENTITY(1,1),
	user_type varchar(100) NOT NULL,
	CONSTRAINT PK_user_type PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_user_type ON dbo.user_type (user_type)

CREATE TABLE dbo.volunteer (
	id int NOT NULL IDENTITY(1,1),
	first_name varchar(100) NOT NULL,
	middle_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	suffix varchar(10) NOT NULL,
	email varchar(255) NOT NULL,
	phone varchar(15) NOT NULL,
	dob datetime NOT NULL,
	skills varchar(8000) NULL,
	interests varchar(8000) NULL,
	availability varchar(255) NULL,
	find_out_about_us varchar(255) NULL,
	include_email_dist bit NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_volunteer PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_volunteer_email ON dbo.volunteer (email)

CREATE TABLE dbo.address (
	volunteer_id int NOT NULL,
	street_one varchar(255) NOT NULL,
	street_two varchar(255) NULL,
	city varchar(100) NOT NULL,
	state varchar(2) NOT NULL,
	zip int NOT NULL,
	CONSTRAINT PK_address PRIMARY KEY (volunteer_id),
	CONSTRAINT FK_address_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE CASCADE ON UPDATE CASCADE
)

CREATE TABLE dbo.emergency_contact (
	volunteer_id int NOT NULL,
	first_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	phone varchar(15) NOT NULL,
	CONSTRAINT PK_emergency_contact PRIMARY KEY (volunteer_id),
	CONSTRAINT FK_emergency_contact_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE CASCADE ON UPDATE CASCADE
)

CREATE TABLE dbo.feedback (
	id int NOT NULL IDENTITY(1,1),
	volunteer_id int NULL,
	feedback varchar(8000) NULL,
	CONSTRAINT PK_feedback PRIMARY KEY (id),
	CONSTRAINT FK_feedback_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE NO ACTION ON UPDATE NO ACTION
)

CREATE TABLE dbo.volunteer_period (
	id int NOT NULL IDENTITY(1,1),
	check_in_time datetime NOT NULL,
	check_out_time datetime NULL DEFAULT (NULL),
	hours decimal(3,1) NULL DEFAULT (NULL),
	affiliation varchar(100) NULL DEFAULT (NULL),
	health_release int NOT NULL,
	photo_release int NOT NULL,
	liability_release int NOT NULL,
	first_time int NOT NULL,
	job_type_id int NOT NULL,
	location_id int NOT NULL,
	event_id int NOT NULL,
	community_service_hours int NULL DEFAULT (NULL),
	volunteer_id int NOT NULL,
	feedback_id int NULL,
	CONSTRAINT PK_volunteer_period PRIMARY KEY (id),
	CONSTRAINT FK_volunteer_period_jobtype FOREIGN KEY (job_type_id) REFERENCES dbo.job_type(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_location FOREIGN KEY (location_id) REFERENCES dbo.location(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_feedback FOREIGN KEY (feedback_id) REFERENCES dbo.feedback(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_event FOREIGN KEY (event_id) REFERENCES dbo.event(id) ON DELETE CASCADE ON UPDATE CASCADE
)

-- USER TABLE
CREATE TABLE dbo.app_user (
	id int NOT NULL IDENTITY(1,1),
	username varchar(200) NOT NULL,
	password varchar(200) NOT NULL,
	date_added datetime NOT NULL,
	reset_id varchar(200) NULL,
	user_type_id int NOT NULL,
	volunteer_id int NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_app_user PRIMARY KEY(id),
	CONSTRAINT FK_app_user_user_type FOREIGN KEY (user_type_id) REFERENCES dbo.user_type(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_app_user_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE CASCADE ON UPDATE CASCADE
)
CREATE UNIQUE INDEX UQ_users ON dbo.app_user (username)