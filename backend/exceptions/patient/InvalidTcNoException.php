<?php
    class InvalidTcNoException extends Exception{
        function __construct(){
            parent::__construct('TC No Must Be Exactly 11 Digits', 400, null);
        }
    }