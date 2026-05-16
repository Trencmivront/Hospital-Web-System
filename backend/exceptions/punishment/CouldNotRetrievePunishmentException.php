<?php
class CouldNotRetrievePunishmentException extends Exception {
    function __construct(){parent::__construct("Error While Getting Punishment Data", 500);}
}
