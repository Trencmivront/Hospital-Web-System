-- don't use, not ready
-- I needed to change some names because they were reserved.
CREATE TABLE department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(20) NOT NULL UNIQUE,
	descrpt varchar(50) UNIQUE
);

CREATE TABLE doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(10) NOT NULL,
	last_name varchar(10) NOT NULL,
	specialization varchar(20) NOT NULL,
	phone_num char(11) UNIQUE NOT NULL,
	email varchar(15) UNIQUE,
	doc_gender char(1) CHECK (doc_gender = 'M' OR doc_gender = 'F'),
	dept_id INT NULL,
	CONSTRAINT fk_docTdept FOREIGN KEY (dept_id)
	REFERENCES department(dept_id)
	ON UPDATE CASCADE
	ON DELETE SET NULL
);

CREATE TABLE doctor_schedule(
	schedule_id INT PRIMARY KEY AUTO_INCREMENT,
	s_date DATE NOT NULL,
	s_time TIME NOT NULL,
	doctor_id INT,
	CONSTRAINT fk_schTdoc FOREIGN KEY (doctor_id)
	REFERENCES doctor(doctor_id)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);

CREATE TABLE patient(
	patient_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(10) NOT NULL,
	last_name varchar(10) NOT NULL,
	tc_no char(11) UNIQUE NOT NULL CHECK(CHAR_LENGTH(tc_no) = 11),
	birth_date DATE,
	pat_gender char(1) CHECK(pat_gender = 'M' OR pat_gender = 'F'),
	blood_group CHAR(3) CHECK (blood_group IN ('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')),
	allergies ?,
	phone_num char(11) UNIQUE NOT NULL,
	email varchar(15) UNIQUE NOT NULL,
	pat_password varchar(8) NOT NULL,
	pat_role char(7) CHECK(role IN ('ADMIN', 'PATIENT')),
	CONSTRAINT chk_password_length CHECK(CHAR_LENGTH(pat_password) >= 8)
);	

CREATE TABLE appointment(
	appointment_id INT PRIMARY KEY AUTO_INCREMENT,
	patient_id INT NOT NULL,
	schedule_id INT NOT NULL,
	ap_status varchar(10) CHECK(status IN('ACTIVE', 'ABSENT', 'DONE'),
	CONSTRAINT fk_appTpat FOREIGN KEY patient_id REFERENCES patient(patient_id)
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_appTsch FOREIGN KEY schedule_id REFERENCES doctor_schedule(schedule_id)
	ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE treatment(
	treatment_id INT PRIMARY KEY AUTO_INCREMENT,
	appointment_id INT NOT NULL,
	icd_code varchar(10) NOT NULL,
	CONSTRAINT fk_treTapp FOREIGN KEY appointment_id REFERENCES appointment(appointment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bill(
	bill_id INT PRIMARY KEY AUTO_INCREMENT,
	treatment_id INT NOT NULL,
	cost DECIMAL(10, 2),
	CONSTRAINT fk_bilTtre FOREIGN KEY treatment_id REFERENCES treatment(treatment_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE admin(
	admin_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(10) NOT NULL,
	ad_password varchar(8) NOT NULL,
	ad_role char(7) CHECK(role IN('ADMIN', 'PATIENT')),
	CONSTRAINT chk_password_length CHECK(CHAR_LENGTH(pt_password) >= 8)
)