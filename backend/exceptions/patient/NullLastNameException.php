<?php
    class NullLastNameException extends Exception{
        function __construct(){
            parent::__construct('Last Name Can\'t be Empty', 400, null);
        }
    }