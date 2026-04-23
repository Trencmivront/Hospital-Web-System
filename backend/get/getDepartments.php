<?php
    include '../dbConnect.php';
    header("Content-Type: application/json; charset=utf-8");

    $query = 'SELECT dept_name, descrpt FROM Department';

    $result = $pdo->query($query);
    // Normally it contains values with index and name at their
    // left side but FETCH_ASSOC removes lines with index, reducing size.
    $data = $result->fetchAll(PDO::FETCH_ASSOC); // Gets array of elements.
    // Returns json type of the value so that JS can process it easily.
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>