<?php

class FetchBillException extends Exception {
    public function __construct($message = "Could not fetch bill data", $code = 500) {
        parent::__construct($message, $code);
    }
}
