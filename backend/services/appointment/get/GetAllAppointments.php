<?php

use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    class GetAllAppointments {
        function execute(PDO $pdo) : array{

            if(!isset($_SESSION['admin_jwt'])){
                throw new UserIsNotAuthenticatedException();
            }

            $jwt = new JWToken();

            try{

                $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
                $admin_id = $jwtContents->user_id;
                $admin_role = $jwtContents->user_role;
                if((empty($admin_id) || empty($admin_role)) || $admin_role !== 'ADMIN'){
                    throw new UserIsNotAuthenticatedException();
                }

                $query = 'SELECT a.appointment_id, p.first_name AS p_first_name, p.last_name AS p_last_name, 
                         d.first_name AS d_first_name, d.last_name AS d_last_name, 
                         dept.dept_name, s.s_date, s.s_time, a.ap_status, a.update_date, a.update_time
                  FROM Appointment a
                  JOIN Patient p ON a.patient_id = p.patient_id
                  JOIN Doctor_Schedule ds ON a.doctor_schedule_id = ds.doctor_schedule_id
                  JOIN Doctor d ON ds.doctor_id = d.doctor_id
                  JOIN Schedule s ON ds.schedule_id = s.schedule_id
                  JOIN Department dept ON d.dept_id = dept.dept_id
                  ORDER BY a.update_date ASC';

                  $statement = $pdo->query($query);
                  $data = $statement->fetchAll();

                  return $data;
            }catch(PDOException $e){
                throw new CouldNotRetrieveAppointmentDataException();
            }catch(ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }
        }
    }