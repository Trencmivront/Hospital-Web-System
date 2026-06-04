<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateBill {
    function execute(PDO $pdo): bool {
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

            $json = file_get_contents("php://input");
            $input = json_decode($json, true);

            $bill_id = $input['bill_id'] ?? null;
            $treatment_id = $input['treatment_id'] ?? null;
            $cost = $input['cost'] ?? null;
            $is_paid = $input['is_paid'] ?? null;

            if (!$bill_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Bill 
                      SET treatment_id = :treatment_id, cost = :cost, is_paid = :is_paid, updated_at = NOW()
                      WHERE bill_id = :bill_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'bill_id' => htmlspecialchars($bill_id),
                'treatment_id' => htmlspecialchars($treatment_id),
                'cost' => htmlspecialchars($cost),
                'is_paid' => htmlspecialchars($is_paid)
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
