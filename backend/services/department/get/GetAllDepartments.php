<?php
    use Firebase\JWT\ExpiredException;
    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAllDepartments {
    function execute(PDO $pdo) : array{
        $query = "SELECT * FROM Department ORDER BY dept_name";

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
            throw new FetchDepartmentsException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}