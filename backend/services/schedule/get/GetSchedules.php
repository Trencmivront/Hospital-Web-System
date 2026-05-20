<?php

class GetSchedules {
    function execute(PDO $pdo): array {
        try {
            $query = "SELECT schedule_id, s_date, TIME_FORMAT(s_time, '%H:%i') as s_time FROM Schedule ORDER BY s_date ASC, s_time ASC";
            $stmt = $pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new FetchScheduleException();
        }
    }
}
