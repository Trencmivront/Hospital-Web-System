<?php
    use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetTodaysAppointments{
    function execute(PDO $pdo) : array{
        $query = 'SELECT a.appointment_id, p.first_name AS p_first_name, p.last_name AS p_last_name, 
                         d.first_name AS d_first_name, d.last_name AS d_last_name, 
                         dept.dept_name, s.s_time, a.ap_status 
                  FROM Appointment a
                  JOIN Patient p ON a.patient_id = p.patient_id
                  JOIN Doctor_Schedule ds ON a.doctor_schedule_id = ds.doctor_schedule_id
                  JOIN Doctor d ON ds.doctor_id = d.doctor_id
                  JOIN Schedule s ON ds.schedule_id = s.schedule_id
                  JOIN Department dept ON d.dept_id = dept.dept_id
                  WHERE s.s_date = CURRENT_DATE
                  ORDER BY s.s_time ASC';

        if(!isset($_SESSION['admin_jwt'])){
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try{
            $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
            
            $admin_id = $jwtContents->user_id;
            $admin_role = $jwtContents->role;

            if((empty($admin_id) || empty($admin_role)) || ($admin_role != "ADMIN")){
                throw new UserIsNotAuthenticatedException();
            }

            $statement = $pdo->prepare($query);
            $statement->execute();

            $data = $statement->fetchAll();

            return $data;

        }catch(PDOException $e){
            throw new CouldNotRetrieveAppointmentDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}