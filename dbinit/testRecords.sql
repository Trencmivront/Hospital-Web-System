-- Gender (Cinsiyetler)
INSERT INTO gender (gender_name) VALUES ('male'), ('female');

-- Blood_type
INSERT INTO blood_type(type_name) VALUES ('A+'), ('A-'), ('B+'), ('B-'), ('AB+'), ('AB-'), ('0+'), ('0-');

-- Departments (Departmanlar)
INSERT INTO department (dept_name, descrpt) VALUES 
('Kardiyoloji', 'Kalp ve damar hastalıkları birimi'),
('Nöroloji', 'Beyin ve sinir sistemi hastalıkları birimi'),
('Dahiliye', 'İç hastalıkları genel birimi');

-- Specializations (Uzmanlık Alanları)
INSERT INTO specialization (name) VALUES 
('Ekokardiyografi'), ('Klinik Nörofizyoloji'), ('Endokrinoloji');

-- Doctors (Doktorlar)
INSERT INTO doctor (first_name, last_name, phone_num, email, gender_name, dept_id) VALUES 
('Ahmet', 'Yılmaz', '05551112233', 'ahmet.y@hastane.com', 'male', 1),
('Ayşe', 'Kaya', '05552223344', 'ayse.k@hastane.com', 'female', 2);

-- Doctor Specializations (Doktor Uzmanlık Eşleşmesi)
INSERT INTO doctor_specialization (spec_id, doctor_id) VALUES (1, 1), (2, 2);

-- Schedule (Zaman Dilimleri)
INSERT INTO schedule (s_date, s_time) VALUES 
('2026-05-10', '09:00:00'),
('2026-05-10', '10:00:00'),
('2026-05-11', '14:00:00');

-- Doctor Schedule (Doktorun Müsaitlik Durumu)
INSERT INTO doctor_schedule (schedule_id, doctor_id, is_active) VALUES 
(1, 1, 1), -- Ahmet Yılmaz 09:00 (Müsait)
(2, 1, 1), -- Ahmet Yılmaz 10:00 (Müsait)
(3, 2, 0); -- Ayşe Kaya 14:00 (İzinli/Kapalı)

-- Allergies (Alerjiler)
INSERT INTO allergy (allergy_descrpt, icd10_code) VALUES 
('Penisilin Alerjisi', 'Z88.0'),
('Polen Alerjisi', 'J30.1');

-- Admin (Yönetici)
INSERT INTO admin (username, ad_password, usr_role) VALUES 
('admin_yilmaz', 'admin_sifre_88', 'ADMIN');

-- Additional Departments (Ek Departmanlar)
INSERT INTO department (dept_name, descrpt, img_path) VALUES 
('Göz Hastalıkları', 'Göz sağlığı ve cerrahisi birimi', 'deptImgs/eye.jpg'),
('Ortopedi', 'Kemik ve eklem hastalıkları birimi', 'deptImgs/ortho.jpg');

-- Additional Specializations (Ek Uzmanlık Alanları)
INSERT INTO specialization (name) VALUES 
('Glokom'), ('El Cerrahisi'), ('Spor Hekimliği');

-- Additional Doctors (Ek Doktorlar)
INSERT INTO doctor (first_name, last_name, phone_num, email, gender_name, dept_id) VALUES 
('Mehmet', 'Can', '05553334455', 'mehmet.c@hastane.com', 'male', 4),
('Fatma', 'Demir', '05554445566', 'fatma.d@hastane.com', 'female', 5);

-- Doctor Specializations (Doktor Uzmanlık Eşleşmesi)
INSERT INTO doctor_specialization (spec_id, doctor_id) VALUES (4, 3), (5, 4);

-- Patients (Hastalar)
-- Passwords should be >= 8 chars, TC No should be 11 chars
INSERT INTO patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, pat_password, usr_role) VALUES 
('Ali', 'Veli', '11122233344', '1990-05-15', 'male', 1, '05321112233', 'ali.veli@email.com', 'ali123456', 'PATIENT'),
('Fatma', 'Nur', '22233344455', '1985-10-20', 'female', 3, '05322223344', 'fatma.nur@email.com', 'fatma123456', 'PATIENT'),
('Can', 'Öz', '33344455566', '2000-01-01', 'male', 7, '05323334455', 'can.oz@email.com', 'can1234567', 'PATIENT');

-- Patient Allergies (Hasta Alerji Eşleşmesi)
INSERT INTO patient_allergy (allergy_id, patient_id) VALUES 
(1, 1), -- Ali Veli: Penisilin Alerjisi
(2, 2); -- Fatma Nur: Polen Alerjisi

-- Additional Schedule (Zaman Dilimleri)
INSERT INTO schedule (s_date, s_time) VALUES 
('2026-05-12', '11:00:00'),
('2026-05-12', '14:00:00'),
('2026-05-13', '09:30:00');

-- Additional Doctor Schedule
INSERT INTO doctor_schedule (schedule_id, doctor_id, is_active) VALUES 
(4, 3, 1), -- Mehmet Can 11:00 (Müsait)
(5, 4, 1), -- Fatma Demir 14:00 (Müsait)
(6, 1, 1); -- Ahmet Yılmaz 09:30 (Müsait)

-- Appointments (Randevular)
INSERT INTO appointment (patient_id, doctor_schedule_id, ap_status) VALUES 
(1, 1, 1), -- Ali Veli, Ahmet Yılmaz (Tamamlandı/Aktif)
(2, 4, 1); -- Fatma Nur, Mehmet Can (Tamamlandı/Aktif)

-- Treatments (Tedaviler)
INSERT INTO treatment (appointment_id, icd10_code) VALUES 
(1, 'I10'), -- Hipertansiyon
(2, 'H40.9'); -- Glokom, tanımlanmamış

-- Bills (Faturalar)
INSERT INTO bill (treatment_id, cost) VALUES 
(1, 150.00),
(2, 250.00);

-- Punishment (Cezalar)
INSERT INTO punishment (reason, for_days) VALUES 
('Randevuya 3 kez üst üste gelmeme', 30);

-- Patient Punishment (Hasta Cezaları)
INSERT INTO patient_punishment (punishment_date, patient_id, punishment_id) VALUES 
('2026-05-01', 3, 1); -- Can Öz 30 gün ceza aldı