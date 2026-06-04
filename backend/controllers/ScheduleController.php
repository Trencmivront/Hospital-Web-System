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
            case 'manage_all': {
                $getAll = new GetAllSchedules();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'create': {
                $create = new CreateSchedule();
                $data = $create->execute($pdo);
                echo responseEntity($data, 201);
            }
            break;
            case 'update': {
                $update = new UpdateSchedule();
                $data = $update->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'delete': {
                $delete = new DeleteSchedule();
                $data = $delete->execute($pdo);
                echo responseEntity('', 204);
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
