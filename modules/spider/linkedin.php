#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$spider = new Ev_EventlyLinkedinSpider();
$spider->spider();
