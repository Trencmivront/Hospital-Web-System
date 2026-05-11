<?php
    class NullEmailException extends Exception{
        function __construct(){
            parent::__construct('Email Can\'t be Empty', 400, null);
        }
    }