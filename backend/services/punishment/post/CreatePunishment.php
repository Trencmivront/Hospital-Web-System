<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreatePunishment {
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

            $reason = $input['reason'] ?? null;
            $for_days = $input['for_days'] ?? null;

            if (!$reason || !$for_days) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Punishment (reason, for_days, updated_at, created_at)
                      VALUES (:reason, :for_days, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'reason' => htmlspecialchars($reason),
                'for_days' => $for_days
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
