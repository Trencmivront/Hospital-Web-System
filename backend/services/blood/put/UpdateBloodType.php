<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateBloodType {
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

            $blood_id = $input['blood_id'] ?? null;
            $type_name = $input['type_name'] ?? null;

            if (!$blood_id || !$type_name) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Blood_Type 
                      SET type_name = :type_name, updated_at = NOW()
                      WHERE blood_id = :blood_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'blood_id' => $blood_id,
                'type_name' => htmlspecialchars($type_name)
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
