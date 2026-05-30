<?php

use Firebase\JWT\ExpiredException;

    class PayBillById {
        function execute(PDO $pdo){

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if(!isset($data->bill_id)){
                throw new NullInputsException();
            }

            $bill_id = $data->bill_id;

            $isAuthenticated = false;
            $jwt = new JWToken();

            // Check Patient Session
            if(isset($_SESSION['patient_jwt'])){
                try {
                    $jwtContents = $jwt->openToken($_SESSION['patient_jwt']);
                    if($jwtContents->role == "PATIENT"){
                        $isAuthenticated = true;
                    }
                } catch (Exception $e) {}
            }

            // Check Admin Session if not already authenticated
            if(!$isAuthenticated && isset($_SESSION['admin_jwt'])){
                try {
                    $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
                    if($jwtContents->role == "ADMIN"){
                        $isAuthenticated = true;
                    }
                } catch (Exception $e) {}
            }

            if(!$isAuthenticated){
                throw new UserIsNotAuthenticatedException();
            }

            try {
                $query = "UPDATE Bill SET is_paid = 1, updated_at = NOW() WHERE bill_id = :bill_id";
                $statement = $pdo->prepare($query);
                $statement->execute(['bill_id' => $bill_id]);

                return true;
            } catch (PDOException $e) {
                throw new CouldNotRetrieveBillDataException();
            }catch (ExpiredException $e){
                throw new UserIsNotAuthenticatedException();
            }
        }
    }