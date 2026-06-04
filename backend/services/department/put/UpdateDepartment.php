<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateDepartment {
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
            $dept_name = $input['dept_name'] ?? null;
            $descrpt = $input['descrpt'] ?? null;
            $img_path = $input['img_path'] ?? null;

            if (!$dept_id || !$dept_name) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Department 
                      SET dept_name = :dept_name, descrpt = :descrpt, img_path = :img_path, updated_at = NOW()
                      WHERE dept_id = :dept_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'dept_id' => htmlspecialchars($dept_id),
                'dept_name' => htmlspecialchars($dept_name),
                'descrpt' => $descrpt ? htmlspecialchars($descrpt) : null,
                'img_path' => $img_path ? htmlspecialchars($img_path) : null
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
