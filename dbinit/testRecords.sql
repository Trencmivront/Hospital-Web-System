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