<?php

    use FFI\Exception;

    class UserNotFoundException extends Exception {
        protected $code = 400;
        protected $message = 'User Not Found';
        function __construct(){
            return parent::__construct($this->message, $this->code, null);
        }
    }