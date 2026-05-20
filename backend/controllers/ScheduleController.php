<?php
require_once '../dbConnect.php';

// load all services regarding to this table
foreach (glob("../services/schedule/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/schedule/*.php") as $filename){
    require_once $filename;
}
class ScheduleController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all': {
                $getSchedules = new GetSchedules();
                $data = $getSchedules->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'allActive': {
                $getAllActiveSchedules = new GetAllActiveSchedules();
                $data = $getAllActiveSchedules->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'byDate': {
                $getActiveScheduleByDate = new GetActiveScheduleByDate();
                $data = $getActiveScheduleByDate->execute($pdo);
                echo responseEntity($data);
            }
            break;
            // Add cases here as services are implemented
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
