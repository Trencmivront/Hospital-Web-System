<?php

class FetchScheduleException extends Exception {
    public function __construct($message = "Could not fetch schedule data.", $code = 500) {
        parent::__construct($message, $code);
    }
}
