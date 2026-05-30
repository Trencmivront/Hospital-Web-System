<?php
    require_once '../dbConnect.php';

    foreach(glob("../services/bill/*/*.php") as $fileName){
        require_once $fileName;
    }

    foreach(glob("../exceptions/bill/*.php") as $fileName){
        require_once $fileName;
    }

    // Ensure patient exceptions are loaded
    foreach(glob("../exceptions/patient/*.php") as $fileName){
        require_once $fileName;
    }

    class BillController {
        function execute($action = ''){
            global $pdo;
            $data = [];
            switch($action){
                case 'all':{
                    $getAllBills = new GetAllBills();
                    $data = $getAllBills->execute($pdo);
                    echo responseEntity($data);
                };
                break;
                case 'monthlyRevenue':{
                    $getPayedBillsByMonth = new GetPayedBillsByMonth();
                    $data = $getPayedBillsByMonth->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'ofPatient':{
                    $getBillsOfPatient = new GetBillsOfPatient();
                    $data = $getBillsOfPatient->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                case 'pay':{
                    $payBillById = new PayBillById();
                    $data = $payBillById->execute($pdo);
                    echo responseEntity($data);
                }
                break;
                default:
                    echo responseEntity("Unknown Request", 404);
                break;
            }
        }
    }