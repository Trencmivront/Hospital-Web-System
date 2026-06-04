<?php
    require_once '../dbConnect.php';

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
                case 'manage_all': {
                    $getAll = new GetAllPunishments();
                    $data = $getAll->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'create': {
                    $create = new CreatePunishment();
                    $data = $create->execute($pdo);
                    echo responseEntity($data, 201);
                }
                break;
                case 'update': {
                    $update = new UpdatePunishment();
                    $data = $update->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'delete': {
                    $delete = new DeletePunishment();
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
