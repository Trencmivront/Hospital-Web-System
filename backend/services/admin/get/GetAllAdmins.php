<?php
    use Firebase\JWT\ExpiredException;
    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAllAdmins {
    function execute(PDO $pdo) : array{
        $query = "SELECT * FROM Admin ORDER BY username";

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
            throw new CouldNotRetrieveAdminDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}