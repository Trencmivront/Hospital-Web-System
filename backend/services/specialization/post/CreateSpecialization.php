<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateSpecialization {
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

            $spec_name = $input['spec_name'] ?? null;

            if (!$spec_name) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Specialization (spec_name, updated_at, created_at)
                      VALUES (:spec_name, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute(['spec_name' => htmlspecialchars($spec_name)]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
