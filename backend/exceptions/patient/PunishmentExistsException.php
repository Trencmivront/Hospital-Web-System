<?php

    class PunishmentExistsException extends Exception{
        function __construct(){return parent::__construct("You Have Punishments", 400);}}