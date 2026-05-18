<?php

use Firebase\JWT\ExpiredException;

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class GetPayedBillsByMonth {
    function execute(PDO $pdo) : array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_jwt'])) {
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();
        $query = "SELECT SUM(cost) as monthly_revenue, MONTH(update_date) as month 
                  FROM Bill 
                  WHERE is_paid = 1 AND YEAR(update_date) = YEAR(CURRENT_DATE()) 
                  GROUP BY MONTH(update_date) 
                  ORDER BY MONTH(update_date) ASC";

        try {
            $jwt->openToken($_SESSION['admin_jwt']);
            $result = $pdo->query($query);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            throw new FetchBillException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}
