<?php

use Firebase\JWT\ExpiredException;

    class GetBillsOfPatient {
        function execute(PDO $pdo){

        $query = '';

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
                throw new CouldNotRetrieveBillDataException();
            }catch(ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }

        }
    }