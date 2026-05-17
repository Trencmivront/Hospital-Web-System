<?php
    
class GetDepartments {
    // because json_encode returns either of them
    function execute(PDO $pdo) : array{

        $query = "SELECT dept_id, dept_name, descrpt FROM Department ORDER BY dept_name";

        try{
            $result = $pdo->prepare($query);
            $result->execute();

            return $result->fetchAll();
        }catch(PDOException $e){
            throw new FetchDepartmentsException();
        }
    }
}