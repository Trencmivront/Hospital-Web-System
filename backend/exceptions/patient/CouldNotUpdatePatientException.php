<?php
    class CouldNotUpdatePatientException extends Exception{
        function __construct(){parent::__construct("Error While Updating Patient", 500);}
    }