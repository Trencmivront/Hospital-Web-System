<?php
class FetchBloodException extends Exception {
    function __construct(){
        return parent::__construct("Error while getting blood type data.", 500);
    }
}
?>