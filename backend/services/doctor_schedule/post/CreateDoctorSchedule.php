<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateDoctorSchedule {
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

            $schedule_id = $input['schedule_id'] ?? null;
            $doctor_id = $input['doctor_id'] ?? null;
            $is_active = $input['is_active'] ?? 1;

            if (!$schedule_id || !$doctor_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "INSERT INTO Doctor_Schedule (schedule_id, doctor_id, is_active, updated_at, created_at)
                      VALUES (:schedule_id, :doctor_id, :is_active, NOW(), NOW())";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'schedule_id' => $schedule_id,
                'doctor_id' => $doctor_id,
                'is_active' => $is_active
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
