<?php
    include '../dbConnect.php';
    // load all php files inside services/department
    foreach (glob("../services/department/*/*.php") as $filename) {
        require_once $filename;
    }
    header("Content-Type: application/json; charset=utf-8");

    $action = $_GET['action'];

    $data = [];

    // catching all exceptions
    try{
        switch($action){

            case 'getDepartments':{
                $data = getDepartments($pdo);
                
                http_response_code(200);
                echo responseEntity($data);
            };
            break;

            case 'filterDepartmentsByName':{
                $data = filterDepartmentsByName($pdo);
                // if no exception, then
                http_response_code(200);
                // turn dataset into json form;
                echo responseEntity($data);
            };
            break;
    }

    }catch(FetchDepartmentsException $f){  
        http_response_code($f->getCode());
        echo responseEntity($f);
    }

    

    // for simplifying the code
    function responseEntity($dataSet){
        return json_encode($dataSet, JSON_UNESCAPED_UNICODE);
    }

?>