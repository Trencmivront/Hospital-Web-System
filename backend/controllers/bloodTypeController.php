<?php
// I think require is better
require_once '../dbConnect.php';

// include required files
foreach (glob("../services/blood/*/*.php") as $filename) {
    require_once $filename;
}
foreach (glob("../exceptions/blood/*.php") as $filename){
    require_once $filename;
}

$action = $_GET['action'];
$data = [];

try{
    switch($action){
        case 'getBloodTypes' : {
            $data = getBloodTypes($pdo);
            echo responseEntity($data);
        }
        break;
        default: echo responseEntity("Unknown Request", 400);
        break;
    }

}catch(FetchBloodException $e){
    echo responseEntity($e->getMessage(), $e->getCode());
}
?>