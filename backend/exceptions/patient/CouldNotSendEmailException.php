<?php

use FFI\Exception;

    class CouldNotSendEmailException extends Exception{
        protected $code = 500;
        protected $message = 'Couldn\'t Send Mail to the Provided Email';
        function __construct(){
            return parent::__construct(self::$message, self::$code, null);
        }
    }