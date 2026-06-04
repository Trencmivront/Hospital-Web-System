<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetAllBills {
    function execute(PDO $pdo): array {
        if (!isset($_SESSION['admin_jwt'])) {
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();
        try {
            $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
            $admin_role = $jwtContents->role;
            if (empty($admin_role) || $admin_role != "ADMIN") {
                throw new UserIsNotAuthenticatedException();
            }

            $query = 'SELECT b.bill_id, b.treatment_id, b.cost, b.is_paid, b.updated_at, b.created_at 
                      FROM Bill b';

            $result = $pdo->query($query);
            $data = $result->fetchAll();
            return $data;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveBillDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
