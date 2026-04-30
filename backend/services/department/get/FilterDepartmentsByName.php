<?php
    function filterDepartmentsByName(PDO $pdo) : array{
        $name = $_GET["name"];

        $query = "SELECT dept_name, descrpt FROM department
        WHERE dept_name LIKE '%$name%'";

        try{
            $result = $pdo->query($query);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $e){
            throw new FetchDepartmentsException();
        }
    }
   
?>