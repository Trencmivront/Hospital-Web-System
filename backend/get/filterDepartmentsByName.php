<?php

    include "../dbConnect.php";
    
    header("Content-Type: application/json; charset=utf-8");
    $name = $_GET["name"];

    $query = "SELECT dept_name, descrpt FROM department
    WHERE dept_name LIKE '%$name%'";

    $result = $pdo->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>