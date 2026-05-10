<?php

use FFI\Exception;

    class NullEmailException extends Exception{
        protected const code = 400;
        protected const message = 'Email Can\'t be Empty';
        function __constructor(){
            parent::__construct($this->message, $this->code, null);
        }
    }