<?php
    require_once '../dbConnect.php';
    
    foreach(glob("../services/appointment/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/appointment/*.php") as $fileName){
        require_once $fileName;
    }

    // Ensure patient exceptions are loaded
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    
    class AppointmentController {
        function execute($action = ''){
            // global variables are not accessible in class methods by default
            // so using global + varname fixes this problem
            global $pdo;
            $data = [];
            switch($action){
                case 'all':{
                    $getAllAppointments = new GetAllAppointments();
                    $data= $getAllAppointments->execute($pdo);
                    echo responseEntity($data);
                }   
                break;
                case 'create' :{
                    $createAppointment = new CreateAppointment();
                    $data = $createAppointment->execute($pdo);
                    echo responseEntity($data, 201);
                }
                break;
                case 'update': {
                    $update = new UpdateAppointmentAdmin();
                    $data = $update->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'delete' :{
                    $deleteAppointment = new DeleteAppointmentAdmin();
                    $data = $deleteAppointment->execute($pdo);
                    echo responseEntity('', 204);
                }
                break;
                case 'ofPatient':{
                    $getAppointmentsOfPatient = new GetAppointmentsOfPatient();
                    $data = $getAppointmentsOfPatient->execute($pdo);
                    echo responseEntity($data);
                };
                break;
                case 'cancel' :{
                    $cancelAppointment = new CancelAppointmentById();
                    $data = $cancelAppointment->execute($pdo);
                    echo responseEntity('', 204);
                }
                break;
                case 'getToday' :{
                    $getTodaysAppointments = new GetTodaysAppointments();
                    $data = $getTodaysAppointments->execute($pdo);
                    echo responseEntity($data);
                } 
                break;

                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }

    }
