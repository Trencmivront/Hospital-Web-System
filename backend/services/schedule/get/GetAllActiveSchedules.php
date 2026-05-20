<?php

class GetAllActiveSchedules {
    function execute(PDO $pdo): array {
        try {
            $query = "SELECT ds.doctor_schedule_id, s.s_date, TIME_FORMAT(s.s_time, '%H:%i') as s_time, 
                             d.first_name as d_first_name, d.last_name as d_last_name, 
                             dept.dept_name
                      FROM Doctor_Schedule ds
                      JOIN Schedule s ON ds.schedule_id = s.schedule_id
                      JOIN Doctor d ON ds.doctor_id = d.doctor_id
                      JOIN Department dept ON d.dept_id = dept.dept_id
                      WHERE ds.is_active = 1
                      ORDER BY s.s_date ASC, s.s_time ASC";
            
            $stmt = $pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new FetchScheduleException();
        }
    }
}
