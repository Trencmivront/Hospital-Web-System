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
header("Content-Type: application/json; charset=utf-8");

$action = $_GET['action'] ?? '';

$data = [];

try{

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
        $data = verifyCode($pdo);
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
}
// IN SPRING BOOT THERE WOULD BE A FILE TO HANDEL EXCEPTIONS
// INSTEAD, I HAVE TO WRITE THEM LIKE THIS IN PHP (idk if there is a solution)
}catch(CouldNotRetrievePatientDataException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}catch(UserNotFoundException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}catch(IncorrectPasswordException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}catch(NullEmailException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}catch(NullPasswordException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}catch(CouldNotSendEmailException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}

?>
