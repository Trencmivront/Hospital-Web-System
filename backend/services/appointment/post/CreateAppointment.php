<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class CreateAppointment {
    function execute(PDO $pdo): bool {
        $json = file_get_contents("php://input");
        $input = json_decode($json, true);

        $doctor_schedule_id = $input['doctor_schedule_id'] ?? null;

        if (!$doctor_schedule_id) {
            throw new CouldNotCreateAppointmentException();
        }

        $doctor_schedule_id = htmlspecialchars($doctor_schedule_id);

        if (!isset($_SESSION['patient_jwt'])) {
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try {
            $jwtContents = $jwt->openToken($_SESSION['patient_jwt']);

            $patient_id = $jwtContents->user_id;
            $patient_role = $jwtContents->role;

            if ((empty($patient_id) || empty($patient_role)) || ($patient_role != "PATIENT")) {
                throw new UserIsNotAuthenticatedException();
            }

            // better than "checkpoint exec" command
            $pdo->beginTransaction();

            // First status will always be ACTIVE
            $query = "INSERT INTO Appointment (patient_id, doctor_schedule_id, ap_status)
                      VALUES (:patient_id, :doctor_schedule_id, 'ACTIVE')";

            $query2 = "UPDATE Doctor_Schedule SET is_active=0
            WHERE doctor_schedule_id= :doctor_schedule_id";

            $statement = $pdo->prepare($query);
            $statement->execute([
                'patient_id' => $patient_id,
                'doctor_schedule_id' => $doctor_schedule_id
            ]);

            $statement2 = $pdo->prepare($query2);
            $statement2->execute([
                'doctor_schedule_id' => $doctor_schedule_id
            ]);
            // end transaction and commit changes
            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            // if error was in transaction
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new CouldNotCreateAppointmentException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}
