<?php

class GetActiveScheduleByDate {
    function execute(PDO $pdo): array {
        $doctorId = $_GET['doctor_id'] ?? '';
        $date = $_GET['date'] ?? '';

        try {
            $query = "SELECT s.s_time, ds.doctor_schedule_id FROM Schedule s
            JOIN Doctor_Schedule ds ON s.schedule_id = ds.schedule_id
            JOIN Doctor d ON d.doctor_id = ds.doctor_id WHERE 
            ds.is_active AND ds.doctor_id = :doctor_id  AND s.s_date = :date
            ORDER BY s.s_time ASC";

            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'doctor_id' => $doctorId,
                'date' => $date
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new FetchScheduleException();
        }
    }
}
