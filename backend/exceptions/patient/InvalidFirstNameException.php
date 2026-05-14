<?php
    class InvalidFirstNameException extends Exception{
        function __construct(){
            parent::__construct('First Name Must Contain Only Letters and Be At Least 2 Characters Long', 400, null);
        }
    }