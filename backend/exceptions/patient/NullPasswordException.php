<?php

use FFI\Exception;

    class NullPasswordException extends Exception{
        protected const code = 400;
        protected const message = 'Password Can\'t be Empty';
        function __constructor(){
            parent::__construct($this->message, $this->code, null);
        }
    }