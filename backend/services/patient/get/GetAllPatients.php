<?php
    use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/JWToken.php";

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

class GetAllPatients{
    function execute(PDO $pdo) : array{
        $query = 'SELECT * FROM Patient';

        if(!isset($_SESSION['admin_jwt'])){
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try{
            $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
            
            $admin_id = $jwtContents->user_id;
            $admin_role = $jwtContents->role;

            if((empty($admin_id) || empty($admin_role)) || ($admin_role != "ADMIN")){
                throw new UserIsNotAuthenticatedException();
            }

            $statement = $pdo->prepare($query);
            $statement->execute();

            $data = $statement->fetchAll();

            return $data;

        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}
