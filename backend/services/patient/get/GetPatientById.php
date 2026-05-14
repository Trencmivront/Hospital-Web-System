<?php

class GetPatientById {
    function execute(PDO $pdo, int $patient_id) : array {
        $query = 'SELECT first_name, last_name, tc_no, birth_date, gender_name, blood_id,
                         phone_num, email, is_email_verified
                  FROM Patient WHERE patient_id = :patient_id';

        try {
            $statement = $pdo->prepare($query);
            $statement->execute(['patient_id' => $patient_id]);
            $patient = $statement->fetch();

            if (!$patient) {
                throw new CouldNotRetrievePatientDataException();
            }

            return $patient;
        } catch (PDOException $e) {
            throw new CouldNotRetrievePatientDataException();
        }
    }
}
