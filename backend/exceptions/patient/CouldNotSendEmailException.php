<?php
    class CouldNotSendEmailException extends Exception{
        function __construct(){
            return parent::__construct('Couldn\'t Send Mail to the Provided Email', 500, null);
        }
    }