<?php
    class NullFirstNameException extends Exception{
        function __construct(){
            parent::__construct('First Name Can\'t be Empty', 400, null);
        }
    }