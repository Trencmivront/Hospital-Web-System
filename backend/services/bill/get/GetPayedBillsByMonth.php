<?php

use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetPayedBillsByMonth {
    function execute(PDO $pdo) : array {

        if (!isset($_SESSION['admin_jwt'])) {
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();
        $query = "SELECT SUM(cost) as monthly_revenue, MONTH(updated_at) as month 
                  FROM Bill 
                  WHERE is_paid = 1 AND YEAR(updated_at) = YEAR(CURRENT_DATE()) 
                  GROUP BY MONTH(updated_at) 
                  ORDER BY MONTH(updated_at) ASC";

        try {
            $jwt->openToken($_SESSION['admin_jwt']);
            $result = $pdo->query($query);
            $data = $result->fetchAll();
            return $data;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveBillDataException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}
