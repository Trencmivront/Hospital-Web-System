<?php

require_once "../dbConnect.php";

foreach(glob("../services/specialization/*/*.php") as $filename){
    require_once $filename;
}

foreach(glob("../exceptions/specialization/*.php") as $filename){
    require_once $filename;
}

class SpecializationController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all': {

            }
            break;
            case 'byId': {
                $getSpecializationById = new GetSpecializationById();
                $data = $getSpecializationById->execute($pdo);
                echo responseEntity($data);
            }
            break;
        }

    }

}