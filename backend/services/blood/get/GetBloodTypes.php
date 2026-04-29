<?php
// fetch blood types
   function getBloodTypes(PDO $pdo) : array {
        $query = 'SELECT blood_id, type_name FROM blood_type';

        $result = $pdo->query($query);

        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        return $data;
   } 
?>