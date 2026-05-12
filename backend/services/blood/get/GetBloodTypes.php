<?php

class GetBloodTypes {
   // fetch blood types
   function execute(PDO $pdo) : array {
      $query = 'SELECT blood_id, type_name FROM Blood_Type';
      try{
         $result = $pdo->query($query);
         $data = $result->fetchAll(PDO::FETCH_ASSOC);
         
         return $data;
      }catch(PDOException $e){
         throw new FetchBloodException();
      }
   } 
}