-- allergies row of patient table is not completely ready.
CREATE TABLE department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(100) NOT NULL UNIQUE,
	descrpt varchar(300) UNIQUE
);

CREATE TABLE doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	specialization varchar(50) NOT NULL,
	phone_num char(11) NOT NULL UNIQUE,
	email varchar(50) UNIQUE,
	doc_gender char(1),
	dept_id INT NULL,
	CONSTRAINT fk_docTdept FOREIGN KEY (dept_id)
	REFERENCES department(dept_id)
	ON UPDATE CASCADE ON DELETE SET NULL,
	CONSTRAINT chk_dr_gender CHECK (doc_gender = 'M' OR doc_gender = 'F')
);

CREATE TABLE doctor_schedule(
	schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	s_date DATE NOT NULL,
	s_time TIME NOT NULL,
	doctor_id INT,
	CONSTRAINT fk_schTdoc FOREIGN KEY (doctor_id)
	REFERENCES doctor(doctor_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE patient(
	patient_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	tc_no char(11) NOT NULL UNIQUE ,
	birth_date DATE,
	pat_gender char(1),
	blood_group char(3),
	allergies varchar(20), -- for now
	phone_num char(11) NOT NULL UNIQUE,
	email varchar(50) NOT NULL UNIQUE,
	pat_password varchar(70) NOT NULL,
	pat_role char(7),
	CONSTRAINT chk_pat_password_length CHECK(CHAR_LENGTH(pat_password) >= 8),
	CONSTRAINT chk_tc_no_length CHECK(CHAR_LENGTH(tc_no) = 11),
	CONSTRAINT chk_pat_gender CHECK(pat_gender = 'M' OR pat_gender = 'F'),
	CONSTRAINT chk_pat_blood_group CHECK (blood_group IN ('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')),
	CONSTRAINT chk_pat_role CHECK(pat_role IN ('ADMIN', 'PATIENT'))
);	

CREATE TABLE appointment(
	appointment_id INT PRIMARY KEY AUTO_INCREMENT,
	patient_id INT NOT NULL,
	schedule_id INT NOT NULL,
	ap_status varchar(10),
	CONSTRAINT fk_appTpat FOREIGN KEY (patient_id)
	REFERENCES patient(patient_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_appTsch FOREIGN KEY (schedule_id)
	REFERENCES doctor_schedule(schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT chk_ap_status CHECK(ap_status IN('ACTIVE', 'ABSENT', 'DONE'))
);

CREATE TABLE treatment(
	treatment_id INT PRIMARY KEY AUTO_INCREMENT,
	appointment_id INT NOT NULL,
	icd_code varchar(50) NOT NULL,
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
	ad_password varchar(50) NOT NULL,
	ad_role char(7),
	CONSTRAINT chk_admin_password_length CHECK(CHAR_LENGTH(ad_password) >= 8),
	CONSTRAINT chk_ad_role CHECK(ad_role IN('ADMIN', 'PATIENT'))
);