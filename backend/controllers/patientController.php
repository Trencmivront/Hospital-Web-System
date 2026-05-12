<?php
require '../dbConnect.php';

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

$action = $_GET['action'] ?? '';

$data = [];

switch($action){
    case 'createPatient' : {
        // Implementation for registration
    };
    break;

    case 'logIn': {
        $data = logIn($pdo);
        echo responseEntity($data);
        // after this, drive user to the code input page
    };
    break;

    case 'verifyCode': {
        $data = verifyCode();
        echo responseEntity($data);
        // if code is verified, create patient jwt
    };
    break;

    case 'createPatientJwt': {
        $data = createPatientJwt($pdo);
        echo responseEntity($data);
        // if this one is true as well, we have our patient authenticated and logged in
    }
    break;

    case 'resendCode': {
        // you don't need to read rest
        // This function is taken from LogIn.php
        $data = sendCode($_SESSION['email_jwt']);
        echo responseEntity($data);
    }
    break;

    case 'logOut': {
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

    default: echo responseEntity("Nuh UH", 500);
    break;
}