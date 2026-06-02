<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class UpdateDoctorSchedule {
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

            $doctor_schedule_id = $input['doctor_schedule_id'] ?? null;
            $schedule_id = $input['schedule_id'] ?? null;
            $doctor_id = $input['doctor_id'] ?? null;
            $is_active = $input['is_active'] ?? null;

            if (!$doctor_schedule_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "UPDATE Doctor_Schedule 
                      SET schedule_id = COALESCE(:schedule_id, schedule_id),
                          doctor_id = COALESCE(:doctor_id, doctor_id),
                          is_active = COALESCE(:is_active, is_active),
                          updated_at = NOW()
                      WHERE doctor_schedule_id = :doctor_schedule_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'doctor_schedule_id' => $doctor_schedule_id,
                'schedule_id' => $schedule_id,
                'doctor_id' => $doctor_id,
                'is_active' => $is_active
            ]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
