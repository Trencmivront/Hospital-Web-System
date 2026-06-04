<?php
require_once '../dbConnect.php';

// include required files
foreach (glob("../services/blood/*/*.php") as $filename) {
    require_once $filename;
}
foreach (glob("../exceptions/blood/*.php") as $filename){
    require_once $filename;
}

class BloodTypeController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'types' : {
                $getBloodTypes = new GetBloodTypes();
                $data = $getBloodTypes->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'manage_all' : {
                $getAll = new GetAllBloodTypes();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            }
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
