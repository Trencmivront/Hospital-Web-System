<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class DeleteSpecialization {
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

            if (!$spec_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "DELETE FROM Specialization WHERE spec_id = :spec_id";

            $statement = $pdo->prepare($query);
            $statement->execute(['spec_id' => htmlspecialchars($spec_id)]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
