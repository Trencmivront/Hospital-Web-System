<?php
    require_once '../dbConnect.php';

    foreach(glob("../services/admin/*/*.php") as $fileName){
        require_once $fileName;
    }

    // Load necessary exceptions
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }
    foreach(glob("../exceptions/admin/*.php") as $fileName){
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
                case 'manage_all': {
                    $getAll = new GetAllAdmins();
                    $data = $getAll->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'create': {
                    $create = new CreateAdmin();
                    $data = $create->execute($pdo);
                    echo responseEntity($data, 201);
                }
                break;
                case 'update': {
                    $update = new UpdateAdmin();
                    $data = $update->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'delete': {
                    $delete = new DeleteAdmin();
                    $data = $delete->execute($pdo);
                    echo responseEntity('', 204);
                }
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }
