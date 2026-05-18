<?php
    require_once '../dbConnect.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    foreach(glob("../services/admin/*/*.php") as $fileName){
        require_once $fileName;
    }

    // Load necessary exceptions
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    class AdminController {
        function execute($action = ''){
            global $pdo;
            $data = [];
            switch($action){
                case 'login': {
                    $login = new Login();
                    $data = $login->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'logout': {
                    $logout = new Logout();
                    $data = $logout->execute();
                    echo responseEntity($data);
                }
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }
