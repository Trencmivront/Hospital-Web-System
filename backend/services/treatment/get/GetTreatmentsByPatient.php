<?php

use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";


    class GetTreatmentsByPatient {
        function execute(PDO $pdo){

            $query = 'SELECT t.treatment_id, t.icd10_code, t.created_at, d.dept_name
                      FROM Treatment t
                      JOIN Appointment a ON t.appointment_id = a.appointment_id
                      JOIN Doctor_Schedule ds ON a.doctor_schedule_id = ds.doctor_schedule_id
                      JOIN Doctor doc ON ds.doctor_id = doc.doctor_id
                      JOIN Department d ON doc.dept_id = d.dept_id
                      WHERE a.patient_id = :patient_id
                      ORDER BY t.created_at DESC';

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
                throw new FetchTreatmentsException();
            }catch(ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }

        }
    }
