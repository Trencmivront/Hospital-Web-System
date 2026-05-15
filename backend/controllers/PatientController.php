<?php
require_once '../dbConnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

foreach (glob("../services/patient/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/patient/*.php") as $filename){
    require_once $filename;
}

class PatientController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'create' : {
                // Implementation for registration
            };
            break;

            case 'login': {
                $logIn = new LogIn();
                $data = $logIn->execute($pdo);
                echo responseEntity($data);
                // after this, drive user to the code input page
            };
            break;

            case 'verifyCode': {
                $verifyCode = new VerifyCode();
                $data = $verifyCode->execute();
                echo responseEntity($data);
                // if code is verified, create patient jwt
            };
            break;

            case 'jwt': {
                $createPatientJwt = new CreatePatientJwt();
                echo responseEntity($createPatientJwt->execute($pdo));
                // if this one is true as well, we have our patient authenticated and logged in
            }
            break;

            case 'resendCode': {
                $sendCode = new SendCode();
                echo responseEntity($sendCode->execute($_SESSION['email_jwt']));
            }
            break;

            case 'logout': {
                $logout = new LogOut();
                echo responseEntity($logout->execute());
            }   
            break;

            case 'byId': {
                $getPatientById = new GetPatientById();
                $data = $getPatientById->execute($pdo);
                echo responseEntity($data);
            }
            break;

            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
