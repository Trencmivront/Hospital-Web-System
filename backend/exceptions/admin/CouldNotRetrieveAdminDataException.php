<?php
    class CouldNotRetrieveAdminDataException extends Exception{
        function __construct(){
            parent::__construct('Error While Getting Admin Data', 500);
        }
    }