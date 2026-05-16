-- renamed some attributes to escape keywords
CREATE TABLE Department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(100) NOT NULL UNIQUE,
	descrpt varchar(500) UNIQUE,
	img_path varchar(255)
);

-- This is new table
CREATE TABLE Specialization(
	spec_id INT PRIMARY KEY AUTO_INCREMENT,
	name varchar(100) NOT NULL UNIQUE
);

CREATE TABLE Doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	phone_num varchar(11) NOT NULL UNIQUE,
	email varchar(50) UNIQUE,
	gender_name char(1) NULL,
	dept_id INT NULL,
	spec_id INT NOT NULL,
	img_path varchar(200), 
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	CONSTRAINT chk_doctor_gender_name CHECK (gender_name IN ('F', 'M')),
	CONSTRAINT fk_docTdept FOREIGN KEY (dept_id)
	REFERENCES Department(dept_id)
	ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT fk_docTspec FOREIGN KEY (spec_id)
	REFERENCES Specialization(spec_id)
	ON UPDATE CASCADE ON DELETE RESTRICT
);

-- This is new table
CREATE TABLE Schedule(
	schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	s_date DATE NOT NULL,
	s_time TIME NOT NULL,
	UNIQUE(s_date, s_time)
);

-- Changed this table and made it connection table
CREATE TABLE Doctor_Schedule(
	doctor_schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	schedule_id INT NOT NULL,
	doctor_id INT NOT NULL,
	-- if it is false, then user can't select it
	is_active BOOLEAN NOT NULL,
	UNIQUE(doctor_id, schedule_id),
	CONSTRAINT fk_dsTsch FOREIGN KEY (schedule_id)
	REFERENCES Schedule(schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_dsTdoc FOREIGN KEY (doctor_id)
	REFERENCES Doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

-- This is new table
CREATE TABLE Blood_Type(
	blood_id INT PRIMARY KEY AUTO_INCREMENT,
	type_name varchar(3) NOT NULL UNIQUE
);

CREATE TABLE Patient(
	patient_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	tc_no varchar(11) NOT NULL UNIQUE ,
	birth_date DATE NOT NULL,
	gender_name char(1) NOT NULL,
	-- create a selection for this
	blood_id INT NOT NULL,
	-- allergies INT, removed allergies and created connection below
	phone_num varchar(11) NOT NULL UNIQUE,
	email varchar(50) NOT NULL UNIQUE,
	is_email_verified BOOLEAN,
	pat_password varchar(256) NOT NULL,
	-- usr_role will be given by database
	usr_role varchar(7) NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	CONSTRAINT chk_patient_gender_name CHECK (gender_name IN ('F', 'M')),
	CONSTRAINT chk_tc_no_length CHECK(LENGTH(tc_no) = 11),
	CONSTRAINT chk_pat_role CHECK(usr_role='PATIENT'),
	CONSTRAINT fk_patTbld FOREIGN KEY (blood_id)
	REFERENCES Blood_Type(blood_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Punishment(
	punishment_id INT PRIMARY KEY AUTO_INCREMENT,
	reason varchar(300) NOT NULL,
	for_days INT NOT NULL
);

CREATE TABLE Patient_Punishment(
	-- by using the date, we will check if punishment is old or new.
	punishment_date DATE NOT NULL,
	patient_id INT NOT NULL,
	punishment_id INT NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	PRIMARY KEY (patient_id, punishment_id, punishment_date),
	CONSTRAINT fk_pat_pun_to_pat FOREIGN KEY (patient_id)
	REFERENCES Patient(patient_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_pat_pun_to_pun FOREIGN KEY (punishment_id)
	REFERENCES Punishment(punishment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Appointment(
	appointment_id INT PRIMARY KEY AUTO_INCREMENT,
	patient_id INT NOT NULL,
	doctor_schedule_id INT NOT NULL UNIQUE,
	ap_status varchar(10) NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	CONSTRAINT fk_appTpat FOREIGN KEY (patient_id)
	REFERENCES Patient(patient_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_appTdos FOREIGN KEY (doctor_schedule_id)
	REFERENCES Doctor_Schedule(doctor_schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT chk_appointment_status CHECK(ap_status IN ('ACTIVE', 'CLOSED', 'COMPLETED', 'ABSENT'))
);

CREATE TABLE Treatment(
	treatment_id INT PRIMARY KEY AUTO_INCREMENT,
	appointment_id INT NOT NULL,
	icd10_code varchar(10) NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL ,
	CONSTRAINT fk_treTapp FOREIGN KEY (appointment_id)
	REFERENCES Appointment(appointment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bill(
	bill_id INT PRIMARY KEY AUTO_INCREMENT,
	treatment_id INT NOT NULL,
	cost DECIMAL(10, 2),
	is_paid BOOL NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	CONSTRAINT fk_bilTtre FOREIGN KEY (treatment_id)
	REFERENCES Treatment(treatment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Admin(
	admin_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	ad_password varchar(256) NOT NULL,
	usr_role varchar(7) NOT NULL,
	update_date DATE NOT NULL,
	update_time TIME NOT NULL,
	CONSTRAINT chk_ad_role CHECK(usr_role='ADMIN')
);
