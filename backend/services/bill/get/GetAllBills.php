<?php

class GetAllBills {
    function execute(PDO $pdo) : array {
        $query = 'SELECT b.bill_id, b.treatment_id, b.cost, b.is_paid, b.update_date, b.update_time 
                  FROM Bill b';

        try {
            $result = $pdo->query($query);
            $data = $result->fetchAll();
            return $data;
        } catch (PDOException $e) {
            throw new CouldNotRetrieveBillDataException();
        }
    }
}
