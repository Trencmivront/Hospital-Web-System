<?php
    use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";
class GetPunishmentByPatient{
    function execute(PDO $pdo) : array{
        $query = 'SELECT p.punishment_id, p.reason, p.for_days, pp.punishment_date 
                  FROM Patient_Punishment pp
                  JOIN Punishment p ON pp.punishment_id = p.punishment_id
                  WHERE pp.patient_id = :patient_id
                  ORDER BY pp.punishment_date DESC';

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
            throw new CouldNotRetrievePunishmentException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}