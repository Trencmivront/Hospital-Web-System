<?php
    class InvalidPhoneNumException extends Exception{
        function __construct(){
            parent::__construct('The Phone Number Format Is Invalid', 400, null);
        }
    }