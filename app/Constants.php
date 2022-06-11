<?php
namespace App;

use Andegna\DateTimeFactory;

class Constants {

    const VOLUNTEER_STATUS_PLACED = 4;
    const VOLUNTEER_STATUS_GRADUATED = 6;
    const VOLUNTEER_STATUS_DEPLOYED = 7;
    const VOLUNTEER_STATUS_CHECKEDIN = 5;

    const TRAINING_SESSION_STARTED = 0;
    const TRAINING_SESSION_PLACEMENT_APPROVE = 1;
    const TRAINING_SESSION_GRADUATED = 2;

    const HIERARCHY_REPORT_DRAFT = 0;
    const HIERARCHY_REPORT_SENT = 1;

    static function convertDateToEt($date){
        return DateTimeFactory::fromDateTime($date);
    }
}
