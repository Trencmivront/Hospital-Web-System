<?php
    require_once '../dbConnect.php';

    foreach(glob("/backend/services/appointment/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/appointment/*.php") as $fileName){
        require_once $fileName;
    }

    header("Content-Type: application/json; charset=utf-8");

    $action = $_GET['action'];
    $data = [];

    switch($action){
        case 'getAppointmentsOfPatient':;
            break;
    }

?>