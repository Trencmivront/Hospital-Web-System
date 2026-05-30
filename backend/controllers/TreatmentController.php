<?php
    require_once '../dbConnect.php';

    foreach(glob("../services/treatment/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/treatment/*.php") as $fileName){
        require_once $fileName;
    }

    // Ensure patient exceptions are loaded
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    class TreatmentController {
        function execute($action = ''){
            global $pdo;
            $data = [];
            switch($action){
                case 'ofPatient':{
                    $getTreatmentsByPatient = new GetTreatmentsByPatient();
                    $data = $getTreatmentsByPatient->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }
