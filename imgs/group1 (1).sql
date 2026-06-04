-- HOSPITAL DATABASE SYSTEM
------------------------------------------------------------------------------------------------------------------
-- YILMAZ --
-- Aktif randevu sayısı 2 den büyük veya eşit olan olan ve kan grubu A+ olan hastaları listele
SELECT p.patient_id ,p.pat_first_name || ' ' || p.pat_last_name as patient_name, COUNT(ap.appointment_id), bt.type_name as type_name FROM Patient p 
JOIN Appointment ap ON ap.patient_id = p.patient_id
JOIN Blood_Type bt ON bt.blood_id = p.blood_id
WHERE bt.type_name = 'A+' AND ap.is_active = 1
GROUP BY p.patient_id, p.pat_first_name, p.pat_last_name ,bt.type_name
HAVING COUNT(ap.appointment_id) >= 2
ORDER BY COUNT(ap.appointment_id);

-- Arzum hocadan
-- Doktorların aktif randevu sayılarını, departmanları ile birlikte listele
SELECT d.doctor_id,
d.doc_first_name || ' ' || d.doc_last_name as doctor, dept.dept_id, dept.dept_name as department, COUNT(ap.appointment_id) as active_appointment_count
FROM Department dept
JOIN Doctor d ON d.dept_id = dept.dept_id
JOIN Appointment ap ON ap.doctor_id = d.doctor_id
WHERE ap.is_active = 1
GROUP BY dept.dept_id, dept.dept_name, d.doctor_id, d.doc_first_name, d.doc_last_name;
------------------------------------------------------------------------------------------------------------------
-- HEBA --
-- Her bir departmanın gerçekleştirdiği toplam tedavi sayısını, toplam geliri ve toplam vergi tutarını listele
SELECT dept.dept_name, count(t.treatment_id) as total_treatments, sum(b.total_amount) as total_revenue, sum(b.tax) as total_tax
FROM bill b 
JOIN treatment t ON b.treatment_id = t.treatment_id 
JOIN appointment a ON a.appointment_id = t.appointment_id
JOIN doctor d ON d.doctor_id = a.doctor_id
JOIN DEPARTMENT dept ON dept.dept_id = d.dept_id
GROUP BY dept.dept_id, dept.dept_name;

-- Arzum hocadan
-- Son 6 ayda en çok gidilen bölüm ve doktorları listele
SELECT dept.dept_name, d.doc_first_name || ' ' || d.doc_last_name as doctor_name, COUNT(ap.appointment_id) as visit_count
FROM Appointment ap
JOIN Doctor d ON ap.doctor_id = d.doctor_id
JOIN Department dept ON d.dept_id = dept.dept_id
JOIN Schedule s ON ap.schedule_id = s.schedule_id
WHERE s.schedule_date >= ADD_MONTHS(SYSDATE, -6)
GROUP BY dept.dept_name, d.doc_first_name, d.doc_last_name
ORDER BY visit_count DESC;
------------------------------------------------------------------------------------------------------------------
--HAMZA
-- Aktif randevu sayısı 2 den fazla olan doktorları; departman, ülke bilgileri ve toplam randevu sayılarıyla birlikte listele
SELECT
    d.doctor_id,
    d.doc_first_name || ' ' || d.doc_last_name AS doctor_name,
    dep.dept_name,
    c.country_name,
    COUNT(a.appointment_id) AS total_appointments
FROM Appointment a
JOIN Doctor d ON a.doctor_id = d.doctor_id
JOIN Department dep ON d.dept_id = dep.dept_id
JOIN Address ad ON d.address_id = ad.address_id
JOIN Neighbourhood n ON ad.neighbourhood_id = n.neighbourhood_id
JOIN District dis ON n.district_id = dis.district_id
JOIN Province p ON dis.province_id = p.province_id
JOIN Country c ON p.country_id = c.country_id
WHERE a.is_active = 1
GROUP BY
    d.doctor_id,
    d.doc_first_name,
    d.doc_last_name,
    dep.dept_name,
    c.country_name
HAVING COUNT(a.appointment_id) > 2
ORDER BY total_appointments DESC, doctor_name;

-- Arzum hocadan
-- Son 1 yılda randevu alan hastaları alerji sayılarına göre büyükten küçüğe doğru sırala
SELECT
    p.patient_id,
    p.pat_first_name || ' ' || p.pat_last_name AS patient_name,
    COUNT(DISTINCT pa.allergy_id) AS allergy_count
FROM Patient p
JOIN Appointment a ON p.patient_id = a.patient_id
JOIN Schedule s ON a.schedule_id = s.schedule_id
LEFT JOIN Patient_Allergy pa ON p.patient_id = pa.patient_id
WHERE s.schedule_date >= ADD_MONTHS(SYSDATE, -12)
GROUP BY
    p.patient_id,
    p.pat_first_name,
    p.pat_last_name
ORDER BY
    allergy_count DESC;
------------------------------------------------------------------------------------------------------------------
-- SHEHAB --
-- Alerjisi olan ve ismi 'e' ile başlayan hastaları listele
SELECT  p.patient_id, 
    p.pat_first_name,
    p.pat_last_name,
    a.allergy_id
    
    from patient p
     JOIN Patient_Allergy pa
    ON p.patient_id = pa.patient_id
    JOIN Allergy a
    ON pa.allergy_id = a.allergy_id
    
    where p.pat_first_name like 'E%' 
order by     p.pat_first_name,
    p.pat_last_name,
    a.allergy_id;

-- Arzum hocadan
-- Hastanın randevu alabileceği departmanları, doktorları ve randevu alınabilecek tarih, saat bilgilerini listele
SELECT
    p.patient_id,
    p.pat_first_name || ' ' || p.pat_last_name AS patient_name,
    d.doc_first_name || ' ' || d.doc_last_name AS doctor_name,
    dep.dept_name,
    s.schedule_date,
    s.schedule_time
FROM Patient p
JOIN Blood_Type bt
    ON p.blood_id = bt.blood_id
JOIN Appointment a
    ON p.patient_id = a.patient_id
JOIN Doctor d
    ON a.doctor_id = d.doctor_id
JOIN Department dep
    ON d.dept_id = dep.dept_id
JOIN Schedule s
    ON a.schedule_id = s.schedule_id
WHERE bt.type_name = 'O-'
ORDER BY s.schedule_date, s.schedule_time;
