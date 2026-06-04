<?php
require_once '../dbConnect.php';

// include required files
foreach (glob("../services/doctor_schedule/*/*.php") as $filename) {
    require_once $filename;
}
foreach (glob("../exceptions/doctor_schedule/*.php") as $filename){
    require_once $filename;
}

class DoctorScheduleController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all' : {
                $getAll = new GetAllDoctorSchedules();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'create' : {
                $create = new CreateDoctorSchedule();
                $data = $create->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'update' : {
                $update = new UpdateDoctorSchedule();
                $data = $update->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'delete' : {
                $delete = new DeleteDoctorSchedule();
                $data = $delete->execute($pdo);
                echo responseEntity($data);
            }
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
