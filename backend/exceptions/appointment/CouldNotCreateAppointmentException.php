<?php

    class CouldNotCreateAppointmentException extends Exception{
        function __construct(){
            parent::__construct("Error While Creating Appointment", 500);
        }
    }