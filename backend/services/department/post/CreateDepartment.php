<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateDepartment {
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

            $dept_name = $input['dept_name'] ?? null;
            $descrpt = $input['descrpt'] ?? null;
            $img_path = $input['img_path'] ?? null;

            if (!$dept_name) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Department (dept_name, descrpt, img_path, updated_at, created_at)
                      VALUES (:dept_name, :descrpt, :img_path, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'dept_name' => htmlspecialchars($dept_name),
                'descrpt' => $descrpt ? htmlspecialchars($descrpt) : null,
                'img_path' => $img_path ? htmlspecialchars($img_path) : null
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
