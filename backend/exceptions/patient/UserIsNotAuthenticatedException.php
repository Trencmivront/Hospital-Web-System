<?php

    use FFI\Exception;

    class UserIsNotAuthenticatedException extends Exception {
        protected const code = 403;
        protected const message = 'User Is Not Authenticated';
        function __construct(){
            return parent::__construct($this->message, $this->code, null);
        }
    }