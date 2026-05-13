<?php
    class NullPhoneNumException extends Exception{
        function __construct(){
            parent::__construct('Phone Number Can\'t be Empty', 400, null);
        }
    }