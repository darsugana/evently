#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

$summarizer = new Ev_Summarizer();
$event = Event::constructByKey(5);

$text = $event->getName() . "\n" . strip_tags($event->getDescription());
print_r($text);
print_r($summarizer->summarize($text));
print_r($summarizer->getUnstemmedKeywords());
