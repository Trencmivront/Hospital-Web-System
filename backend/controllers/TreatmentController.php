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
                case 'manage_all': {
                    $getAll = new GetAllTreatments();
                    $data = $getAll->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'create': {
                    $create = new CreateTreatment();
                    $data = $create->execute($pdo);
                    echo responseEntity($data, 201);
                }
                break;
                case 'update': {
                    $update = new UpdateTreatment();
                    $data = $update->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'delete': {
                    $delete = new DeleteTreatment();
                    $data = $delete->execute($pdo);
                    echo responseEntity('', 204);
                }
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }
