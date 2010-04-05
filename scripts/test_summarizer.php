#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

$summarizer = new Ev_Summarizer();

$text = file_get_contents($argv[1]);
print_r($text);
print_r($summarizer->summarize($text));
print_r($summarizer->getUnstemmedKeywords());
