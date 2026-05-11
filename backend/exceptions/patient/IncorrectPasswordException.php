<?php
    class IncorrectPasswordException extends Exception{
        function __construct(){
            parent::__construct('Password is Incorrect', 400, null);
        }
    }