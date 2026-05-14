<?php
    class IncorrectPasswordOrEmailException extends Exception{
        function __construct(){
            parent::__construct('Email or Password is Incorrect', 400, null);
        }
    }