<?php
    class UserIsNotAuthenticatedException extends Exception {
        function __construct(){
            return parent::__construct('User Is Not Authenticated', 403, null);
        }
    }