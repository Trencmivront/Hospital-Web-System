<?php
require_once '../dbConnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

foreach (glob("../services/bill/*/*.php") as $filename) {
    require_once $filename;
}

foreach (glob("../exceptions/bill/*.php") as $filename) {
    require_once $filename;
}

// Ensure patient exceptions are loaded (for UserIsNotAuthenticatedException)
foreach (glob("../exceptions/patient/*.php") as $filename) {
    require_once $filename;
}

class BillController {
    function execute($action = '') {
        global $pdo;
        $data = [];
        switch ($action) {
            case 'all': {
                $getAllBills = new GetAllBills();
                $data = $getAllBills->execute($pdo);
                echo responseEntity($data);
            }
            break;

            case 'monthlyRevenue': {
                $getPayedBillsByMonth = new GetPayedBillsByMonth();
                $data = $getPayedBillsByMonth->execute($pdo);
                echo responseEntity($data);
            }
            break;

            default: 
                echo responseEntity("Unknown Request", 404);
            break;
        }
    }
}
