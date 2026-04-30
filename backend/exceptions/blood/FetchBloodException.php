<?php
class FetchBloodException extends Exception {
    private const message = "Error while getting blood type data.";
    private const int status = 500; // HTTP Status Code
    function __construct(string $message = self::message, int $code = self::status){
        return parent::__construct($message, $code);
    }
}
?>