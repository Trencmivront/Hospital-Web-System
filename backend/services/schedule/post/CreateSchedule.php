<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateSchedule {
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

            $s_date = $input['s_date'] ?? null;
            $s_time = $input['s_time'] ?? null;

            if (!$s_date || !$s_time) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Schedule (s_date, s_time, updated_at, created_at)
                      VALUES (:s_date, :s_time, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                's_date' => htmlspecialchars($s_date),
                's_time' => htmlspecialchars($s_time)
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
