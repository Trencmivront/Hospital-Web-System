<?php
    class NullInputsException extends Exception{
        function __construct()
        {parent::__construct("Some Inputs Are Missing", 400);}
    }