<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/JWToken.php";

class GetPatientById {
    function execute(PDO $pdo) : array {

        $jwt = new JWToken();
    
        $query = 'SELECT p.first_name, p.last_name, p.tc_no, p.birth_date, p.gender_name, b.type_name as blood_type,
                         p.phone_num, p.email, p.is_email_verified
                  FROM Patient p
                  JOIN Blood_Type b ON p.blood_id = b.blood_id
                  WHERE p.patient_id = :patient_id';

        try {
            $patient_id = null;

            if(isset($_SESSION['patient_jwt'])){
                $jwtContents = $jwt->openToken($_SESSION['patient_jwt']);
                $patient_id = $jwtContents->user_id;
            }
            else if(isset($_SESSION['admin_jwt'])){
                // Verify admin token
                $jwt->openToken($_SESSION['admin_jwt']);
                
                // Get patient_id from GET parameters
                $patient_id = $_GET['patient_id'] ?? null;
                if (!$patient_id) {
                    throw new CouldNotRetrievePatientDataException();
                }
                $patient_id = htmlspecialchars($patient_id);
            }
            else{
                throw new UserIsNotAuthenticatedException();
            }

            $statement = $pdo->prepare($query);
            $statement->execute(['patient_id' => $patient_id]);
            $patient = $statement->fetch();

            if (!$patient) {
                throw new UserNotFoundException();
            }

            return $patient;
        } catch (PDOException $e) {
            throw new CouldNotRetrievePatientDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}
