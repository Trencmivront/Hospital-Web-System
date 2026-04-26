INSERT INTO department (dept_name, descrpt) VALUES
('Cardiology', 'Heart and vascular diseases center'),
('Neurology', 'Brain and nervous system research'),
('Pediatrics', 'Children\'s health and diseases department'),
('Orthopedics', 'Bone and joint disorders treatment'),
('Gynecology', 'Women\'s reproductive health'),
('Urology', 'Urinary system and male reproductive health'),
('Dermatology', 'Skin diseases and conditions'),
('Ophthalmology', 'Eye care and vision services'),
('Otolaryngology', 'Ear, nose, and throat disorders'),
('Psychiatry', 'Mental health and psychiatric care'),
('Radiology', 'Medical imaging and diagnostics'),
('Emergency Medicine', 'Urgent medical care and trauma'),
('Internal Medicine', 'General adult medicine'),
('Surgery', 'Surgical procedures and operations'),
('Oncology', 'Cancer treatment and research'),
('Gastroenterology', 'Digestive system disorders'),
('Nephrology', 'Kidney diseases and dialysis'),
('Endocrinology', 'Hormonal disorders and diabetes'),
('Pulmonology', 'Lung and respiratory diseases'),
('Rheumatology', 'Autoimmune and musculoskeletal diseases');

INSERT INTO doctor (first_name, last_name, specialization, phone_num, email, doc_gender, dept_id) VALUES
('John', 'Smith', 'Cardiologist', '05321112233', 'john@hospital.com', 'M', 1),
('Emily', 'Johnson', 'Neurologist', '05431112233', 'emily@hospital.com', 'F', 2),
('Michael', 'Brown', 'Pediatrician', '05551112233', 'michael@hospital.com', 'M', 3),
('Sarah', 'Davis', 'Orthopedic Surgeon', '05332223344', 'sarah@hospital.com', 'F', 4),
('David', 'Wilson', 'Gynecologist', '05443334455', 'david@hospital.com', 'M', 5),
('Lisa', 'Garcia', 'Urologist', '05554445566', 'lisa@hospital.com', 'F', 6),
('Robert', 'Martinez', 'Dermatologist', '05365556677', 'robert@hospital.com', 'M', 7),
('Jennifer', 'Anderson', 'Ophthalmologist', '05476667788', 'jennifer@hospital.com', 'F', 8),
('James', 'Taylor', 'Otolaryngologist', '05587778899', 'james@hospital.com', 'M', 9),
('Maria', 'Thomas', 'Psychiatrist', '05398889900', 'maria@hospital.com', 'F', 10);

INSERT INTO doctor_schedule (s_date, s_time, doctor_id) VALUES
('2026-05-10', '09:00:00', 1),
('2026-05-10', '10:00:00', 1),
('2026-05-11', '14:00:00', 2),
('2026-05-12', '11:00:00', 3),
('2026-05-13', '15:00:00', 4),
('2026-05-14', '09:30:00', 5),
('2026-05-15', '13:00:00', 6),
('2026-05-10', '16:00:00', 7),
('2026-05-11', '10:00:00', 8),
('2026-05-12', '12:00:00', 9);

INSERT INTO patient (first_name, last_name, tc_no, birth_date, pat_gender, blood_group, allergies, phone_num, email, pat_password, pat_role) VALUES
('John', 'Doe', '12345678901', '1990-01-15', 'M', 'A+', 'Pollen', '05051112233', 'john@mail.com', 'hash_password_123', 'PATIENT'),
('Jane', 'Smith', '98765432109', '1985-06-20', 'F', 'B-', 'None', '05061112233', 'jane@mail.com', 'hash_password_456', 'PATIENT'),
('Alice', 'Johnson', '11111111111', '1975-03-10', 'F', 'O+', 'Nuts', '05071112233', 'alice@mail.com', 'hash_password_789', 'PATIENT'),
('Bob', 'Williams', '22222222222', '1980-07-25', 'M', 'AB-', 'None', '05081112233', 'bob@mail.com', 'hash_password_012', 'PATIENT'),
('Carol', 'Brown', '33333333333', '1995-12-05', 'F', 'A-', 'Shellfish', '05091112233', 'carol@mail.com', 'hash_password_345', 'PATIENT');

INSERT INTO appointment (patient_id, schedule_id, ap_status) VALUES
(1, 1, 'DONE'),
(2, 3, 'ACTIVE'),
(3, 4, 'ABSENT');

INSERT INTO treatment (appointment_id, icd_code) VALUES
(1, 'I10 - Essential Hypertension'),
(2, 'G43.9 - Migraine, unspecified');

INSERT INTO bill (treatment_id, cost) VALUES
(1, 450.50),
(2, 300.00);

INSERT INTO admin (username, ad_password, ad_role) VALUES
('admin_john', 'strong_password_8899', 'ADMIN');