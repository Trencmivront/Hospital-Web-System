<?php
    class FetchTreatmentsException extends Exception {
        public function __construct($message = "Could not retrieve treatment data", $code = 400) {
            parent::__construct($message, $code);
        }
    }
