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

            // check if the patient has any punishments
            // SQL IS A MIRACLE
            $query0 = " SELECT 1 FROM Patient_Punishment pp JOIN Punishment p ON 
            pp.punishment_id = p.punishment_id WHERE (pp.punishment_date + p.for_days) >= CURRENT_DATE()
            AND pp.patient_id = :patient_id";

            $response = $pdo->prepare($query0);
            $response->execute(['patient_id' => $patient_id]);

            $data = $response->fetchAll();
            // if there is value returned
            if($data){
                throw new PunishmentExistsException();
            }

            // better than "checkpoint exec" command
            $pdo->beginTransaction();

            // First status will always be ACTIVE
            $query1 = "INSERT INTO Appointment (patient_id, doctor_schedule_id, ap_status, updated_at, created_at)
                      VALUES (:patient_id, :doctor_schedule_id, 'ACTIVE', NOW(), NOW())";

            $query2 = "UPDATE Doctor_Schedule SET is_active=0, updated_at = NOW()
            WHERE doctor_schedule_id= :doctor_schedule_id";

            $statement = $pdo->prepare($query1);
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
