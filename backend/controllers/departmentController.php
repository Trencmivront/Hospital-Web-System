<?php
require '../dbConnect.php';
// load all php files inside services/department
foreach (glob("../services/department/*/*.php") as $filename) {
    require $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/department/*.php") as $filename){
    require $filename;
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
        default: {
            http_response_code(500);
            echo responseEntity(new Exception("Unknown Request"));
        }
        break;
}
}catch(Exception $e){  
    echo responseEntity($e);
} 