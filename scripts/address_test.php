#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

$events = new Event_Collection();
$events->load();
foreach ($events as $event)
{
	$text = strip_tags($event->getName()) . ' ' . strip_tags($event->getDescription());
	$addressArray = Ev_Address::stringToAddress($text, true);
	print_r($addressArray);
}
