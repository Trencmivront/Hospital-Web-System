<?php
require_once '../dbConnect.php';

// include required files
foreach (glob("../services/patient_punishment/*/*.php") as $filename) {
    require_once $filename;
}
foreach (glob("../exceptions/patient_punishment/*.php") as $filename){
    require_once $filename;
}

class PatientPunishmentController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all' : {
                $getAll = new GetAllPatientPunishments();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'create' : {
                $create = new CreatePatientPunishment();
                $data = $create->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'update' : {
                $update = new UpdatePatientPunishment();
                $data = $update->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'delete' : {
                $delete = new DeletePatientPunishment();
                $data = $delete->execute($pdo);
                echo responseEntity($data);
            }
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
