<?php
    class FetchSpecializationException extends Exception{
        public function __construct()
        {return parent::__construct("Error While Getting Specialization Data", 500);}
    }