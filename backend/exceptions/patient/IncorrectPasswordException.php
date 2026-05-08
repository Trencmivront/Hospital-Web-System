<?php

use FFI\Exception;

    class IncorrectPasswordException extends Exception{
        protected $code = 400;
        protected $message = 'Password is Incorrect';
        function __constructor(){
            parent::__construct(self::$message, self::$code, null);
        }
    }