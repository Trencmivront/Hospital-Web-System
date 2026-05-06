-- renamed some attributes to escape keywords
CREATE TABLE Department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(100) NOT NULL UNIQUE,
	descrpt varchar(500) UNIQUE,
	img_path varchar(255)
);

CREATE TABLE Doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	phone_num varchar(11) NOT NULL UNIQUE,
	email varchar(50) UNIQUE,
	gender_name char(1) NULL,
	dept_id INT NULL,
	CONSTRAINT fk_docTdept FOREIGN KEY (dept_id)
	REFERENCES Department(dept_id)
	ON UPDATE CASCADE ON DELETE SET NULL
);

-- This is new table
CREATE TABLE Schedule(
	schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	s_date DATE NOT NULL,
	s_time TIME NOT NULL
);

-- Changed this table and made it connection table
CREATE TABLE Doctor_Schedule(
	doctor_schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	schedule_id INT NOT NULL,
	doctor_id INT NOT NULL,
	-- if it is false, then user can't select it
	is_active BOOLEAN NOT NULL,
	CONSTRAINT fk_dsTsch FOREIGN KEY (schedule_id)
	REFERENCES Schedule(schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_dsTdoc FOREIGN KEY (doctor_id)
	REFERENCES Doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

-- This is new table
CREATE TABLE Specialization(
	spec_id INT PRIMARY KEY AUTO_INCREMENT,
	name varchar(100) NOT NULL
);

CREATE TABLE Doctor_Specialization(
	doctor_spec_id INT PRIMARY KEY AUTO_INCREMENT,
	spec_id INT NOT NULL,
	doctor_id INT NOT NULL,
	CONSTRAINT fk_dspTdoc FOREIGN KEY (doctor_id)
	REFERENCES Doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_dspTspc FOREIGN KEY (spec_id)
	REFERENCES Specialization(spec_id)
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
	pat_password varchar(256) NOT NULL,
	-- usr_role will be given by database
	usr_role varchar(7) NOT NULL,
	CONSTRAINT chk_pat_password_length CHECK(LENGTH(pat_password) >= 8),
	CONSTRAINT chk_tc_no_length CHECK(LENGTH(tc_no) = 11),
	CONSTRAINT chk_pat_role CHECK(usr_role='PATIENT'),
	CONSTRAINT fk_patTbld FOREIGN KEY (blood_id)
	REFERENCES Blood_Type(blood_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

-- This is new table
CREATE TABLE Allergy(
	allergy_id INT PRIMARY KEY AUTO_INCREMENT,
	allergy_descrpt varchar(100) NOT NULL,
	icd10_code varchar(10) NOT NULL
);

-- This is new table
-- Here we have connection between patients and allergies
CREATE TABLE Patient_Allergy(
	patient_allergy_id INT PRIMARY KEY AUTO_INCREMENT,
	allergy_id INT NOT NULL,
	patient_id INT NOT NULL,
	CONSTRAINT fk_paTalr FOREIGN KEY (allergy_id)
	REFERENCES Allergy(allergy_id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_paTpat FOREIGN KEY (patient_id)
	REFERENCES Patient(patient_id)
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
	PRIMARY KEY (patient_id, punishment_id),
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
	doctor_schedule_id INT NOT NULL,
	-- Instead of writing multiple types of reasons,
	-- we can check reason on backend, reducing data need.CREATE TABLE treatment(
	treatment_id INT PRIMARY KEY AUTO_INCREMENT,
	appointment_id INT NOT NULL,
	icd10_code varchar(10) NOT NULL,
	CONSTRAINT fk_treTapp FOREIGN KEY (appointment_id)
	REFERENCES Appointment(appointment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bill(
	bill_id INT PRIMARY KEY AUTO_INCREMENT,
	treatment_id INT NOT NULL,
	cost DECIMAL(10, 2),
	CONSTRAINT fk_bilTtre FOREIGN KEY (treatment_id)
	REFERENCES Treatment(treatment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Admin(
	admin_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	ad_password varchar(256) NOT NULL,
	usr_role varchar(7) NOT NULL,
	CONSTRAINT chk_admin_password_length CHECK(LENGTH(ad_password) >= 8),
	CONSTRAINT chk_ad_role CHECK(usr_role='ADMIN')
);