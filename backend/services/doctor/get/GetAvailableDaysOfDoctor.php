<?php

    class GetAvailableDaysOfDoctor {
    function execute(PDO $pdo): array {
        $doctorId = $_GET['doctor_id'] ?? '';

        try {
            // Get available dates for the selected doctor
            // A date is available if there is at least one active schedule slot 
            // that doesn't have an appointment yet.
            $query = "SELECT DISTINCT s.s_date 
                      FROM Schedule s
                      JOIN Doctor_Schedule ds ON s.schedule_id = ds.schedule_id
                      LEFT JOIN Appointment a ON ds.doctor_schedule_id = a.doctor_schedule_id
                      WHERE ds.doctor_id = :doctor_id 
                        AND ds.is_active = 1 
                        AND a.appointment_id IS NULL
                        AND s.s_date >= CURDATE()
                      ORDER BY s.s_date ASC";

            $stmt = $pdo->prepare($query);
            $stmt->execute(['doctor_id' => $doctorId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new FetchScheduleException();
        }
    }
}