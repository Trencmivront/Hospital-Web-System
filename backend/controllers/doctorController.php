<?php
require '../dbConnect.php';

foreach (glob("../services/doctor/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/doctor/*.php") as $filename){
    require_once $filename;
}
header("Content-Type: application/json; charset=utf-8");

$action = $_GET['action'];

$data = [];

// catching all exceptions
try{
    switch($action){

        case 'GetDoctors':{
            $data = getDoctors($pdo);
            http_response_code(200);
            echo responseEntity($data);
        };
        break;
        
        case 'GetAvailableDoctors':{
            $data = GetAvailableDoctors($pdo);
            http_response_code(200);
            echo responseEntity($data);
        };
        break;

        case 'filterDoctorsByName':{
            $data = filterDoctorsByName($pdo);
            http_response_code(200);
            echo responseEntity($data);
        };
        break;

}

}catch(FetchDoctorException $e){  
    http_response_code($e->getCode());
    echo responseEntity($e->getMessage());
} 

?>