<?php
    require_once '../dbConnect.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    foreach(glob("../services/appointment/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/appointment/*.php") as $fileName){
        require_once $fileName;
    }

    // Ensure patient exceptions are loaded
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    
    class AppointmentController {
        function execute($action = ''){
            // global variables are not accessible in class methods by default
            // so using global + varname fixes this problem
            global $pdo;
            $data = [];
            switch($action){
                case 'ofPatient':{
                    $getAppointmentsOfPatient = new GetAppointmentsOfPatient();
                    $data = $getAppointmentsOfPatient->execute($pdo);
                    echo responseEntity($data);
                };
                break;
                default:
                    echo responseEntity(["error" => "Invalid action"], 400);
                break;
            }
        }

    }
    
