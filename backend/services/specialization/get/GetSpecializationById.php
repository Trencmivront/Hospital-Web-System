<?php

    class GetSpecializationById{
        function execute(PDO $pdo) : array {

            $query = 'SELECT * FROM Specialization WHERE spec_id = :spec_id';

            try{

                $spec_id = $_GET['spec_id'];

                $response = $pdo->prepare($query);
                $response->execute(['spec_id' => $spec_id]);
                // should return only one value
                return $response->fetch();
            }catch(PDOException $e){
                throw new FetchSpecializationException();
            }
        }
    }