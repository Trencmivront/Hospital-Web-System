<?php
    class CouldNotCancelAppointmentException extends Exception {
        public function __construct($message = "Appointment is not ACTIVE and cannot be cancelled", $code = 400) {
            parent::__construct($message, $code);
        }
    }
