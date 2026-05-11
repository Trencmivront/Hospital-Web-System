<?php
class FetchDepartmentsException extends Exception {
    function __construct(){
        return parent::__construct("Error while getting department data.", 500);
    }
}
?>