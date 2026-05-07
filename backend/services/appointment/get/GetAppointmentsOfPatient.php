<?php

    function getAppointmentsOfPatient() : array{
        $query = 'select a.appointment_id, p.patient_id, d.doctor_id, dept.dept_name, d.first_name,
            d.last_name, s.schedule_id, s.s_date, s.s_time FROM Appointment a
            JOIN Patient p ON a.patient_id = p.patient_id
            JOIN Doctor_Schedule ds ON ds.doctor_schedule_id = a.doctor_schedule_id
            JOIN Doctor d ON d.doctor_id = ds.doctor_id
            JOIN Schedule s ON s.schedule_id = ds.schedule_id
            JOIN Department dept ON dept.dept_id = d.dept_id';

        try{

        }catch(Exception $e){

        }

        return [];
    }

?>