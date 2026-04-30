<?php
function getGenders(PDO $pdo) : array {
    $query = 'SELECT gender_name FROM gender';

    $result = $pdo->query($query);

    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}
?>