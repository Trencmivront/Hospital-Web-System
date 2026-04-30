<?php

require '../dbConnect.php';

foreach (glob("../services/gender/*/*.php") as $filename) {
    require_once $filename;
}
// load all exceptions regarding to this table
foreach(glob("../exceptions/gender/*.php") as $filename){
    require_once $filename;
}
header("Content-Type: application/json; charset=utf-8");

$action = $_GET['action'];

$data = [];

try{

switch($action){

    case 'getGenders' : {
        $data = getGenders($pdo);

        http_response_code(200);
        echo responseEntity($data);
    };
    break;
}

}catch(FetchGenderException $e){
    http_response_code($e->getCode());
    echo responseEntity($e->getMessage());
}
?>