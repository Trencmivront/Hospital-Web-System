<?php

use FFI\Exception;

    class CouldNotRetrievePatientDataException extends Exception{
        protected $code = 500;
        protected $message = "Error While Getting Patient Data";
        function __construct()
        {
            return parent::__construct($this->message, $this->code, null);
        }
    }   