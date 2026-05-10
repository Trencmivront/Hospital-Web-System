<?php

use FFI\Exception;
    class CouldNotRetrieveAppointmentDataException extends Exception{
        protected const code = 500;
        protected const message = 'Error While Getting Appointment Data';
        function __constructor(){
            parent::__construct($this->message, $this->code, null);
        }
    }