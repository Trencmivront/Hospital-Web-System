<?php
require_once '../dbConnect.php';

foreach (glob("../services/doctor/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/doctor/*.php") as $filename){
    require_once $filename;
}

class DoctorController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'GetDoctors':{
                $getDoctors = new GetDoctors();
                $data = $getDoctors->execute($pdo);
                echo responseEntity($data);
            };
            break;
            
            case 'GetAvailableDoctors':{
                $getAvailableDoctors = new GetAvailableDoctors();
                $data = $getAvailableDoctors->execute($pdo);
                echo responseEntity($data);
            };
            break;

            case 'filterDoctorsByName':{
                $filterDoctorsByName = new FilterDoctorsByName();
                $data = $filterDoctorsByName->execute($pdo);
                echo responseEntity($data);
            };
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
