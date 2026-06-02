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
                $getAll = new GetAllSpecializations();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'create': {
                $create = new CreateSpecialization();
                $data = $create->execute($pdo);
                echo responseEntity($data, 201);
            }
            break;
            case 'update': {
                $update = new UpdateSpecialization();
                $data = $update->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'delete': {
                $delete = new DeleteSpecialization();
                $data = $delete->execute($pdo);
                echo responseEntity('', 204);
            }
            break;
            case 'byId': {
                $getSpecializationById = new GetSpecializationById();
                $data = $getSpecializationById->execute($pdo);
                echo responseEntity($data);
            }
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }

    }

}