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
        echo responseEntity(logIn($pdo));
        // after this, drive user to the code input page
    };
    break;

    case 'verifyCode': {
        echo responseEntity(verifyCode());
    };
    break;
}

}catch(Exception $e){
    http_response_code($e->getCode() ?: 500);
    // Assuming responseEntity is a function that returns a JSON string or array
    echo json_encode(["error" => $e->getMessage()]);
}
?>
