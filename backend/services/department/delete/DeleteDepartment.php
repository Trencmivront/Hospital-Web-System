<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class DeleteDepartment {
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

            $dept_id = $input['dept_id'] ?? null;

            if (!$dept_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "DELETE FROM Department WHERE dept_id = :dept_id";

            $statement = $pdo->prepare($query);
            $statement->execute(['dept_id' => htmlspecialchars($dept_id)]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
