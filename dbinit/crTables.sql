-- renamed some attributes to escape keywords
CREATE TABLE department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(100) NOT NULL UNIQUE,
	descrpt varchar(300) UNIQUE
);

-- This is new table
-- Only contains male or female
CREATE TABLE gender(
	gender_name varchar(7) PRIMARY KEY,
	CONSTRAINT chk_gender_name CHECK (gender_name='female' OR gender_name='male')
);

CREATE TABLE doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	phone_num varchar(11) NOT NULL UNIQUE,
	email varchar(50) UNIQUE,
	gender_name varchar(6) NULL,
	dept_id INT NULL,
	CONSTRAINT fk_docTdept FOREIGN KEY (dept_id)
	REFERENCES department(dept_id)
	ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT fk_docTgen FOREIGN KEY (gender_name)
	REFERENCES gender(gender_name)
	ON UPDATE CASCADE ON DELETE CASCADE
);

-- This is new table
CREATE TABLE schedule(
	schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	s_date DATE NOT NULL,
	s_time TIME NOT NULL
);

-- Changed this table and made it connection table
CREATE TABLE doctor_schedule(
	doctor_schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	schedule_id INT NOT NULL,
	doctor_id INT NOT NULL,
	-- if it is false, then user can't select it
	is_active BOOLEAN NOT NULL,
	CONSTRAINT fk_dsTsch FOREIGN KEY (schedule_id)
	REFERENCES schedule(schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_dsTdoc FOREIGN KEY (doctor_id)
	REFERENCES doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

-- This is new table
CREATE TABLE specialization(
	spec_id INT PRIMARY KEY AUTO_INCREMENT,
	name varchar(100) NOT NULL
);

CREATE TABLE doctor_specialization(
	doctor_spec_id INT PRIMARY KEY AUTO_INCREMENT,
	spec_id INT NOT NULL,
	doctor_id INT NOT NULL,
	CONSTRAINT fk_dspTdoc FOREIGN KEY (doctor_id)
	REFERENCES doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_dspTspc FOREIGN KEY (spec_id)
	REFERENCES specialization(spec_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE patient(
	patient_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	tc_no varchar(11) NOT NULL UNIQUE ,
	birth_date DATE,
	gender_name varchar(6),
	-- create a selection for this
	blood_group varchar(3),
	-- allergies INT, removed allergies and created connection below
	phone_num varchar(11) NOT NULL UNIQUE,
	email varchar(50) NOT NULL UNIQUE,
	pat_password varchar(256) NOT NULL,
	-- usr_role will be given by database
	usr_role varchar(7) NOT NULL,
	CONSTRAINT chk_pat_password_length CHECK(LENGTH(pat_password) >= 8),
	CONSTRAINT chk_tc_no_length CHECK(LENGTH(tc_no) = 11),
	CONSTRAINT chk_pat_blood_group CHECK (blood_group IN ('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')),
	CONSTRAINT chk_pat_role CHECK(usr_role='PATIENT'),
	CONSTRAINT fk_patTgen FOREIGN KEY (gender_name)
	REFERENCES gender(gender_name)
	ON DELETE CASCADE ON UPDATE CASCADE
);	

-- This is new table
CREATE TABLE allergy(
	allergy_id INT PRIMARY KEY AUTO_INCREMENT,
	allergy_descrpt varchar(100) NOT NULL,
	icd10_code varchar(10) NOT NULL
);

-- This is new table
-- Here we have connection between patients and allergies
CREATE TABLE patient_allergy(
	patient_allergy_id INT PRIMARY KEY AUTO_INCREMENT,
	allergy_id INT NOT NULL,
	patient_id INT NOT NULL,
	CONSTRAINT fk_paTalr FOREIGN KEY (allergy_id)
	REFERENCES allergy(allergy_id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_paTpat FOREIGN KEY (patient_id)
	REFERENCES patient(patient_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE appointment(
	appointment_id INT PRIMARY KEY AUTO_INCREMENT,
	patient_id INT NOT NULL,
	doctor_schedule_id INT NOT NULL,
	-- Instead of writing multiple types of reasons,
	-- we can check reason on backend, reducing data need.
	ap_status BOOLEAN NOT NULL,
	CONSTRAINT fk_appTpat FOREIGN KEY (patient_id)
	REFERENCES patient(patient_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_appTsch FOREIGN KEY (doctor_schedule_id)
	REFERENCES doctor_schedule(doctor_schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE treatment(
	treatment_id INT PRIMARY KEY AUTO_INCREMENT,
	appointment_id INT NOT NULL,
	icd10_code varchar(10) NOT NULL,
	CONSTRAINT fk_treTapp FOREIGN KEY (appointment_id)
	REFERENCES appointment(appointment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bill(
	bill_id INT PRIMARY KEY AUTO_INCREMENT,
	treatment_id INT NOT NULL,
	cost DECIMAL(10, 2),
	CONSTRAINT fk_bilTtre FOREIGN KEY (treatment_id)
	REFERENCES treatment(treatment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE admin(
	admin_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(50) NOT NULL,
	ad_password varchar(256) NOT NULL,
	usr_role varchar(7) NOT NULL,
	CONSTRAINT chk_admin_password_length CHECK(LENGTH(ad_password) >= 8),
	CONSTRAINT chk_ad_role CHECK(usr_role='ADMIN')
);