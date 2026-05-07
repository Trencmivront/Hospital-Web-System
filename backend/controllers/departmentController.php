<?php

require_once '../dbConnect.php';
// load all php files inside services/department
foreach (glob("../services/department/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/department/*.php") as $filename){
    require_once $filename;
}

$action = $_GET['action'];

$data = [];

// catching all exceptions
try{
    switch($action){
        case 'getDepartments':{
            // if no exception, then
            // turn dataset into json form;
            $data = getDepartments($pdo);
            echo responseEntity($data);
        };
        break;

        case 'filterDepartmentsByName':{
            $data = filterDepartmentsByName($pdo);
            echo responseEntity($data);
        };
        break;
        default: echo responseEntity("Unknown Request", 400);
        break;
}
}catch(FetchDepartmentsException $e){ 
    echo responseEntity($e->getMessage(), $e->getCode());
} 