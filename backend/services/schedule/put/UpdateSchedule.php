<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateSchedule {
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

            $schedule_id = $input['schedule_id'] ?? null;
            $s_date = $input['s_date'] ?? null;
            $s_time = $input['s_time'] ?? null;

            if (!$schedule_id || !$s_date || !$s_time) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Schedule 
                      SET s_date = :s_date, s_time = :s_time, updated_at = NOW()
                      WHERE schedule_id = :schedule_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'schedule_id' => htmlspecialchars($schedule_id),
                's_date' => htmlspecialchars($s_date),
                's_time' => htmlspecialchars($s_time)
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
