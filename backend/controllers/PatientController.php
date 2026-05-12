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
                $data = $createPatientJwt->execute($pdo);
                echo responseEntity($data);
                // if this one is true as well, we have our patient authenticated and logged in
            }
            break;

            case 'resendCode': {
                $sendCode = new SendCode();
                $data = $sendCode->execute($_SESSION['email_jwt']);
                echo responseEntity($data);
            }
            break;

            case 'logout': {
                // Erase all session content
                $_SESSION = array();
                
                // Erase session cookie
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }

                // destroy session on the backend
                session_destroy();
                echo json_encode(["success" => true]);
            }   
            break;

            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
