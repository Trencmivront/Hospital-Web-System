<?php
    
// because json_encode returns either of them
function getDepartments(PDO $pdo) : array{

    $query = "SELECT dept_name, descrpt FROM Department";

    try{
        $result = $pdo->prepare($query);
        $result->execute();

        return $result->fetchAll();
    }catch(PDOException $e){
        throw new FetchDepartmentsException();
    }
}
?>