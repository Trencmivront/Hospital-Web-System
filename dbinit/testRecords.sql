INSERT INTO department (dept_name, descrpt) VALUES 
('Kardiyoloji', 'Kalp ve damar hastalıkları merkezi'),
('Nöroloji', 'Beyin ve sinir sistemi araştırmaları'),
('Pediatri', 'Çocuk sağlığı ve hastalıkları bölümü');

INSERT INTO doctor (first_name, last_name, specialization, phone_num, email, doc_gender, dept_id) VALUES 
('Ahmet', 'Yılmaz', 'Kardiyolog', '05321112233', 'ahmet@hastane.com', 'M', 1),
('Canan', 'Kaya', 'Nörolog', '05431112233', 'canan@hastane.com', 'F', 2),
('Mehmet', 'Öztürk', 'Çocuk Doktoru', '05551112233', 'mehmet@hastane.com', 'M', 3);

INSERT INTO doctor_schedule (s_date, s_time, doctor_id) VALUES 
('2026-05-10', '09:00:00', 1),
('2026-05-10', '10:30:00', 1),
('2026-05-11', '14:00:00', 2);

INSERT INTO patient (first_name, last_name, tc_no, birth_date, pat_gender, blood_group, allergies, phone_num, email, pat_password, pat_role) VALUES 
('Ali', 'Veli', '12345678901', '1990-01-15', 'M', 'A+', 'Polen', '05051112233', 'ali@mail.com', 'hash_sifre_123456', 'PATIENT'),
('Ayşe', 'Fatma', '98765432109', '1985-06-20', 'F', 'B-', 'Yok', '05061112233', 'ayse@mail.com', 'hash_sifre_654321', 'PATIENT');

INSERT INTO appointment (patient_id, schedule_id, ap_status) VALUES 
(1, 1, 'DONE'),   -- Ali Veli, Ahmet Yılmaz'a gitti (Bitti)
(2, 3, 'ACTIVE'); -- Ayşe Fatma, Canan Kaya'ya gidecek (Bekliyor)

INSERT INTO treatment (appointment_id, icd_code) VALUES 
(1, 'I10 - Esansiyel Hipertansiyon');

INSERT INTO bill (treatment_id, cost) VALUES 
(1, 450.50);

INSERT INTO admin (username, ad_password, ad_role) VALUES 
('admin_murat', 'guclu_sifre_8899', 'ADMIN');