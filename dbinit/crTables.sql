CREATE TABLE department(
	dept_id INT PRIMARY KEY AUTO_INCREMENT,
	dept_name varchar(20) NOT NULL UNIQUE,
	description varchar(50) UNIQUE
);

CREATE TABLE doctor(
	doctor_id INT PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(10) NOT NULL,
	last_name varchar(10) NOT NULL,
	specialization varchar(20) NOT NULL,
	phone_num char(11) NOT NULL,
	email varchar(15),
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
	tc_no char(11) NOT NULL CHECK(CHAR_LENGTH(tc_no) = 11),
	birth_date DATE,
	pat_gender char(1) CHECK(pat_gender = 'M' OR pat_gender = 'F'),
	blood_group CHAR(3) CHECK (blood_group IN ('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')),
	
