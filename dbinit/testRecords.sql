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

-- 5. Punishment
INSERT INTO Punishment (reason, for_days) VALUES
('Repeated appointment no-show', 15),
('Late cancellation (less than 2 hours)', 7),
('Disruptive behavior in facility', 30),
('False patient information', 60);

-- 6. Schedule (Dates starting from 2026-05-11 to 2026-05-30)
-- Today is 2026-05-16. Past: 11, 12. Future: 18, 19, 20, etc.
INSERT INTO Schedule (s_date, s_time) VALUES
('2026-05-18', '09:00:00'), ('2026-05-11', '09:30:00'), ('2026-05-20', '10:00:00'), ('2026-05-18', '10:30:00'),
('2026-05-11', '14:00:00'), ('2026-05-18', '14:30:00'), ('2026-05-20', '15:00:00'),
('2026-05-19', '09:00:00'), ('2026-05-30', '10:00:00'), ('2026-05-19', '11:00:00'),
('2026-05-22', '14:00:00'), ('2026-05-25', '15:00:00'),
('2026-05-21', '09:00:00'), ('2026-05-26', '09:30:00'), ('2026-05-28', '10:00:00');

-- 7. Admin
INSERT INTO Admin (username, ad_password, usr_role, update_date, update_time) VALUES
('admin_root', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', '2026-05-16', '10:00:00'),
('hospital_mgr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', '2026-05-16', '10:00:00');

-- 8. Doctor
INSERT INTO Doctor (first_name, last_name, phone_num, email, gender_name, dept_id, spec_id, img_path, update_date, update_time) VALUES
('Ahmet', 'Yilmaz', '05550000001', 'ahmet.yilmaz@nova.com', 'M', 1, 1, NULL, '2026-05-16', '10:00:00'),
('Ayse', 'Kaya', '05550000002', 'ayse.kaya@nova.com', 'F', 2, 3, NULL, '2026-05-16', '10:00:00'),
('Mehmet', 'Demir', '05550000003', 'mehmet.demir@nova.com', 'M', 3, 5, NULL, '2026-05-16', '10:00:00'),
('Zeynep', 'Celik', '05550000004', 'zeynep.celik@nova.com', 'F', 4, 7, NULL, '2026-05-16', '10:00:00'),
('Mustafa', 'Sahin', '05550000005', 'mustafa.sahin@nova.com', 'M', 5, 9, NULL, '2026-05-16', '10:00:00'),
('Elif', 'Ozturk', '05550000006', 'elif.ozturk@nova.com', 'F', 6, 10, NULL, '2026-05-16', '10:00:00'),
('Murat', 'Aydin', '05550000007', 'murat.aydin@nova.com', 'M', 7, 11, NULL, '2026-05-16', '10:00:00'),
('Fatma', 'Arslan', '05550000008', 'fatma.arslan@nova.com', 'F', 8, 12, NULL, '2026-05-16', '10:00:00'),
('Can', 'Yildiz', '05550000009', 'can.yildiz@nova.com', 'M', 1, 2, NULL, '2026-05-16', '10:00:00'),
('Selin', 'Koc', '05550000010', 'selin.koc@nova.com', 'F', 2, 4, NULL, '2026-05-16', '10:00:00');

-- 9. Patient
-- Password requirement: length >= 8, tc_no: 11 chars
INSERT INTO Patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, is_email_verified, pat_password, usr_role, update_date, update_time) VALUES
('Ali', 'Can', '11111111111', '1980-01-01', 'M', 1, '05440000001', 'ali.can@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Veli', 'Han', '22222222222', '1985-05-12', 'M', 7, '05440000002', 'veli.han@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Merve', 'Tan', '33333333333', '1992-09-20', 'F', 3, '05440000003', 'merve.tan@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Deniz', 'Ak', '44444444444', '1975-03-15', 'M', 5, '05440000004', 'deniz.ak@email.com', FALSE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Seda', 'Nur', '55555555555', '1998-11-30', 'F', 2, '05440000005', 'seda.nur@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Burak', 'Oz', '66666666666', '1988-07-04', 'M', 8, '05440000006', 'burak.oz@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Asli', 'Gul', '77777777777', '1995-12-25', 'F', 1, '05440000007', 'asli.gul@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Emre', 'Tas', '88888888888', '1982-06-18', 'M', 4, '05440000008', 'emre.tas@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Gizem', 'Bal', '99999999999', '2001-02-14', 'F', 6, '05440000009', 'gizem.bal@email.com', FALSE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00'),
('Kerem', 'Sol', '10101010101', '1970-10-10', 'M', 7, '05440000010', 'kerem.sol@email.com', TRUE, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PATIENT', '2026-05-16', '10:00:00');

-- 10. Doctor_Schedule (Assigning slots to doctors)
INSERT INTO Doctor_Schedule (schedule_id, doctor_id, is_active) VALUES
(1, 1, FALSE), (2, 1, FALSE), (3, 1, TRUE),
(4, 2, FALSE), (5, 2, FALSE),
(6, 3, FALSE), (7, 3, TRUE),
(8, 4, FALSE), (9, 4, TRUE),
(10, 5, FALSE), (11, 5, TRUE),
(12, 6, TRUE), (13, 7, TRUE), (14, 8, TRUE), (15, 9, TRUE);

-- 13. Patient_Punishment
INSERT INTO Patient_Punishment (punishment_date, patient_id, punishment_id, update_date, update_time) VALUES
('2026-05-01', 4, 1, '2026-05-16', '10:00:00'),
('2026-04-20', 9, 2, '2026-05-16', '10:00:00');

-- 14. Appointment
INSERT INTO Appointment (patient_id, doctor_schedule_id, ap_status, update_date, update_time) VALUES
(1, 1, 'ACTIVE', '2026-05-16', '10:00:00'),
(2, 4, 'ACTIVE', '2026-05-16', '10:00:00'),
(3, 6, 'ACTIVE', '2026-05-16', '10:00:00'),
(5, 8, 'ACTIVE', '2026-05-16', '10:00:00'),
(7, 10, 'ACTIVE', '2026-05-16', '10:00:00'),
(1, 2, 'COMPLETED', '2026-05-16', '10:00:00'), -- Past appointment (2026-05-11)
(2, 5, 'COMPLETED', '2026-05-16', '10:00:00'); -- Past appointment (2026-05-11)

-- 15. Treatment
-- ICD-10 codes for testing
INSERT INTO Treatment (appointment_id, icd10_code, update_date, update_time) VALUES
(6, 'I10', '2026-05-16', '10:00:00'), -- Essential (primary) hypertension
(7, 'E11.9', '2026-05-16', '10:00:00'); -- Type 2 diabetes mellitus without complications

-- 16. Bill
INSERT INTO Bill (treatment_id, cost, is_paid, update_date, update_time) VALUES
(1, 250.00, TRUE, '2026-05-16', '10:00:00'),
(2, 450.75, FALSE, '2026-05-16', '10:00:00');
