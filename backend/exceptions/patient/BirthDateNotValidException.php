<?php
    class BirthDateNotValidException extends Exception {
    function __construct(){
        return parent::__construct("Birth Date Is Not Valid", 400, null);
    }
}