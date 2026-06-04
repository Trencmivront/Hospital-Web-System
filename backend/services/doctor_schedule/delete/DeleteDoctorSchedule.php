<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class DeleteDoctorSchedule {
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

            if (!$doctor_schedule_id) {
                throw new CouldNotRetrieveAdminDataException();
            }

            $query = "DELETE FROM Doctor_Schedule WHERE doctor_schedule_id = :doctor_schedule_id";

            $statement = $pdo->prepare($query);
            $statement->execute(['doctor_schedule_id' => $doctor_schedule_id]);

            return true;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
