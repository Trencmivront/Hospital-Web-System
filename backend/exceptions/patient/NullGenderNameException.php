<?php
    class NullGenderNameException extends Exception{
        function __construct(){
            parent::__construct('Gender Can\'t be Empty', 400, null);
        }
    }