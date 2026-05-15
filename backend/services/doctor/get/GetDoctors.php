<?php
    
class GetDoctors {
    function execute(PDO $pdo) : array{

        $query = 'SELECT d.doctor_id, d.first_name, d.last_name FROM Doctor d';

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
}