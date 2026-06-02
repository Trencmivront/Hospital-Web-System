<?php
    use Firebase\JWT\ExpiredException;
    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAllPatientPunishments {
    function execute(PDO $pdo) : array{
        $query = "SELECT * FROM Patient_Punishment ORDER BY punishment_date DESC";

        if(!isset($_SESSION['admin_jwt'])){
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try{
            $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
            $admin_role = $jwtContents->role;

            if(empty($admin_role) || $admin_role != "ADMIN"){
                throw new UserIsNotAuthenticatedException();
            }

            $result = $pdo->prepare($query);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw new CouldNotRetrievePunishmentException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}