<?php
    class InvalidLastNameException extends Exception{
        function __construct(){
            parent::__construct('Last Name Must Contain Only Letters and Be At Least 2 Characters Long', 400, null);
        }
    }