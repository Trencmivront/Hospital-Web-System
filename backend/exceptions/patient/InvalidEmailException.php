<?php
    class InvalidEmailException extends Exception{
        function __construct(){
            parent::__construct('The Provided Email Address Is Not In A Valid Format', 400, null);
        }
    }