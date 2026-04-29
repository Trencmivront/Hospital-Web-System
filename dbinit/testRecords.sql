-- 1. Gender (Cinsiyetler)
INSERT INTO gender (gender_name) VALUES ('male'), ('female');

-- 2. Departments (Departmanlar)
INSERT INTO department (dept_name, descrpt) VALUES 
('Kardiyoloji', 'Kalp ve damar hastalıkları birimi'),
('Nöroloji', 'Beyin ve sinir sistemi hastalıkları birimi'),
('Dahiliye', 'İç hastalıkları genel birimi');

-- 3. Specializations (Uzmanlık Alanları)
INSERT INTO specialization (name) VALUES 
('Ekokardiyografi'), ('Klinik Nörofizyoloji'), ('Endokrinoloji');

-- 4. Doctors (Doktorlar)
INSERT INTO doctor (first_name, last_name, phone_num, email, gender_name, dept_id) VALUES 
('Ahmet', 'Yılmaz', '05551112233', 'ahmet.y@hastane.com', 'male', 1),
('Ayşe', 'Kaya', '05552223344', 'ayse.k@hastane.com', 'female', 2);

-- 5. Doctor Specializations (Doktor Uzmanlık Eşleşmesi)
INSERT INTO doctor_specialization (spec_id, doctor_id) VALUES (1, 1), (2, 2);

-- 6. Schedule (Zaman Dilimleri)
INSERT INTO schedule (s_date, s_time) VALUES 
('2026-05-10', '09:00:00'),
('2026-05-10', '10:00:00'),
('2026-05-11', '14:00:00');

-- 7. Doctor Schedule (Doktorun Müsaitlik Durumu)
INSERT INTO doctor_schedule (schedule_id, doctor_id, is_active) VALUES 
(1, 1, 1), -- Ahmet Yılmaz 09:00 (Müsait)
(2, 1, 1), -- Ahmet Yılmaz 10:00 (Müsait)
(3, 2, 0); -- Ayşe Kaya 14:00 (İzinli/Kapalı)

-- 8. Patients (Hastalar - Şifreler temsilidir)
INSERT INTO patient (first_name, last_name, tc_no, birth_date, gender_name, blood_group, phone_num, email, pat_password, usr_role) VALUES 
('Yılmaz', 'Sönmez', '12345678901', '2005-12-01', 'male', 'A+', '05001234567', 'yilmaz@mail.com', 'sifre12345', 'PATIENT'),
('Fatma', 'Demir', '98765432109', '1995-05-15', 'female', 'O-', '05007654321', 'fatma@mail.com', 'sifre54321', 'PATIENT');

-- 9. Allergies (Alerjiler)
INSERT INTO allergy (allergy_descrpt, icd10_code) VALUES 
('Penisilin Alerjisi', 'Z88.0'),
('Polen Alerjisi', 'J30.1');

-- 10. Patient Allergies (Hasta-Alerji Eşleşmesi)
INSERT INTO patient_allergy (allergy_id, patient_id) VALUES (1, 1);

-- 11. Appointments (Randevular)
INSERT INTO appointment (patient_id, doctor_schedule_id, ap_status) VALUES 
(1, 1, 1); -- Yılmaz, Ahmet Yılmaz'dan 09:00 randevusu aldı.

-- 12. Treatment (Tedavi)
INSERT INTO treatment (appointment_id, icd10_code) VALUES 
(1, 'I10'); -- Hipertansiyon tanısı

-- 13. Bill (Fatura)
INSERT INTO bill (treatment_id, cost) VALUES (1, 450.00);

-- 14. Admin (Yönetici)
INSERT INTO admin (username, ad_password, usr_role) VALUES 
('admin_yilmaz', 'admin_sifre_88', 'ADMIN');