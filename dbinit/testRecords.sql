-- Test records for Hospital Web System
-- This file erases existing data and populates tables with comprehensive test cases.

-- Disable foreign key checks to truncate/delete safely
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE Bill;
TRUNCATE TABLE Treatment;
TRUNCATE TABLE Appointment;
TRUNCATE TABLE Doctor_Schedule;
TRUNCATE TABLE Schedule;
TRUNCATE TABLE Doctor;
TRUNCATE TABLE Specialization;
TRUNCATE TABLE Department;
TRUNCATE TABLE Patient_Punishment;
TRUNCATE TABLE Punishment;
TRUNCATE TABLE Patient_Allergy;
TRUNCATE TABLE Allergy;
TRUNCATE TABLE Patient;
TRUNCATE TABLE Blood_Type;
TRUNCATE TABLE Admin;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Blood_Type (All common types)
INSERT INTO Blood_Type (type_name) VALUES
('A+'), ('A-'), ('B+'), ('B-'), ('AB+'), ('AB-'), ('0+'), ('0-');

-- 2. Department
INSERT INTO Department (dept_name, descrpt, img_path) VALUES
('Cardiology', 'Specializing in heart and cardiovascular health.', 'imgs/deptImgs/cardiology.jpg'),
('Neurology', 'Diagnosis and treatment of nervous system disorders.', 'imgs/deptImgs/neurology.jpg'),
('Orthopedics', 'Focusing on the musculoskeletal system.', 'imgs/deptImgs/orthopedics.jpg'),
('Pediatrics', 'Comprehensive medical care for children and adolescents.', 'imgs/deptImgs/pediatrics.jpg'),
('Dermatology', 'Skin, hair, and nail health.', 'imgs/deptImgs/dermatology.jpg'),
('Ophthalmology', 'Specialized eye care and surgery.', 'imgs/deptImgs/ophthalmology.jpg'),
('General Surgery', 'Focusing on abdominal contents and general surgical procedures.', 'imgs/deptImgs/surgery.jpg'),
('Psychiatry', 'Mental health diagnosis and treatment.', 'imgs/deptImgs/psychiatry.jpg');

-- 3. Specialization
INSERT INTO Specialization (name) VALUES
('Interventional Cardiology'),
('Electrophysiology'),
('Epileptology'),
('Pediatric Neurology'),
('Spine Surgery'),
('Sports Medicine'),
('Neonatology'),
('Pediatric Surgery'),
('Cosmetic Dermatology'),
('Retinal Surgery'),
('Vascular Surgery'),
('Child Psychiatry');

-- 4. Allergy
INSERT INTO Allergy (allergy_descrpt, icd10_code) VALUES
('Penicillin', 'Z88.0'),
('Sulfa drugs', 'Z88.2'),
('Aspirin', 'Z88.1'),
('Peanuts', 'Z91.010'),
('Latex', 'Z91.040'),
('Shellfish', 'Z91.013'),
('Bee Stings', 'Z91.06'),
('Pollen', 'Z91.05'),
('Dairy', 'Z91.011'),
('Eggs', 'Z91.012');

-- 5. Punishment
INSERT INTO Punishment (reason, for_days) VALUES
('Repeated appointment no-show', 15),
('Late cancellation (less than 2 hours)', 7),
('Disruptive behavior in facility', 30),
('False patient information', 60);

-- 6. Schedule (Dates in the future relative to 2026-05-10)
INSERT INTO Schedule (s_date, s_time) VALUES
('2026-05-11', '09:00:00'), ('2026-05-11', '09:30:00'), ('2026-05-11', '10:00:00'), ('2026-05-11', '10:30:00'),
('2026-05-11', '14:00:00'), ('2026-05-11', '14:30:00'), ('2026-05-11', '15:00:00'),
('2026-05-12', '09:00:00'), ('2026-05-12', '10:00:00'), ('2026-05-12', '11:00:00'),
('2026-05-12', '14:00:00'), ('2026-05-12', '15:00:00'),
('2026-05-13', '09:00:00'), ('2026-05-13', '09:30:00'), ('2026-05-13', '10:00:00');

-- 7. Admin
-- Password requirement: length >= 8
INSERT INTO Admin (username, ad_password, usr_role) VALUES
('admin_root', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN'), -- password
('hospital_mgr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN');

-- 8. Doctor
INSERT INTO Doctor (first_name, last_name, phone_num, email, gender_name, dept_id, spec_id, img_path) VALUES
('Ahmet', 'Yilmaz', '05550000001', 'ahmet.yilmaz@nova.com', 'M', 1, 1, NULL),
('Ayse', 'Kaya', '05550000002', 'ayse.kaya@nova.com', 'F', 2, 3, NULL),
('Mehmet', 'Demir', '05550000003', 'mehmet.demir@nova.com', 'M', 3, 5, NULL),
('Zeynep', 'Celik', '05550000004', 'zeynep.celik@nova.com', 'F', 4, 7, NULL),
('Mustafa', 'Sahin', '05550000005', 'mustafa.sahin@nova.com', 'M', 5, 9, NULL),
('Elif', 'Ozturk', '05550000006', 'elif.ozturk@nova.com', 'F', 6, 10, NULL),
('Murat', 'Aydin', '05550000007', 'murat.aydin@nova.com', 'M', 7, 11, NULL),
('Fatma', 'Arslan', '05550000008', 'fatma.arslan@nova.com', 'F', 8, 12, NULL),
('Can', 'Yildiz', '05550000009', 'can.yildiz@nova.com', 'M', 1, 2, NULL),
('Selin', 'Koc', '05550000010', 'selin.koc@nova.com', 'F', 2, 4, NULL);

-- 9. Patient
-- Password requirement: length >= 8, tc_no: 11 chars
INSERT INTO Patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, is_email_verified, pat_password, usr_role) VALUES
('Ali', 'Can', '11111111111', '1980-01-01', 'M', 1, '05440000001', 'ali.can@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Veli', 'Han', '22222222222', '1985-05-12', 'M', 7, '05440000002', 'veli.han@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Merve', 'Tan', '33333333333', '1992-09-20', 'F', 3, '05440000003', 'merve.tan@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Deniz', 'Ak', '44444444444', '1975-03-15', 'M', 5, '05440000004', 'deniz.ak@email.com', FALSE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Seda', 'Nur', '55555555555', '1998-11-30', 'F', 2, '05440000005', 'seda.nur@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Burak', 'Oz', '66666666666', '1988-07-04', 'M', 8, '05440000006', 'burak.oz@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Asli', 'Gul', '77777777777', '1995-12-25', 'F', 1, '05440000007', 'asli.gul@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Emre', 'Tas', '88888888888', '1982-06-18', 'M', 4, '05440000008', 'emre.tas@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Gizem', 'Bal', '99999999999', '2001-02-14', 'F', 6, '05440000009', 'gizem.bal@email.com', FALSE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT'),
('Kerem', 'Sol', '10101010101', '1970-10-10', 'M', 7, '05440000010', 'kerem.sol@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT');

-- 10. Doctor_Schedule (Assigning slots to doctors)
INSERT INTO Doctor_Schedule (schedule_id, doctor_id, is_active) VALUES
(1, 1, FALSE), (2, 1, FALSE), (3, 1, TRUE),
(4, 2, FALSE), (5, 2, FALSE),
(6, 3, FALSE), (7, 3, TRUE),
(8, 4, FALSE), (9, 4, TRUE),
(10, 5, FALSE), (11, 5, TRUE),
(12, 6, TRUE), (13, 7, TRUE), (14, 8, TRUE), (15, 9, TRUE);

-- 12. Patient_Allergy
INSERT INTO Patient_Allergy (allergy_id, patient_id) VALUES
(1, 1), (4, 1),
(2, 2),
(5, 3), (6, 3),
(9, 5),
(10, 8);

-- 13. Patient_Punishment
INSERT INTO Patient_Punishment (punishment_date, patient_id, punishment_id) VALUES
('2026-05-01', 4, 1),
('2026-04-20', 9, 2);

-- 14. Appointment
INSERT INTO Appointment (patient_id, doctor_schedule_id, ap_status) VALUES
(1, 1, 'ACTIVE'),
(2, 4, 'ACTIVE'),
(3, 6, 'ACTIVE'),
(5, 8, 'ACTIVE'),
(7, 10, 'ACTIVE'),
(1, 2, 'COMPLETED'), -- Past appointment
(2, 5, 'COMPLETED'); -- Past appointment

-- 15. Treatment
-- ICD-10 codes for testing
INSERT INTO Treatment (appointment_id, icd10_code) VALUES
(6, 'I10'), -- Essential (primary) hypertension
(7, 'E11.9'); -- Type 2 diabetes mellitus without complications

-- 16. Bill
INSERT INTO Bill (treatment_id, cost) VALUES
(1, 250.00),
(2, 450.75);
