<?php
    class NullPasswordException extends Exception{
        function __construct(){
            parent::__construct('Password Can\'t be Empty', 400, null);
        }
    }