<?php
    class CouldNotRetrievePatientDataException extends Exception{
        function __construct()
        {
            return parent::__construct("Error While Getting Patient Data", 500, null);
        }
    }   
    