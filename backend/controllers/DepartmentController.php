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

class DepartmentController {
    function execute($action = ''){
        global $pdo;
        $data = [];
        switch($action){
            case 'all':{
                // if no exception, then
                // turn dataset into json form;
                $getDepartments = new GetDepartments();
                $data = $getDepartments->execute($pdo);
                echo responseEntity($data);
            };
            break;

            case 'byName':{
                $filterDepartmentsByName = new FilterDepartmentsByName();
                $data = $filterDepartmentsByName->execute($pdo);
                echo responseEntity($data);
            };
            break;
            default: echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
