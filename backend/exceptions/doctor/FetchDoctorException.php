<?php
class FetchDoctorException extends Exception {
    function __construct(){
        return parent::__construct("Error while getting doctor data.", 500, null);
    }
}

?>