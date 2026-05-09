<?php

require '../dbConnect.php';

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
        session_destroy();
        session_abort();
    }   
    break;
}

}catch(Exception $e){
    http_response_code($e->getCode() ?: 500);
    // Assuming responseEntity is a function that returns a JSON string or array
    echo json_encode(["error" => $e->getMessage()]);
}
catch(CouldNotRetrievePatientDataException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}
catch(UserNotFoundException $e){
    echo responseEntity($_POST['email'], $e->getCode());
}
catch(IncorrectPasswordException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}
?>
