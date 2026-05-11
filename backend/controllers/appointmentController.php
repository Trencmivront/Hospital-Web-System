<?php
    require_once '../dbConnect.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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

    use Firebase\JWT\ExpiredException;

    $action = $_GET['action'] ?? '';
    $data = [];

    try{
        switch($action){
            case 'getAppointmentsOfPatient':{
                $data = getAppointmentsOfPatient($pdo);
                echo responseEntity($data);
            };
            break;
            default:
                echo responseEntity(["error" => "Invalid action"], 400);
            break;
        }

    }catch(UserIsNotAuthenticatedException $e){
        echo responseEntity($e->getMessage(), 403);
    }catch(ExpiredException $e){
        echo responseEntity($e->getMessage(), 403);
    }catch(CouldNotRetrieveAppointmentDataException $e){
        echo responseEntity($e->getMessage(), $e->getCode() ?: 500);
    }catch(Throwable $e){
        echo responseEntity($e->getMessage(), $e->getCode() ?: 500);
    }


?>