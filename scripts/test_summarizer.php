#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

$summarizer = new Summarizer();
$event = Event::constructByKey(5);

$text = strip_tags($event->getDescription());
print_r($text);
print_r($summarizer->summary($text));