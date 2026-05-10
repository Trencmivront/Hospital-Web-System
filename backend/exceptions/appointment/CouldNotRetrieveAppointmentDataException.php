<?php
    class CouldNotRetrieveAppointmentDataException extends Exception{
        function __construct(){
            parent::__construct('Error While Getting Appointment Data', 500, null);
        }
    }