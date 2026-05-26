<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetActiveAppointmentCountOfDoctors {
    function execute(PDO $pdo) : array{

            if(!isset($_SESSION['admin_jwt'])){
                throw new UserIsNotAuthenticatedException();
            }

            $jwt = new JWToken();

            try{

                $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
                $admin_id = $jwtContents->user_id;
                $admin_role = $jwtContents->role;
                if((empty($admin_id) || empty($admin_role)) || $admin_role !== 'ADMIN'){
                    throw new UserIsNotAuthenticatedException();
                }

                $query = 'SELECT d.doctor_id, d.first_name, d.last_name, COUNT(a.appointment_id) as ap_count FROM Appointment a
                  JOIN Doctor_Schedule ds ON a.doctor_schedule_id = ds.doctor_schedule_id
                  JOIN Doctor d ON ds.doctor_id = d.doctor_id
                  WHERE a.ap_status = \'ACTIVE\'
                  GROUP BY d.doctor_id
                  ORDER BY d.doctor_id ASC';

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