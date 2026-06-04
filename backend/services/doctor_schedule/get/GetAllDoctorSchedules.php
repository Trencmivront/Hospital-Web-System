<?php
    use Firebase\JWT\ExpiredException;
    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAllDoctorSchedules {
    function execute(PDO $pdo) : array{
        $query = "SELECT * FROM Doctor_Schedule ORDER BY doctor_id, schedule_id";

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
            // Use a generic exception or create a specific one
            throw new CouldNotRetrieveAdminDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}