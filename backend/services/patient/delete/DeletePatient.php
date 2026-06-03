<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../get/JWToken.php";

class DeletePatient {
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

            $patient_id = $input['patient_id'] ?? null;

            if (!$patient_id) {
                throw new NullInputsException();
            }

            $patient_id = htmlspecialchars($patient_id);

            // Start transaction
            $pdo->beginTransaction();

            // Find active appointments to release the schedules
            $findSchedulesQuery = "SELECT doctor_schedule_id FROM Appointment WHERE patient_id = :patient_id AND ap_status = 'ACTIVE'";
            $findStmt = $pdo->prepare($findSchedulesQuery);
            $findStmt->execute(['patient_id' => $patient_id]);
            $schedules = $findStmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($schedules)) {
                $placeholders = implode(',', array_fill(0, count($schedules), '?'));
                $updateScheduleQuery = "UPDATE Doctor_Schedule SET is_active = 1 WHERE doctor_schedule_id IN ($placeholders)";
                $updateStmt = $pdo->prepare($updateScheduleQuery);
                $updateStmt->execute($schedules);
            }

            $query = "DELETE FROM Patient WHERE patient_id = :patient_id";
            $statement = $pdo->prepare($query);
            $statement->execute(['patient_id' => $patient_id]);

            if ($statement->rowCount() === 0) {
                $pdo->rollBack();
                throw new UserNotFoundException();
            }

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new CouldNotDeletePatientException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
