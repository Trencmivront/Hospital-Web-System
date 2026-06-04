<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateDoctor {
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

            $first_name = $input['first_name'] ?? null;
            $last_name = $input['last_name'] ?? null;
            $phone_num = $input['phone_num'] ?? null;
            $email = $input['email'] ?? null;
            $gender_name = $input['gender_name'] ?? null;
            $dept_id = $input['dept_id'] ?? null;
            $spec_id = $input['spec_id'] ?? null;
            $img_path = $input['img_path'] ?? null;

            if (!$first_name || !$last_name || !$phone_num || !$spec_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Doctor (first_name, last_name, phone_num, email, gender_name, dept_id, spec_id, img_path, updated_at, created_at)
                      VALUES (:first_name, :last_name, :phone_num, :email, :gender_name, :dept_id, :spec_id, :img_path, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'first_name' => htmlspecialchars($first_name),
                'last_name' => htmlspecialchars($last_name),
                'phone_num' => htmlspecialchars($phone_num),
                'email' => $email ? htmlspecialchars($email) : null,
                'gender_name' => $gender_name ? htmlspecialchars($gender_name) : null,
                'dept_id' => $dept_id ? htmlspecialchars($dept_id) : null,
                'spec_id' => htmlspecialchars($spec_id),
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
