<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class DeleteAppointmentById {
    function execute(PDO $pdo): bool {
        $json = file_get_contents("php://input");
        $input = json_decode($json, true);

        $appointment_id = $input['appointment_id'] ?? null;

        if (!$appointment_id) {
            throw new CouldNotDeleteAppointmentException();
        }

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

            // First, find the doctor_schedule_id associated with this appointment
            // and verify it belongs to the current patient
            $checkQuery = "SELECT doctor_schedule_id, ap_status FROM Appointment WHERE appointment_id = :appointment_id AND patient_id = :patient_id";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([
                'appointment_id' => $appointment_id,
                'patient_id' => $patient_id
            ]);
            $appointment = $checkStmt->fetch();

            if (!$appointment || $appointment['ap_status'] !== 'ACTIVE') {
                throw new CouldNotDeleteAppointmentException();
            }

            $doctor_schedule_id = $appointment['doctor_schedule_id'];

            // save current database
            $pdo->beginTransaction();

            // Delete the appointment
            $deleteQuery = "DELETE FROM Appointment WHERE appointment_id = :appointment_id";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute(['appointment_id' => $appointment_id]);

            // Set doctor schedule back to active
            $updateQuery = "UPDATE Doctor_Schedule SET is_active = 1 WHERE doctor_schedule_id = :doctor_schedule_id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute(['doctor_schedule_id' => $doctor_schedule_id]);

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            // if error is in transaction, roll_back
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new CouldNotDeleteAppointmentException();
        } catch (ExpiredException $e) {
            throw new UserIsNotAuthenticatedException();
        }
    }
}