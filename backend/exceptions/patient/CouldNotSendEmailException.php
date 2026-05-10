<?php

use FFI\Exception;

    class CouldNotSendEmailException extends Exception{
        protected const code = 500;
        protected const message = 'Couldn\'t Send Mail to the Provided Email';
        function __construct(){
            return parent::__construct($this->message, $this->code, null);
        }
    }