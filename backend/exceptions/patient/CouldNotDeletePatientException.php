<?php
    class CouldNotDeletePatientException extends Exception{
        function __construct(){parent::__construct("Error While Deleting Patient", 500);}
    }