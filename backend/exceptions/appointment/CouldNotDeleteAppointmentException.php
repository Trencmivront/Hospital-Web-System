<?php
    class CouldNotDeleteAppointmentException extends Exception {
        function __construct(){
            parent::__construct("Could Not Delete Appointment", 500);
        }
    }
