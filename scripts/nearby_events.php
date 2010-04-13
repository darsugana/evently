#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');
/*
"latitude":30.3767,
"longitude":-97.7592
*/


$events = new Event_Collection();
$events->loadNearby(30.3767,-97.7592,2);
print_r($events);