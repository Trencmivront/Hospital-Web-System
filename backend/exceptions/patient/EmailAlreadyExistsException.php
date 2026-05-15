<?php
    class EmailAlreadyExistsException extends Exception{
        function __construct(){
            parent::__construct('An User With This Email Address Is Already Registered', 409, null);
        }
    }