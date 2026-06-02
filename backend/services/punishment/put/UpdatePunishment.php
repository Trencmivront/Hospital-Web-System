<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdatePunishment {
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

            $punishment_id = $input['punishment_id'] ?? null;
            $reason = $input['reason'] ?? null;
            $for_days = $input['for_days'] ?? null;

            if (!$punishment_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Punishment 
                      SET reason = COALESCE(:reason, reason),
                          for_days = COALESCE(:for_days, for_days),
                          updated_at = NOW()
                      WHERE punishment_id = :punishment_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'punishment_id' => $punishment_id,
                'reason' => $reason ? htmlspecialchars($reason) : null,
                'for_days' => $for_days
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
