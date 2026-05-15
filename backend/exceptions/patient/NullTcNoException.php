<?php
    class NullTcNoException extends Exception{
        function __construct(){
            parent::__construct('TC No Can\'t be Empty', 400, null);
        }
    }