<?php
    class NullBloodIdException extends Exception{
        function __construct(){
            parent::__construct('Blood Type Can\'t be Empty', 400, null);
        }
    }