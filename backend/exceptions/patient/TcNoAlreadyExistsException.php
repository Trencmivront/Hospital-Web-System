<?php
    class TcNoAlreadyExistsException extends Exception{
        function __construct(){
            parent::__construct('An User With This TC No Is Already Registered', 409, null);
        }
    }