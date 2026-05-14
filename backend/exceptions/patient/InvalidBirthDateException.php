<?php
    class InvalidBirthDateException extends Exception{
        function __construct(){
            parent::__construct('The Provided Birth Date Is Invalid or In The Future', 400, null);
        }
    }