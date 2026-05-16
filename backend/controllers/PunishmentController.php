<?php
    require_once '../dbConnect.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    foreach(glob("../services/punishment/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/punishment/*.php") as $fileName){
        require_once $fileName;
    }

    // Ensure patient exceptions are loaded
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    class PunishmentController {
        function execute($action = ''){
            global $pdo;
            $data = [];
            switch($action){
                case 'byPatient':{
                    $getPunishmentByPatient = new GetPunishmentByPatient();
                    $data = $getPunishmentByPatient->execute($pdo);
                    echo responseEntity($data);
                };
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }
