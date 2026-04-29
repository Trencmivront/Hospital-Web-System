<?php

    include '../dbConnect.php';

    foreach (glob("../services/blood/*/*.php") as $filename) {
        require_once $filename;
    }
    header("Content-Type: application/json; charset=utf-8");

    $action = $_GET['action'];
    $data = [];

    try{

    }catch(FetchBloodException $e){

    }

?>