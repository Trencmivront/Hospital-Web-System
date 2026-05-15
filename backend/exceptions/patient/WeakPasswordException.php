<?php
    class WeakPasswordException extends Exception{
        function __construct(){
            parent::__construct('Password Must Be At Least 8 Characters Long and Include Both Letters And Numbers', 400, null);
        }
    }