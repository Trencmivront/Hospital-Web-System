<?php
    
function getDepartments(PDO $pdo) : array{

    $query =   'SELECT D.doctor_id, D.first_name, D.last_name , s.name  FROM doctor D
                join doctor_specialization ds on D.doctor_id = ds.doctor_id 
                join specialization s on ds.spec_id = s.spec_id ';

    try{
        $result = $pdo->query($query);
        // Normally it contains values with index and name at their
        // left side but FETCH_ASSOC removes lines with index, reducing size.
        $data = $result->fetchAll(PDO::FETCH_ASSOC); // Gets array of elements.
        return $data;
    }catch(PDOException $e){
        throw new FetchDoctorException();
    } 
} 
?>