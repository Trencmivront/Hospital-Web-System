<?php
    class IncorrectVerificationCodeException extends Exception{
        function __construct(){
            parent::__construct('Invalid Verification Code', 400);
        }
    }