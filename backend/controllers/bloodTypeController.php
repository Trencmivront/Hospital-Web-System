<?php
    // I think require is better
    require '../dbConnect.php';

    // include required files
    foreach (glob("../services/blood/*/*.php") as $filename) {
        require_once $filename;
    }
    foreach (glob("../exceptions/blood/*.php") as $filename){
        require_once $filename;
    }
    header("Content-Type: application/json; charset=utf-8");

    $action = $_GET['action'];
    $data = [];

    try{
        switch($action){
            case 'getBloodTypes' : {
                $data = getBloodTypes($pdo);

                http_response_code(200);
                echo responseEntity($data);
            }
            break;
        }

    }catch(FetchBloodException $e){
        http_response_code($e->getCode());
        echo responseEntity($e->getMessage());
    }

    function responseEntity($dataSet){
        return json_encode($dataSet, JSON_UNESCAPED_UNICODE);
    }

?>