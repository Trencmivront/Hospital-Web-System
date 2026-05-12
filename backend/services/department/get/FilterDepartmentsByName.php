<?php

class FilterDepartmentsByName {

    function execute(PDO $pdo) : array {
            $name = $_GET["name"] ?? '';

            $name = htmlspecialchars($name);

            $query = "SELECT dept_name, descrpt FROM Department
            WHERE dept_name LIKE :name";

            try {
                $statement = $pdo->prepare($query);
                $statement->execute(['name' => "%$name%"]);
                
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $data;
            } catch (PDOException $e) {
                throw new FetchDepartmentsException();
            }
        }

}
    