<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateBill {
    function execute(PDO $pdo): string|bool {
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

            $treatment_id = $input['treatment_id'] ?? null;
            $cost = $input['cost'] ?? null;
            $is_paid = $input['is_paid'] ?? 0;

            if (!$treatment_id || $cost === null) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Bill (treatment_id, cost, is_paid, updated_at, created_at)
                      VALUES (:treatment_id, :cost, :is_paid, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'treatment_id' => htmlspecialchars($treatment_id),
                'cost' => htmlspecialchars($cost),
                'is_paid' => htmlspecialchars($is_paid)
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
