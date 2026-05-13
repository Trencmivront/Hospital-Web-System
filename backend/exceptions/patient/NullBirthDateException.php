<?php
    class NullBirthDateException extends Exception{
        function __construct(){
            parent::__construct('Birth Date Can\'t be Empty', 400, null);
        }
    }