<?php

class FilterDoctorsByName {
    function execute(PDO $pdo) : array {
        $name = $_GET['name'] ?? '';
        $name = htmlspecialchars($name);

        $query = 'SELECT d.doctor_id, d.first_name, d.last_name, s.spec_name 
                  FROM Doctor d
                  LEFT JOIN Specialization s ON s.spec_id = d.spec_id
                  WHERE d.first_name LIKE :name OR d.last_name LIKE :name
                  OR s.spec_name LIKE :name';

        try {
            $statement = $pdo->prepare($query);
            $statement->execute(['name' => '%' . $name . '%']);
            $data = $statement->fetchAll();
            return $data;
        } catch (PDOException $e) {
            throw new FetchDoctorException();
        }
    }
}
