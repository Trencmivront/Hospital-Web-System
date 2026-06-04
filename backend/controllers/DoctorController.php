<?php
require_once '../dbConnect.php';

foreach (glob("../services/doctor/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/doctor/*.php") as $filename){
    require_once $filename;
}

class DoctorController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all':{
                $getDoctors = new GetDoctors();
                $data = $getDoctors->execute($pdo);
                echo responseEntity($data);
            };
            break;

            case 'manage_all':{
                $getAll = new GetAllDoctorsAdmin();
                $data = $getAll->execute($pdo);
                echo responseEntity($data);
            };
            break;
            
            case 'byDepartment':{
                $getDoctorsByDepartment = new GetDoctorsByDepartment();
                $data = $getDoctorsByDepartment->execute($pdo);
                echo responseEntity($data);
            };
            break;

            case 'byName':{
                $filterDoctorsByName = new FilterDoctorsByName();
                $data = $filterDoctorsByName->execute($pdo);
                echo responseEntity($data);
            };
            break;

            case 'available':{
                $getAvailableDoctors = new GetAvailableDoctors();
                $data = $getAvailableDoctors->execute($pdo);
                echo responseEntity($data);
            }
            break;

            case 'availableDays':{
                $getAvailableDaysOfDoctor = new GetAvailableDaysOfDoctor();
                $data = $getAvailableDaysOfDoctor->execute($pdo);
                echo responseEntity($data);
            };
            break;
            case 'appointmentCountOfEach' : {
                    $getActiveAppointmentCountOfDoctors = new GetActiveAppointmentCountOfDoctors();
                    $data = $getActiveAppointmentCountOfDoctors->execute($pdo);
                    echo responseEntity($data);
                }
                break;
            case 'create': {
                $create = new CreateDoctor();
                $data = $create->execute($pdo);
                echo responseEntity($data, 201);
            }
            break;
            case 'update': {
                $update = new UpdateDoctor();
                $data = $update->execute($pdo);
                echo responseEntity($data);
            }
            break;
            case 'delete': {
                $delete = new DeleteDoctor();
                $data = $delete->execute($pdo);
                echo responseEntity('', 204);
            }
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
