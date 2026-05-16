<?php
    class PasswordLengthException extends Exception{
        function __construct(){
            parent::__construct('Password Length Must be Between 8-16', 400);
        }
    }