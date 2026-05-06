-- Test records for Hospital Web System

-- 1. Department
INSERT INTO Department (dept_name, descrpt, img_path) VALUES
('Cardiology', 'Heart and vascular system department.', 'imgs/deptImgs/cardiology.jpg'),
('Neurology', 'Brain and nervous system department.', 'imgs/deptImgs/neurology.jpg'),
('Orthopedics', 'Musculoskeletal system department.', 'imgs/deptImgs/orthopedics.jpg'),
('Pediatrics', 'Medical care for infants, children, and adolescents.', 'imgs/deptImgs/pediatrics.jpg');

-- 2. Specialization
INSERT INTO Specialization (name) VALUES
('Invasive Cardiology'),
('Pediatric Neurology'),
('Spine Surgery'),
('General Pediatrics');

-- 3. Blood_Type
INSERT INTO Blood_Type (type_name) VALUES
('A+'), ('A-'), ('B+'), ('B-'), ('AB+'), ('AB-'), ('0+'), ('0-');

-- 4. Allergy
INSERT INTO Allergy (allergy_descrpt, icd10_code) VALUES
('Penicillin Allergy', 'Z88.0'),
('Peanut Allergy', 'Z91.010'),
('Latex Allergy', 'Z91.040');

-- 5. Punishment
INSERT INTO Punishment (reason, for_days) VALUES
('Late cancellation', 7),
('Repeated no-show', 15),
('Inappropriate behavior', 30);

-- 6. Schedule
INSERT INTO Schedule (s_date, s_time) VALUES
('2026-05-10', '09:00:00'),
('2026-05-10', '10:00:00'),
('2026-05-10', '11:00:00'),
('2026-05-11', '09:30:00'),
('2026-05-11', '10:30:00');

-- 7. Admin
INSERT INTO Admin (username, ad_password, usr_role) VALUES
('admin1', 'hashed_password_123', 'ADMIN'),
('superadmin', 'secure_admin_pass', 'ADMIN');

-- 8. Doctor
INSERT INTO Doctor (first_name, last_name, phone_num, email, gender_name, dept_id) VALUES
('John', 'Doe', '05551112233', 'john.doe@hospital.com', 'M', 1),
('Jane', 'Smith', '05552223344', 'jane.smith@hospital.com', 'F', 2),
('Michael', 'Brown', '05553334455', 'michael.brown@hospital.com', 'M', 3),
('Emily', 'Davis', '05554445566', 'emily.davis@hospital.com', 'F', 4);

-- 9. Patient
-- Password length must be >= 8, tc_no must be 11 chars
INSERT INTO Patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, pat_password, usr_role) VALUES
('Alice', 'Johnson', '12345678901', '1990-05-15', 'F', 1, '05441112233', 'alice@email.com', 'password123', 'PATIENT'),
('Bob', 'Wilson', '23456789012', '1985-11-20', 'M', 7, '05442223344', 'bob@email.com', 'password456', 'PATIENT'),
('Charlie', 'Miller', '34567890123', '2000-01-01', 'M', 3, '05443334455', 'charlie@email.com', 'password789', 'PATIENT');

-- 10. Doctor_Schedule
INSERT INTO Doctor_Schedule (schedule_id, doctor_id, is_active) VALUES
(1, 1, TRUE),
(2, 1, TRUE),
(3, 2, TRUE),
(4, 3, TRUE),
(5, 4, FALSE);

-- 11. Doctor_Specialization
INSERT INTO Doctor_Specialization (spec_id, doctor_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- 12. Patient_Allergy
INSERT INTO Patient_Allergy (allergy_id, patient_id) VALUES
(1, 1),
(2, 2);

-- 13. Patient_Punishment
INSERT INTO Patient_Punishment (punishment_date, patient_id, punishment_id) VALUES
('2026-05-01', 3, 1);

-- 14. Appointment
INSERT INTO Appointment (patient_id, doctor_schedule_id) VALUES
(1, 1),
(2, 3);

-- 15. Treatment
INSERT INTO Treatment (appointment_id, icd10_code) VALUES
(1, 'I10'), -- Essential hypertension
(2, 'G44.1'); -- Vascular headache

-- 16. Bill
INSERT INTO Bill (treatment_id, cost) VALUES
(1, 150.00),
(2, 200.50);
