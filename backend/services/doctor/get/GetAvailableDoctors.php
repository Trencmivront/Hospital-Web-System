<?php

class GetAvailableDoctors {
    function execute(PDO $pdo) : array{
        // get available doctors for selected department
        // requests must be made by patients, check for role during security update
        $deptId = $_GET['dept_id'] ?? ''; // taken from patient's choice

        try{
            // doctor_id is taken because once we get all doctors, we can get schedule of doctor
            // by using its id
            $query = "SELECT dr.doctor_id, dr.first_name, dr.last_name FROM Doctor dr INNER JOIN Department dept
            ON dr.dept_id=dept.dept_id AND dept.dept_id = $deptId
            INNER JOIN Doctor_Schedule ds ON ds.doctor_id = dr.doctor_id
            WHERE ds.is_active = true GROUP BY dr.doctor_id;";

            $result = $pdo->query($query);

            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw new FetchDoctorException();
        }
    }
}