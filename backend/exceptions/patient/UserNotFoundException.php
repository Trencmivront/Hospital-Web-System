<?php

    use FFI\Exception;

    class UserNotFoundException extends Exception {
        protected const code = 400;
        protected const message = 'User Not Found';
        function __construct(){
            return parent::__construct($this->message, $this->code, null);
        }
    }