<?php
    use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAppointmentsOfPatient{
    function execute(PDO $pdo) : array{
        // too many joins
        // put patient id in place of :patient_id
        $query = 'SELECT a.appointment_id, d.doctor_id, dept.dept_name, d.first_name,
            d.last_name, s.schedule_id, s.s_date, TIME_FORMAT(s.s_time, "%H:%i") as s_time, a.ap_status FROM Appointment a
            JOIN Patient p ON a.patient_id = p.patient_id
            JOIN Doctor_Schedule ds ON ds.doctor_schedule_id = a.doctor_schedule_id
            JOIN Doctor d ON d.doctor_id = ds.doctor_id
            JOIN Schedule s ON s.schedule_id = ds.schedule_id
            JOIN Department dept ON dept.dept_id = d.dept_id WHERE p.patient_id = :patient_id
            ORDER BY s.s_date DESC';

        if(!isset($_SESSION['patient_jwt'])){
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try{
            $jwtContents = $jwt->openToken($_SESSION['patient_jwt']);
            
            $patient_id = $jwtContents->user_id;
            $patient_role = $jwtContents->role;

            if((empty($patient_id) || empty($patient_role)) || ($patient_role != "PATIENT")){
                throw new UserIsNotAuthenticatedException();
            }

            $statement = $pdo->prepare($query);
            $statement->execute(['patient_id' => $patient_id]);

            $data = $statement->fetchAll();

            return $data;

        }catch(PDOException $e){
            throw new CouldNotRetrieveAppointmentDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }


}