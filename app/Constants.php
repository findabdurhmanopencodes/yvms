<?php
namespace App;

use Andegna\DateTimeFactory;

class Constants {

    const REGIONAL_COORDINATOR = 'regional-coordinator';
    const ZONE_COORDINATOR = 'zone-coordinator';
    const WOREDA_COORDINATOR = 'regional-coordinator';
    const CENTER_COORDINATOR = 'regional-coordinator';
    const CO_FACILITATOR = 'regional-coordinator';
    const SYSTEM_USER = 'system-user';
    const VOLUNTEER = 'volunteer';
    const SUPER_ADMIN = 'super-admin';
    const DESK = 'desk';
    const GENERAL = 'general';
    const ADMIN = 'admin';


    const VOLUNTEER_STATUS_DOCUMENT_VERIFIED = 1;
    const VOLUNTEER_STATUS_REJECTED = 2;
    const VOLUNTEER_STATUS_SELECTED = 3;
    const VOLUNTEER_STATUS_PLACED = 4;
    const VOLUNTEER_STATUS_GRADUATED = 6;
    const VOLUNTEER_STATUS_DEPLOYED = 7;
    const VOLUNTEER_STATUS_CHECKEDIN = 5;
    const VOLUNTEER_STATUS_COMPLETED = 8;


    const TRAINING_SESSION_STARTED = 0;
    const TRAINING_SESSION_PLACEMENT_APPROVE = 1;
    const TRAINING_SESSION_GRADUATED = 2;
    const TRAINING_SESSION_DEPLOYMENT_APPROVED = 3;

    const SYSTEM_USER_ROLE= 'system-user';

    const HIERARCHY_REPORT_DRAFT = 0;
    const HIERARCHY_REPORT_SENT = 1;

    static function convertDateToEt($date){
        return DateTimeFactory::fromDateTime($date);
    }
}
