<?php
    class UserNotFoundException extends Exception {
        function __construct(){
            return parent::__construct('User Not Found', 404, null);
        }
    }