<?php

use Firebase\JWT\ExpiredException;

    class GetBillsOfPatient {
        function execute(PDO $pdo){

        $query = 'SELECT b.bill_id, b.cost, b.is_paid, b.created_at, t.icd10_code, a.appointment_id
                  FROM Bill b
                  JOIN Treatment t ON b.treatment_id = t.treatment_id
                  JOIN Appointment a ON t.appointment_id = a.appointment_id
                  WHERE a.patient_id = :patient_id
                  ORDER BY b.created_at DESC';

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

                $data = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $data;

            }catch(PDOException $e){
                throw new CouldNotRetrieveBillDataException();
            }catch(ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }

        }
    }