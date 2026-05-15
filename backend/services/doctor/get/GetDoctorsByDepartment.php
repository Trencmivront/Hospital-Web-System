<?php

class GetDoctorsByDepartment {
    function execute(PDO $pdo) : array{
        // get available doctors for selected department
        // requests must be made by patients, check for role during security update
        $deptId = $_GET['dept_id'] ?? ''; // taken from patient's choice

        try{
            // doctor_id is taken because once we get all doctors, we can get schedule of doctor
            // by using its id
            $query = "SELECT dr.doctor_id, dr.first_name, dr.last_name FROM Doctor dr
            JOIN Department dept ON dr.dept_id = dept.dept_id
            WHERE dept.dept_id = :dept_id";

            $response = $pdo->prepare($query);
            $response->execute(['dept_id' => $deptId]);

            return $response->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw new FetchDoctorException();
        }
    }
}