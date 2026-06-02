<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateSpecialization {
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

            $spec_id = $input['spec_id'] ?? null;
            $spec_name = $input['spec_name'] ?? null;

            if (!$spec_id || !$spec_name) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Specialization 
                      SET spec_name = :spec_name, updated_at = NOW()
                      WHERE spec_id = :spec_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'spec_id' => htmlspecialchars($spec_id),
                'spec_name' => htmlspecialchars($spec_name)
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
