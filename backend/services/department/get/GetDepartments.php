<?php
    
// because json_encode returns either of them
function getDepartments(PDO $pdo) : array{

    $query = 'SELECT dept_name, descrpt FROM department';

    try{
        $result = $pdo->query($query);
        // Normally it contains values with index and name at their
        // left side but FETCH_ASSOC removes lines with index, reducing size.
        $data = $result->fetchAll(PDO::FETCH_ASSOC); // Gets array of elements.
        return $data;
    }catch(PDOException $e){
        throw new FetchDepartmentsException();
    } 
} 
?>