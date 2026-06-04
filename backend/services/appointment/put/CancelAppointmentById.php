<?php

use Firebase\JWT\ExpiredException;

    class CancelAppointmentById {
        function execute(PDO $pdo){

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if(!isset($data->appointment_id)){
                throw new NullInputsException();
            }

            $appointment_id = $data->appointment_id;

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

                // Check if appointment is ACTIVE
                $checkQuery = "SELECT ap_status, doctor_schedule_id FROM Appointment WHERE appointment_id = :appointment_id AND patient_id = :patient_id";
                $checkStmt = $pdo->prepare($checkQuery);
                $checkStmt->execute(['appointment_id' => $appointment_id, 'patient_id' => $patient_id]);
                $appointment = $checkStmt->fetch(PDO::FETCH_ASSOC);

                if(!$appointment){
                    throw new CouldNotRetrieveAppointmentDataException();
                }

                if($appointment['ap_status'] != 'ACTIVE'){
                    throw new CouldNotCancelAppointmentException();
                }

                $doctor_schedule_id = $appointment['doctor_schedule_id'];

                $pdo->beginTransaction();

                $query = "UPDATE Appointment SET ap_status = 'CLOSED', updated_at = NOW() WHERE appointment_id = :appointment_id AND patient_id = :patient_id";
                $statement = $pdo->prepare($query);
                $statement->execute(['appointment_id' => $appointment_id, 'patient_id' => $patient_id]);

                // Set doctor schedule back to active
                $updateQuery = "UPDATE Doctor_Schedule SET is_active = 1 WHERE doctor_schedule_id = :doctor_schedule_id";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->execute(['doctor_schedule_id' => $doctor_schedule_id]);

                $pdo->commit();

                return true;

            }catch(PDOException $e){
                if($pdo->inTransaction()){
                    $pdo->rollBack();
                }
                throw new CouldNotDeleteAppointmentException();
            }catch(ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }
        }
    }